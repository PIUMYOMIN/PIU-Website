<?php

namespace App\Support;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Curriculum;
use App\Models\Grading;
use App\Models\Module;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;

class TeacherCourseAccess
{
    public static function isTeacher(User $user): bool
    {
        return $user->hasRole('teacher|faculty');
    }

    public static function bypassesScope(User $user): bool
    {
        return $user->hasRole('admin|registrar');
    }

    /** @return int[] */
    public static function assignedCourseIds(User $user): array
    {
        if (!self::isTeacher($user)) {
            return [];
        }

        return $user->teachingCourses()
            ->pluck('courses.id')
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();
    }

    public static function canAccessCourse(User $user, int $courseId): bool
    {
        if (self::bypassesScope($user)) {
            return true;
        }

        if (!self::isTeacher($user)) {
            return false;
        }

        return in_array($courseId, self::assignedCourseIds($user), true);
    }

    public static function ensureCourseAccess(User $user, int $courseId): void
    {
        if (!self::canAccessCourse($user, $courseId)) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'You do not have access to this program.',
            ], 403));
        }
    }

    public static function scopeCourses(User $user, Builder $query): Builder
    {
        if (self::bypassesScope($user) || !self::isTeacher($user)) {
            return $query;
        }

        $ids = self::assignedCourseIds($user);

        return $query->whereIn('id', $ids ?: [-1]);
    }

    public static function scopeStudents(User $user, Builder $query): Builder
    {
        if (self::bypassesScope($user) || !self::isTeacher($user)) {
            return $query;
        }

        $ids = self::assignedCourseIds($user);

        return $query->whereIn('course_id', $ids ?: [-1]);
    }

    public static function scopeAssignments(User $user, Builder $query): Builder
    {
        if (self::bypassesScope($user) || !self::isTeacher($user)) {
            return $query;
        }

        $ids = self::assignedCourseIds($user);

        return $query->whereIn('course_id', $ids ?: [-1]);
    }

    public static function scopeCurriculums(User $user, Builder $query): Builder
    {
        if (self::bypassesScope($user) || !self::isTeacher($user)) {
            return $query;
        }

        $ids = self::assignedCourseIds($user);

        return $query->whereIn('course_id', $ids ?: [-1]);
    }

    public static function scopeModulesForTeacher(User $user, Builder $query): Builder
    {
        if (self::bypassesScope($user) || !self::isTeacher($user)) {
            return $query;
        }

        $ids = self::assignedCourseIds($user);
        if ($ids === []) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where(function (Builder $inner) use ($ids) {
            $inner->whereHas('curriculums', fn (Builder $q) => $q->whereIn('course_id', $ids))
                ->orWhereHas('assignments', fn (Builder $q) => $q->whereIn('course_id', $ids));
        });
    }

    public static function scopeGradings(User $user, Builder $query): Builder
    {
        if (self::bypassesScope($user) || !self::isTeacher($user)) {
            return $query;
        }

        $ids = self::assignedCourseIds($user);

        return $query->whereIn('course_id', $ids ?: [-1]);
    }

    public static function ensureAssignmentAccess(User $user, Assignment $assignment): void
    {
        self::ensureCourseAccess($user, (int) $assignment->course_id);
    }

    public static function ensureStudentAccess(User $user, Student $student): void
    {
        if (!$student->course_id) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Student is not enrolled in a program.',
            ], 403));
        }

        self::ensureCourseAccess($user, (int) $student->course_id);
    }

    public static function ensureAssignmentOwnership(User $user, Assignment $assignment): void
    {
        self::ensureAssignmentAccess($user, $assignment);

        if (self::bypassesScope($user) || !self::isTeacher($user)) {
            return;
        }

        if ((int) $assignment->user_id !== (int) $user->id) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'You can only modify or delete assignments you created.',
            ], 403));
        }
    }

    public static function ensureGradingAccess(User $user, Grading $grading): void
    {
        self::ensureCourseAccess($user, (int) $grading->course_id);
    }
}
