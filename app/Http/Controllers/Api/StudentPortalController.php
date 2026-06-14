<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Curriculum;
use App\Models\Grading;
use App\Models\Student;
use App\Models\StudentAssignment;
use App\Models\StudentJoinedCourse;
use App\Support\StudentAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentPortalController extends Controller
{
    private function resolveStudent(Request $request): Student
    {
        $user = $request->user();

        if (!$user instanceof Student) {
            abort(403, 'Student portal access only.');
        }

        return $user->loadMissing(['course.category', 'year']);
    }

    public function dashboard(Request $request)
    {
        $student = $this->resolveStudent($request);
        $payload = $this->buildPortalPayload($student);

        return response()->json([
            'success' => true,
            'data' => $payload,
        ]);
    }

    public function grades(Request $request)
    {
        $student = $this->resolveStudent($request);

        return response()->json([
            'success' => true,
            'data' => [
                'student' => StudentAuth::formatForApi($student),
                'grades' => $this->formatGradings($this->gradingQuery($student)->get()),
                'summary' => $this->buildGradeSummary($student),
            ],
        ]);
    }

    public function courses(Request $request)
    {
        $student = $this->resolveStudent($request);

        return response()->json([
            'success' => true,
            'data' => [
                'student' => StudentAuth::formatForApi($student),
                'enrolled_program' => $this->formatEnrolledProgram($student),
                'joined_courses' => $this->formatJoinedCourses($student),
                'curriculum' => $this->formatCurriculum($student),
            ],
        ]);
    }

    public function assignments(Request $request)
    {
        $student = $this->resolveStudent($request);

        return response()->json([
            'success' => true,
            'data' => [
                'student' => StudentAuth::formatForApi($student),
                'assignments' => $this->formatAssignments($student),
            ],
        ]);
    }

    public function submitAssignment(Request $request, int $assignmentId)
    {
        $student = $this->resolveStudent($request);

        $assignment = Assignment::query()
            ->where('id', $assignmentId)
            ->where('course_id', $student->course_id)
            ->firstOrFail();

        $submission = StudentAssignment::query()
            ->where('student_id', $student->id)
            ->where('assignment_id', $assignment->id)
            ->first();

        if ($submission?->is_turned_in) {
            return response()->json([
                'success' => false,
                'message' => 'This assignment has already been submitted.',
            ], 422);
        }

        $validated = $request->validate([
            'body' => 'nullable|string|max:5000',
            'attach_file' => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240',
        ]);

        if (!$submission && empty($validated['body']) && !$request->hasFile('attach_file')) {
            return response()->json([
                'success' => false,
                'message' => 'Please add a response or attach a file before submitting.',
            ], 422);
        }

        $payload = [
            'assignment_id' => $assignment->id,
            'course_id' => $assignment->course_id,
            'module_id' => $assignment->module_id,
            'student_id' => $student->id,
            'body' => $validated['body'] ?? $submission?->body,
            'is_turned_in' => true,
        ];

        if ($request->hasFile('attach_file')) {
            if ($submission?->attach_file) {
                Storage::disk('public')->delete($submission->attach_file);
            }

            $payload['attach_file'] = $request->file('attach_file')
                ->store('student_submited_assignments', 'public');
        }

        if ($submission) {
            $submission->update($payload);
        } else {
            StudentAssignment::create($payload);
        }

        return response()->json([
            'success' => true,
            'message' => 'Assignment submitted successfully',
            'data' => [
                'assignments' => $this->formatAssignments($student),
            ],
        ]);
    }

    public function updateProfile(Request $request)
    {
        $student = $this->resolveStudent($request);

        $data = $request->validate([
            'phone' => 'sometimes|nullable|string|max:20',
            'email' => 'sometimes|email|unique:students,email,' . $student->id,
            'address' => 'sometimes|nullable|string|max:255',
            'permanent_address' => 'sometimes|nullable|string|max:255',
            'city' => 'sometimes|nullable|string|max:100',
            'country' => 'sometimes|nullable|string|max:100',
            'profile' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('profile')) {
            if ($student->profile) {
                Storage::disk('public')->delete($student->profile);
            }

            $data['profile'] = $request->file('profile')->store('students', 'public');
        } else {
            unset($data['profile']);
        }

        $student->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'user' => StudentAuth::formatForApi($student->fresh()->loadMissing(['course.category', 'year'])),
        ]);
    }

    public function changePassword(Request $request)
    {
        $student = $this->resolveStudent($request);

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!StudentAuth::verifyPortalPassword($student, (string) $validated['current_password'])) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect',
            ], 422);
        }

        $student->update([
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully',
        ]);
    }

    private function buildPortalPayload(Student $student): array
    {
        $gradings = $this->gradingQuery($student)->get();
        $assignments = $this->formatAssignments($student);
        $submittedCount = collect($assignments)->where('is_submitted', true)->count();

        return [
            'student' => StudentAuth::formatForApi($student),
            'stats' => [
                'enrolled_program' => $student->course?->title,
                'current_year' => $student->year?->name,
                'modules_in_program' => $this->curriculumQuery($student)->count(),
                'graded_modules' => $gradings->count(),
                'average_gpa' => $this->calculateGpa($gradings),
                'assignments_total' => count($assignments),
                'assignments_submitted' => $submittedCount,
                'attendance_rate' => $student->is_active ? 100 : 0,
                'account_status' => $student->is_active ? 'Active' : 'Inactive',
            ],
            'enrolled_program' => $this->formatEnrolledProgram($student),
            'grade_summary' => $this->buildGradeSummary($student),
            'recent_grades' => array_slice($this->formatGradings($gradings), 0, 5),
            'upcoming_assignments' => array_slice(
                collect($assignments)->where('is_submitted', false)->values()->all(),
                0,
                5
            ),
            'curriculum_preview' => array_slice($this->formatCurriculum($student), 0, 6),
        ];
    }

    private function gradingQuery(Student $student)
    {
        return Grading::query()
            ->with(['course', 'module', 'year', 'semester', 'assignment'])
            ->where('student_id', $student->id)
            ->latest();
    }

    private function curriculumQuery(Student $student)
    {
        return Curriculum::query()
            ->with(['module', 'course', 'year'])
            ->when($student->course_id, fn ($q) => $q->where('course_id', $student->course_id))
            ->when($student->year_id, fn ($q) => $q->where('year_id', $student->year_id));
    }

    private function buildGradeSummary(Student $student): array
    {
        $gradings = $this->gradingQuery($student)->get();

        $grouped = [];
        foreach ($gradings as $grading) {
            $formatted = $this->formatGrading($grading);
            $yearKey = $grading->year?->name ?? ('Year ' . ($grading->year_id ?? 'Unassigned'));
            $semesterKey = $grading->semester?->name
                ?? $grading->semester?->title
                ?? 'General Semester';

            if (!isset($grouped[$yearKey])) {
                $grouped[$yearKey] = [
                    'year_id' => $grading->year_id,
                    'semesters' => [],
                ];
            }

            if (!isset($grouped[$yearKey]['semesters'][$semesterKey])) {
                $grouped[$yearKey]['semesters'][$semesterKey] = [
                    'semester_id' => $grading->semester_id,
                    'grades' => [],
                ];
            }

            $grouped[$yearKey]['semesters'][$semesterKey]['grades'][] = $formatted;
        }

        $yearSummaries = [];
        foreach ($grouped as $yearName => $yearGroup) {
            $allYearGrades = [];
            $semesterSummaries = [];

            foreach ($yearGroup['semesters'] as $semesterName => $semesterGroup) {
                $items = $semesterGroup['grades'];
                $collection = collect($items);
                $allYearGrades = array_merge($allYearGrades, $items);

                $semesterGpa = $this->calculateGpaFromFormatted($collection);

                $semesterSummaries[] = [
                    'semester' => $semesterName,
                    'semester_id' => $semesterGroup['semester_id'],
                    'modules' => count($items),
                    'total_credit' => $this->calculateTotalCreditsFromFormatted($collection),
                    'average_gpa' => $semesterGpa,
                    'grade_value' => $this->gpaToGradeValue($semesterGpa),
                    'grades' => $items,
                ];
            }

            usort($semesterSummaries, fn ($a, $b) => strcmp($a['semester'], $b['semester']));

            $yearCollection = collect($allYearGrades);
            $yearGpa = $this->calculateGpaFromFormatted($yearCollection);

            $yearSummaries[] = [
                'year' => $yearName,
                'year_id' => $yearGroup['year_id'],
                'modules' => count($allYearGrades),
                'total_credit' => $this->calculateTotalCreditsFromFormatted($yearCollection),
                'average_gpa' => $yearGpa,
                'grade_value' => $this->gpaToGradeValue($yearGpa),
                'semesters' => $semesterSummaries,
                'grades' => $allYearGrades,
            ];
        }

        usort($yearSummaries, function ($a, $b) {
            $yearOrder = [
                'First Year' => 1,
                'Second Year' => 2,
                'Third Year' => 3,
                'Fourth Year' => 4,
            ];

            $orderA = $yearOrder[$a['year']] ?? ((int) ($a['year_id'] ?? 99));
            $orderB = $yearOrder[$b['year']] ?? ((int) ($b['year_id'] ?? 99));

            return $orderA <=> $orderB;
        });

        return [
            'total_modules' => $gradings->count(),
            'average_gpa' => $this->calculateGpa($gradings),
            'by_year' => $yearSummaries,
        ];
    }

    private function formatGradings($gradings): array
    {
        return collect($gradings)->map(fn ($grading) => $this->formatGrading($grading))->values()->all();
    }

    private function formatGrading(Grading $grading): array
    {
        return [
            'id' => $grading->id,
            'course' => $grading->course?->title,
            'module_name' => $grading->module?->name,
            'module_code' => $grading->module?->module_code,
            'credit' => $grading->module?->credit,
            'assignment' => $grading->assignment?->name,
            'mark' => $grading->mark,
            'grade_point' => $grading->grade_point,
            'grade_value' => $grading->grade_value,
            'year' => $grading->year?->name,
            'year_id' => $grading->year_id,
            'semester' => $grading->semester?->name ?? $grading->semester?->title,
            'semester_id' => $grading->semester_id,
            'created_at' => $grading->created_at,
        ];
    }

    private function formatEnrolledProgram(Student $student): ?array
    {
        if (!$student->course) {
            return null;
        }

        return [
            'id' => $student->course->id,
            'title' => $student->course->title,
            'description' => $student->course->description,
            'image_url' => $student->course->image_url ?? null,
            'year' => $student->year?->name,
            'year_id' => $student->year_id,
            'joined_at' => $student->created_at,
            'status' => $student->is_active ? 'Enrolled' : 'Inactive',
        ];
    }

    private function formatJoinedCourses(Student $student): array
    {
        return StudentJoinedCourse::query()
            ->with('course')
            ->where('student_id', $student->id)
            ->latest()
            ->get()
            ->map(function (StudentJoinedCourse $row) {
                return [
                    'id' => $row->id,
                    'course_id' => $row->course_id,
                    'title' => $row->course?->title,
                    'joined_at' => $row->joined_at ?? $row->created_at,
                ];
            })
            ->values()
            ->all();
    }

    private function formatCurriculum(Student $student): array
    {
        return $this->curriculumQuery($student)
            ->get()
            ->map(function (Curriculum $item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'description' => $item->description,
                    'module_name' => $item->module?->name,
                    'module_code' => $item->module?->module_code,
                    'credit' => $item->module?->credit,
                    'year' => $item->year?->name,
                    'course' => $item->course?->title,
                ];
            })
            ->values()
            ->all();
    }

    private function formatAssignments(Student $student): array
    {
        if (!$student->course_id) {
            return [];
        }

        $assignments = Assignment::query()
            ->with(['course', 'module', 'subject'])
            ->where('course_id', $student->course_id)
            ->latest()
            ->get();

        $submissions = StudentAssignment::query()
            ->where('student_id', $student->id)
            ->get()
            ->keyBy('assignment_id');

        return $assignments->map(function (Assignment $assignment) use ($submissions) {
            $submission = $submissions->get($assignment->id);

            return [
                'id' => $assignment->id,
                'name' => $assignment->name,
                'description' => $assignment->description,
                'course' => $assignment->course?->title,
                'course_id' => $assignment->course_id,
                'module_id' => $assignment->module_id,
                'module_name' => $assignment->module?->name,
                'module_code' => $assignment->module?->module_code,
                'subject' => $assignment->subject?->name,
                'attach_file' => $assignment->attach_file
                    ? asset('storage/' . ltrim($assignment->attach_file, '/'))
                    : null,
                'submission_id' => $submission?->id,
                'body' => $submission?->body,
                'submitted_file' => $submission?->attach_file
                    ? asset('storage/' . ltrim($submission->attach_file, '/'))
                    : null,
                'is_submitted' => (bool) ($submission?->is_turned_in ?? false),
                'submitted_at' => $submission?->updated_at,
                'created_at' => $assignment->created_at,
            ];
        })->values()->all();
    }

    private function calculateGpa($gradings): ?float
    {
        $collection = collect($gradings);
        if ($collection->isEmpty()) {
            return null;
        }

        $totalCredits = 0;
        $weightedPoints = 0;

        foreach ($collection as $grading) {
            $credit = (float) ($grading->module?->credit ?? 0);
            $point = (float) ($grading->grade_point ?? 0);
            if ($credit <= 0) {
                continue;
            }
            $totalCredits += $credit;
            $weightedPoints += $point * $credit;
        }

        if ($totalCredits <= 0) {
            return null;
        }

        return round($weightedPoints / $totalCredits, 2);
    }

    private function calculateGpaFromFormatted($items): ?float
    {
        $totalCredits = 0;
        $weightedPoints = 0;

        foreach ($items as $item) {
            $credit = (float) ($item['credit'] ?? 0);
            $point = (float) ($item['grade_point'] ?? 0);
            if ($credit <= 0) {
                continue;
            }
            $totalCredits += $credit;
            $weightedPoints += $point * $credit;
        }

        if ($totalCredits <= 0) {
            return null;
        }

        return round($weightedPoints / $totalCredits, 2);
    }

    private function calculateTotalCreditsFromFormatted($items): ?float
    {
        $totalCredits = 0;

        foreach ($items as $item) {
            $credit = (float) ($item['credit'] ?? 0);
            if ($credit <= 0) {
                continue;
            }
            $totalCredits += $credit;
        }

        return $totalCredits > 0 ? $totalCredits : null;
    }

    private function gpaToGradeValue(?float $gpa): ?string
    {
        if ($gpa === null) {
            return null;
        }

        if ($gpa >= 3.7) {
            return 'A';
        }
        if ($gpa >= 3.0) {
            return 'B';
        }
        if ($gpa >= 2.0) {
            return 'C';
        }

        return 'F';
    }
}
