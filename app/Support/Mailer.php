<?php

namespace App\Support;

class Mailer
{
    public const FALLBACK_FROM_ADDRESS = 'piu.edu2014@gmail.com';
    public const FALLBACK_FROM_NAME = 'Phaung Daw Oo International University';

    public static function fromAddress(): string
    {
        $address = trim((string) config('mail.from.address', ''));

        if ($address !== '' && filter_var($address, FILTER_VALIDATE_EMAIL)) {
            return $address;
        }

        return self::FALLBACK_FROM_ADDRESS;
    }

    public static function fromName(): string
    {
        $name = trim((string) config('mail.from.name', ''));

        return $name !== '' ? $name : self::FALLBACK_FROM_NAME;
    }

    public static function normalizeEmails(array $emails): array
    {
        $out = [];

        foreach ($emails as $email) {
            $email = trim((string) $email);
            if ($email === '') {
                continue;
            }

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $out[] = strtolower($email);
            }
        }

        return array_values(array_unique($out));
    }

    public static function frontendUrl(string $path = ''): string
    {
        $base = rtrim((string) env('FRONTEND_URL', 'https://www.piueducation.org'), '/');
        $path = $path !== '' ? '/' . ltrim($path, '/') : '';

        return $base . $path;
    }

    public static function admissionAdminRecipients(): array
    {
        return self::normalizeEmails((array) config('admissions.admin_recipients', []));
    }

    public static function admissionCcRecipients(?string $programManagerEmail = null): array
    {
        $cc = self::normalizeEmails((array) config('admissions.cc_recipients', []));

        if ($programManagerEmail) {
            $cc[] = $programManagerEmail;
        }

        return self::normalizeEmails($cc);
    }

    public static function programManagerEmail(int $courseId): ?string
    {
        $map = (array) config('admissions.program_managers', []);
        $email = $map[$courseId] ?? config('admissions.default_program_manager');

        if (!$email) {
            return null;
        }

        $email = trim((string) $email);

        return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null;
    }

    public static function contactRecipients(): array
    {
        $to = self::normalizeEmails(array_merge(
            self::admissionAdminRecipients(),
            (array) config('mail.contact_recipients', ['piu.edu2014@gmail.com'])
        ));

        if (empty($to)) {
            $to = [self::fromAddress()];
        }

        $cc = array_values(array_diff(self::admissionCcRecipients(), $to));

        return compact('to', 'cc');
    }

    public static function admissionMailTargets(int $courseId): array
    {
        $programManager = self::programManagerEmail($courseId);
        $to = self::admissionAdminRecipients();
        $cc = self::admissionCcRecipients($programManager);

        if (empty($to) && !empty($cc)) {
            $to = [array_shift($cc)];
        }

        if (empty($to)) {
            $to = [self::fromAddress()];
        }

        $cc = array_values(array_diff(self::normalizeEmails($cc), $to));

        return [
            'to' => $to,
            'cc' => $cc,
            'program_manager' => $programManager,
        ];
    }
}
