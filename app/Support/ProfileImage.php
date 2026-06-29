<?php

namespace App\Support;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileImage
{
    public const DEFAULT_STAFF_PATH = 'img/profile.png';

    public static function urlForUser(User $user): ?string
    {
        return self::resolve($user->picture ?? null);
    }

    public static function urlForStudent(Student $student): ?string
    {
        return self::resolve($student->profile ?? null);
    }

    public static function resolve(?string $path): ?string
    {
        if (!$path || trim($path) === '') {
            return null;
        }

        $path = trim($path);

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        if ($path === self::DEFAULT_STAFF_PATH) {
            return asset(self::DEFAULT_STAFF_PATH);
        }

        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        if (Storage::disk('public')->exists($path)) {
            return asset('storage/' . ltrim($path, '/'));
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    public static function isDeletableStoredPath(?string $path): bool
    {
        if (!$path || filter_var($path, FILTER_VALIDATE_URL)) {
            return false;
        }

        return $path !== self::DEFAULT_STAFF_PATH;
    }
}
