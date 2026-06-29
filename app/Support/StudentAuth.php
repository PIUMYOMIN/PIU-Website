<?php

namespace App\Support;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentAuth
{
    /**
     * Length of the random temporary password generated for new students.
     * Long enough to resist guessing/brute force, short enough to read
     * aloud or write on a printed admission letter.
     */
    private const TEMP_PASSWORD_LENGTH = 10;

    /**
     * Generate a unique, random temporary password for a newly created
     * student account.
     *
     * IMPORTANT: This replaces the old shared "piustudent" default.
     * Every student now gets their own random password, generated once
     * at creation time. The caller (AdminStudentController) is
     * responsible for displaying this value ONCE to the registrar/admin
     * so it can be handed to the student — it is never stored in
     * plaintext and never logged.
     */
    public static function generateTemporaryPassword(): string
    {
        // Avoid visually ambiguous characters (0/O, 1/l/I) so it's easy
        // to read off a printed sheet or read aloud.
        $alphabet = 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';

        $password = '';
        for ($i = 0; $i < self::TEMP_PASSWORD_LENGTH; $i++) {
            $password .= $alphabet[random_int(0, strlen($alphabet) - 1)];
        }

        return $password;
    }

    /**
     * Verify a student's portal login password.
     *
     * No shared/default password fallback — every account's hash is
     * unique, whether it's still the registrar-issued temporary
     * password or one the student has since changed.
     */
    public static function verifyPortalPassword(Student $student, string $password): bool
    {
        $hash = (string) $student->password;
        if ($hash === '') {
            return false;
        }

        return Hash::check($password, $hash);
    }

    /**
     * Set a student's password and mark it as a registrar-issued
     * temporary password that must be changed on first login.
     */
    public static function setTemporaryPassword(Student $student, string $plainPassword): void
    {
        $student->forceFill([
            'password' => Hash::make($plainPassword),
            'must_change_password' => true,
        ])->save();
    }

    /**
     * Set a student's password as their own permanent choice
     * (clears the forced-change flag).
     */
    public static function setOwnPassword(Student $student, string $plainPassword): void
    {
        $student->forceFill([
            'password' => Hash::make($plainPassword),
            'must_change_password' => false,
        ])->save();
    }

    public static function mustChangePassword(Student $student): bool
    {
        return (bool) $student->must_change_password;
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
            'must_change_password' => self::mustChangePassword($student),
            'role' => 'student',
            'roles' => ['student'],
            'account_type' => 'student',
            'created_at' => $student->created_at,
            'updated_at' => $student->updated_at,
        ];
    }
}
