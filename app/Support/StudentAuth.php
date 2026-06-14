<?php

namespace App\Support;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentAuth
{
    public const DEFAULT_PASSWORD = 'piustudent';

    /** @deprecated Legacy admin panel default; kept for existing student records. */
    public const LEGACY_DEFAULT_PASSWORD = 'piustudent2024';

    public static function verifyPortalPassword(Student $student, string $password): bool
    {
        $hash = (string) $student->password;
        if ($hash === '') {
            return false;
        }

        if (Hash::check($password, $hash)) {
            return true;
        }

        // Stored hash may still be the legacy default while the UI shows the new default.
        if ($password === self::DEFAULT_PASSWORD && Hash::check(self::LEGACY_DEFAULT_PASSWORD, $hash)) {
            return true;
        }

        return false;
    }

    public static function usesLegacyDefaultPassword(Student $student): bool
    {
        $hash = (string) $student->password;
        if ($hash === '') {
            return false;
        }

        return Hash::check(self::LEGACY_DEFAULT_PASSWORD, $hash)
            && !Hash::check(self::DEFAULT_PASSWORD, $hash);
    }

    public static function normalizePortalPassword(Student $student): void
    {
        $student->forceFill([
            'password' => Hash::make(self::DEFAULT_PASSWORD),
        ])->save();
    }

    public static function formatForApi(Student $student): array
    {
        $student->loadMissing(['course.category', 'year']);
        $fullName = trim((string) (($student->fname ?? '') . ' ' . ($student->lname ?? '')));

        return [
            'id' => $student->id,
            'name' => $fullName !== '' ? $fullName : 'Student',
            'fname' => $student->fname,
            'lname' => $student->lname,
            'email' => $student->email,
            'phone' => $student->phone,
            'address' => $student->address,
            'city' => $student->city,
            'country' => $student->country,
            'dob' => $student->dob,
            'gender' => $student->gender_sts,
            'dob' => $student->dob,
            'marital_status' => $student->marital_sts,
            'permanent_address' => $student->permanent_address,
            'student_id' => $student->student_id,
            'course_id' => $student->course_id,
            'year_id' => $student->year_id,
            'program' => $student->course?->title,
            'department' => $student->course?->category?->name ?? null,
            'year' => $student->year?->name ?? $student->year_id,
            'is_active' => (bool) $student->is_active,
            'profile' => $student->profile ? asset('storage/' . $student->profile) : null,
            'profile_image' => $student->profile ? asset('storage/' . $student->profile) : null,
            'role' => 'student',
            'roles' => ['student'],
            'account_type' => 'student',
            'created_at' => $student->created_at,
            'updated_at' => $student->updated_at,
        ];
    }
}
