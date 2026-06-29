<?php

namespace App\Console\Commands;

use App\Models\Admission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * One-time data migration: admission documents (national ID scans,
 * personal statements, education certificates, etc.) used to be stored
 * on the public disk before AdmissionController was changed to use the
 * private disk. Any admissions submitted before that change still have
 * their files sitting on the public disk, publicly reachable by URL,
 * and downloadDocument() (which only checks the private disk) 404s for
 * them.
 *
 * This command moves each such file from public to private storage,
 * updates the admission row to point at the new path, and removes the
 * now-stale public copy so it stops being publicly reachable.
 *
 * Usage:
 *   php artisan admissions:migrate-documents-to-private        (live run)
 *   php artisan admissions:migrate-documents-to-private --dry-run
 */
class MigrateAdmissionDocumentsToPrivate extends Command
{
    protected $signature = 'admissions:migrate-documents-to-private {--dry-run}';

    protected $description = 'Move admission documents still sitting on the public disk to the private disk.';

    private const FILE_FIELDS = [
        'language_proficiency',
        'profile',
        'personal_statement',
        'education_certificate',
        'other_document',
    ];

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $moved = 0;
        $alreadyPrivate = 0;
        $missing = 0;

        Admission::query()->chunkById(50, function ($admissions) use (&$moved, &$alreadyPrivate, &$missing, $dryRun) {
            foreach ($admissions as $admission) {
                foreach (self::FILE_FIELDS as $field) {
                    $path = $admission->{$field};
                    if (!$path) {
                        continue;
                    }

                    if (Storage::disk('private')->exists($path)) {
                        // Already migrated (or uploaded after the fix).
                        $alreadyPrivate++;
                        continue;
                    }

                    if (!Storage::disk('public')->exists($path)) {
                        $this->warn("Admission #{$admission->id} [{$field}]: file not found on either disk ({$path}) — skipping.");
                        $missing++;
                        continue;
                    }

                    $this->line("Admission #{$admission->id} [{$field}]: migrating {$path} (public -> private)" . ($dryRun ? ' [dry-run]' : ''));

                    if ($dryRun) {
                        $moved++;
                        continue;
                    }

                    $contents = Storage::disk('public')->get($path);
                    Storage::disk('private')->put($path, $contents);
                    Storage::disk('public')->delete($path);
                    $moved++;
                }
            }
        });

        $this->info("Done. Migrated: {$moved}, already private: {$alreadyPrivate}, missing: {$missing}.");
        if ($dryRun) {
            $this->info('This was a dry run — no files were actually moved. Re-run without --dry-run to apply.');
        }

        return self::SUCCESS;
    }
}
