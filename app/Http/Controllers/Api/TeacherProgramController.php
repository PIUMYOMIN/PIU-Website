<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Curriculum;
use App\Models\Grading;
use App\Models\Module;
use App\Models\Student;
use App\Models\User;
use App\Support\ProfileImage;
use App\Support\StudentAuth;
use App\Support\TeacherCourseAccess;
use Illuminate\Http\Request;

class TeacherProgramController extends Controller
{
    public function dashboard(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $courseIds = TeacherCourseAccess::assignedCourseIds($user);

        if ($courseIds === []) {
            return response()->json([
                'success' => true,
                'assigned_programs' => [],
                'stats' => [
                    'courses' => 0,
                    'modules' => 0,
                    'assignments' => 0,
                    'students' => 0,
                ],
                'recent_assignments' => [],
            ]);
        }

        $courses = Course::with('category')->whereIn('id', $courseIds)->get();
        $assignments = Assignment::with(['course', 'module'])
            ->whereIn('course_id', $courseIds)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'assigned_programs' => $courses,
            'stats' => [
                'courses' => $courses->count(),
                'modules' => TeacherCourseAccess::scopeModulesForTeacher($user, Module::query())->count(),
                'assignments' => $assignments->count(),
                'students' => Student::whereIn('course_id', $courseIds)->count(),
            ],
            'recent_assignments' => $assignments->take(5)->values(),
        ]);
    }

    public function courses(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $courses = TeacherCourseAccess::scopeCourses($user, Course::with('category'))
            ->orderBy('title')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $courses,
        ]);
    }

    public function students(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $query = TeacherCourseAccess::scopeStudents($user, Student::with(['course', 'year']));

        if ($request->filled('course_id')) {
            $courseId = (int) $request->input('course_id');
            TeacherCourseAccess::ensureCourseAccess($user, $courseId);
            $query->where('course_id', $courseId);
        }

        $students = $query->latest()->get()->map(function (Student $student) {
            $formatted = StudentAuth::formatForApi($student);

            return array_merge($formatted, [
                'name' => $formatted['name'],
                'course' => $student->course,
                'year' => $student->year,
            ]);
        });

        return response()->json([
            'success' => true,
            'data' => $students,
        ]);
    }

    public function modules(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $query = TeacherCourseAccess::scopeModulesForTeacher($user, Module::withCount([
            'curriculums',
            'assignments',
        ]));

        if ($request->filled('course_id')) {
            $courseId = (int) $request->input('course_id');
            TeacherCourseAccess::ensureCourseAccess($user, $courseId);
            $query->where(function ($inner) use ($courseId) {
                $inner->whereHas('curriculums', fn ($q) => $q->where('course_id', $courseId))
                    ->orWhereHas('assignments', fn ($q) => $q->where('course_id', $courseId));
            });
        }

        return response()->json([
            'success' => true,
            'data' => $query->latest()->get(),
        ]);
    }

    public function assignments(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $query = TeacherCourseAccess::scopeAssignments(
            $user,
            Assignment::with(['course', 'module', 'subject'])
        );

        if ($request->filled('course_id')) {
            $courseId = (int) $request->input('course_id');
            TeacherCourseAccess::ensureCourseAccess($user, $courseId);
            $query->where('course_id', $courseId);
        }

        return response()->json([
            'success' => true,
            'data' => $query->latest()->get(),
        ]);
    }

    public function curriculums(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $query = TeacherCourseAccess::scopeCurriculums(
            $user,
            Curriculum::with(['course:id,title', 'module:id,name,module_code,credit', 'year:id,name'])
        );

        if ($request->filled('course_id')) {
            $courseId = (int) $request->input('course_id');
            TeacherCourseAccess::ensureCourseAccess($user, $courseId);
            $query->where('course_id', $courseId);
        }

        return response()->json([
            'success' => true,
            'data' => $query->latest()->get(),
        ]);
    }
}
