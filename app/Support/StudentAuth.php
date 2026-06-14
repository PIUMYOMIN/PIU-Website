<?php

namespace App\Support;

use App\Models\Student;

class StudentAuth
{
    public const DEFAULT_PASSWORD = 'piustudent';

    public static function formatForApi(Student $student): array
    {
        $fullName = trim((string) (($student->fname ?? '') . ' ' . ($student->lname ?? '')));

        return [
            'id' => $student->id,
            'name' => $fullName !== '' ? $fullName : 'Student',
            'email' => $student->email,
            'phone' => $student->phone,
            'city' => $student->city,
            'country' => $student->country,
            'student_id' => $student->student_id,
            'program' => null,
            'department' => null,
            'year' => $student->year_id,
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
