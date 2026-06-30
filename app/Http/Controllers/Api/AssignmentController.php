<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\User;
use App\Support\TeacherCourseAccess;
use App\Models\StudentAssignment;
use App\Models\Course;
use App\Models\Module;
use App\Models\Subject;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $assignmentQuery = Assignment::with(['course', 'module', 'subject'])->latest();
        $courseQuery = \App\Models\Course::query();
        $moduleQuery = Module::query();

        if ($user instanceof User) {
            $assignmentQuery = TeacherCourseAccess::scopeAssignments($user, $assignmentQuery);
            $courseQuery = TeacherCourseAccess::scopeCourses($user, $courseQuery);
            $moduleQuery = TeacherCourseAccess::scopeModulesForTeacher($user, $moduleQuery);
        }

        $studentAssignmentQuery = StudentAssignment::with(['student', 'assignment'])->latest();
        if ($user instanceof User && TeacherCourseAccess::isTeacher($user) && !TeacherCourseAccess::bypassesScope($user)) {
            $courseIds = TeacherCourseAccess::assignedCourseIds($user);
            $studentAssignmentQuery
                ->whereHas('assignment', fn ($q) => $q->whereIn('course_id', $courseIds ?: [-1]))
                ->whereHas('student', fn ($q) => $q->whereIn('course_id', $courseIds ?: [-1]));
        }

        return response()->json([
            'success' => true,
            'data' => [
                'assignments' => $assignmentQuery->get(),
                'student_assignments' => $studentAssignmentQuery->get(),
                'courses' => $courseQuery->get(),
                'modules' => $moduleQuery->get(),
                'subjects' => Subject::all(),
            ],
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|unique:assignments,name',
                'description' => 'nullable|string',
                'course_id' => 'required|integer',
                'module_id' => 'required|integer',
                'subject_id' => 'nullable|integer',
                'attach_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            ]);

            $data['slug'] = Str::slug($data['name']);
            $data['user_id'] = auth()->id();

            $user = auth()->user();
            if ($user instanceof User) {
                TeacherCourseAccess::ensureCourseAccess($user, (int) $data['course_id']);
            }

            if ($request->hasFile('attach_file')) {
                $data['attach_file'] = $request->file('attach_file')
                    ->store('assignment_attachments', 'public');
            }

            $assignment = Assignment::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Assignment created successfully',
                'data' => $assignment,
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Assignment creation failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id)
    {
        $assignment = Assignment::with(['course', 'module', 'subject'])
            ->where(function ($query) use ($id) {
                $query->where('id', $id)->orWhere('slug', $id);
            })
            ->firstOrFail();

        $user = auth()->user();
        if ($user instanceof User) {
            TeacherCourseAccess::ensureAssignmentAccess($user, $assignment);
        }

        return response()->json([
            'success' => true,
            'data' => $assignment,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        try {
            $assignment = Assignment::findOrFail($id);
            $user = auth()->user();
            if ($user instanceof User) {
                TeacherCourseAccess::ensureAssignmentAccess($user, $assignment);
            }

            $data = $request->validate([
                'name' => [
                    'sometimes',
                    'string',
                    Rule::unique('assignments', 'name')->ignore($assignment->id),
                ],
                'description' => 'nullable|string',
                'course_id' => 'nullable|integer',
                'module_id' => 'nullable|integer',
                'subject_id' => 'nullable|integer',
                'attach_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            ]);

            if (isset($data['course_id']) && $user instanceof User) {
                TeacherCourseAccess::ensureCourseAccess($user, (int) $data['course_id']);
            }

            if (isset($data['name'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            if ($request->hasFile('attach_file')) {
                if ($assignment->attach_file) {
                    Storage::disk('public')->delete($assignment->attach_file);
                }

                $data['attach_file'] = $request->file('attach_file')
                    ->store('assignment_attachments', 'public');
            }

            $data['user_id'] = auth()->id();
            $assignment->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Assignment updated successfully',
                'data' => $assignment,
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Assignment update failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        $assignment = Assignment::findOrFail($id);
        $user = auth()->user();
        if ($user instanceof User) {
            TeacherCourseAccess::ensureAssignmentAccess($user, $assignment);
        }

        if ($assignment->attach_file) {
            Storage::disk('public')->delete($assignment->attach_file);
        }

        $assignment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Assignment deleted successfully',
        ], 200);
    }
}

