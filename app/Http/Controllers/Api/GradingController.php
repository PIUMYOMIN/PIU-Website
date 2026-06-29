<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Grading;
use App\Models\Student;
use App\Models\User;
use App\Support\TeacherCourseAccess;
use Illuminate\Http\Request;

class GradingController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $query = TeacherCourseAccess::scopeGradings(
            $user,
            Grading::with(['student', 'course', 'module', 'assignment', 'year'])
        );

        if ($request->filled('course_id')) {
            $courseId = (int) $request->input('course_id');
            TeacherCourseAccess::ensureCourseAccess($user, $courseId);
            $query->where('course_id', $courseId);
        }

        if ($request->filled('student_id')) {
            $student = Student::findOrFail((int) $request->input('student_id'));
            TeacherCourseAccess::ensureStudentAccess($user, $student);
            $query->where('student_id', $student->id);
        }

        return response()->json([
            'success' => true,
            'data' => $query->latest()->get(),
        ]);
    }

    public function forStudent(Request $request, string $studentId)
    {
        /** @var User $user */
        $user = $request->user();
        $student = Student::with(['course', 'year'])->findOrFail($studentId);
        TeacherCourseAccess::ensureStudentAccess($user, $student);

        $grades = TeacherCourseAccess::scopeGradings(
            $user,
            Grading::with(['course', 'module', 'assignment', 'year'])
        )
            ->where('student_id', $student->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'student' => $student,
            'data' => $grades,
        ]);
    }

    public function store(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $data = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'course_id' => 'required|integer|exists:courses,id',
            'assignment_id' => 'required|integer|exists:assignments,id',
            'module_id' => 'required|integer|exists:modules,id',
            'year_id' => 'required|integer|exists:years,id',
            'semester_id' => 'nullable|integer|exists:semesters,id',
            'mark' => 'required|numeric|min:0|max:100',
            'grade_point' => 'required|numeric|min:0|max:4',
            'grade_value' => 'required|string|max:10',
        ]);

        $student = Student::findOrFail((int) $data['student_id']);
        TeacherCourseAccess::ensureStudentAccess($user, $student);
        TeacherCourseAccess::ensureCourseAccess($user, (int) $data['course_id']);

        if ((int) $student->course_id !== (int) $data['course_id']) {
            return response()->json([
                'success' => false,
                'message' => 'Student is not enrolled in the selected program.',
            ], 422);
        }

        $assignment = Assignment::findOrFail((int) $data['assignment_id']);
        if ((int) $assignment->course_id !== (int) $data['course_id']) {
            return response()->json([
                'success' => false,
                'message' => 'Assignment does not belong to the selected program.',
            ], 422);
        }

        $data['user_id'] = $user->id;

        $grading = Grading::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Grade recorded successfully',
            'data' => $grading->load(['student', 'course', 'module', 'assignment', 'year']),
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        /** @var User $user */
        $user = $request->user();
        $grading = Grading::findOrFail($id);
        TeacherCourseAccess::ensureGradingAccess($user, $grading);

        $data = $request->validate([
            'mark' => 'sometimes|numeric|min:0|max:100',
            'grade_point' => 'sometimes|numeric|min:0|max:4',
            'grade_value' => 'sometimes|string|max:10',
            'semester_id' => 'nullable|integer|exists:semesters,id',
        ]);

        $grading->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Grade updated successfully',
            'data' => $grading->fresh()->load(['student', 'course', 'module', 'assignment', 'year']),
        ]);
    }

    public function destroy(Request $request, string $id)
    {
        /** @var User $user */
        $user = $request->user();
        $grading = Grading::findOrFail($id);
        TeacherCourseAccess::ensureGradingAccess($user, $grading);
        $grading->delete();

        return response()->json([
            'success' => true,
            'message' => 'Grade deleted successfully',
        ]);
    }
}
