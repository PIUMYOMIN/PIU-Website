<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\StudentAuth;
use App\Support\TeacherCourseAccess;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Student::with(['course', 'year'])->latest();

        if ($user instanceof User) {
            $query = TeacherCourseAccess::scopeStudents($user, $query);
        }

        $students = $query->get();

        return response()->json([
            'success' => true,
            'data' => $students,
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'fname' => 'required|string|max:255',
                'lname' => 'nullable|string|max:255',
                'email' => 'required|email|unique:students,email',
                'phone' => 'required|string',
                'address' => 'required|string',
                'permanent_address' => 'nullable|string',
                'city' => 'required|string',
                'country' => 'required|string',
                'dob' => 'nullable|string',
                'year_id' => 'required|string',
                'marital_sts' => 'required|string',
                'gender_sts' => 'required|string',
                'student_id' => 'required|string|unique:students,student_id',
                'course_id' => 'nullable|integer',
                'national_id' => 'required|string',
                'passport_id' => 'nullable|string',

                'profile' => 'nullable|file|mimes:jpg,jpeg,png',
                'education_certificate' => 'required|file|mimes:pdf,doc,docx',
                'other_documents' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            ]);

            // Each student gets their own random temporary password —
            // never a shared/default value. It is returned once in this
            // response only, never stored in plaintext or logged.
            $temporaryPassword = StudentAuth::generateTemporaryPassword();
            $data['password'] = Hash::make($temporaryPassword);
            $data['must_change_password'] = true;
            $data['user_id'] = auth()->id();

            if ($request->hasFile('profile')) {
                $data['profile'] = $request->file('profile')->store('students', 'public');
            }

            if ($request->hasFile('education_certificate')) {
                $data['education_certificate'] = $request->file('education_certificate')->store('students', 'public');
            }

            if ($request->hasFile('other_documents')) {
                $data['other_documents'] = $request->file('other_documents')->store('students', 'public');
            }

            $data['is_active'] = true;

            $student = Student::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Student created successfully',
                'temporary_password' => $temporaryPassword,
                'data' => $student,
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Student creation failed. Please try again later.',
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $student = Student::findOrFail($id);
            $user = auth()->user();
            if ($user instanceof User) {
                TeacherCourseAccess::ensureStudentAccess($user, $student);
            }

            return response()->json([
                'success' => true,
                'data' => $student,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found',
            ], 404);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Student Show Error:', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again later.',
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $student = Student::findOrFail($id);
            $user = auth()->user();
            if ($user instanceof User) {
                TeacherCourseAccess::ensureStudentAccess($user, $student);
            }

            $data = $request->validate([
                'fname' => 'sometimes|string|max:255',
                'lname' => 'nullable|string|max:255',
                'email' => 'sometimes|email|unique:students,email,' . $student->id,
                'phone' => 'sometimes|string',
                'address' => 'sometimes|string',
                'permanent_address' => 'nullable|string',
                'city' => 'sometimes|string',
                'country' => 'sometimes|string',
                'dob' => 'nullable|string',
                'year_id' => 'sometimes|string',
                'marital_sts' => 'sometimes|string',
                'gender_sts' => 'sometimes|string',
                'student_id' => 'sometimes|string|unique:students,student_id,' . $student->id,
                'course_id' => 'nullable|integer',
                'national_id' => 'sometimes|string',
                'passport_id' => 'nullable|string',

                'password' => 'nullable|string|min:8',

                'profile' => 'nullable|file|mimes:jpg,jpeg,png',
                'education_certificate' => 'nullable|file|mimes:pdf,doc,docx',
                'other_documents' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            ]);

            if ($request->filled('password')) {
                // Admin/registrar manually set a password for this
                // student — treat it the same as a fresh temporary
                // password: force them to change it on next login.
                $data['password'] = Hash::make($request->password);
                $data['must_change_password'] = true;
            } else {
                unset($data['password']);
            }

            if (isset($data['course_id']) && $user instanceof User) {
                TeacherCourseAccess::ensureCourseAccess($user, (int) $data['course_id']);
            }

            if ($request->hasFile('profile')) {
                $data['profile'] = $request->file('profile')->store('students', 'public');
            }

            if ($request->hasFile('education_certificate')) {
                $data['education_certificate'] = $request->file('education_certificate')->store('students', 'public');
            }

            if ($request->hasFile('other_documents')) {
                $data['other_documents'] = $request->file('other_documents')->store('students', 'public');
            }

            $student->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Student updated successfully',
                'data' => $student,
            ], 200);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Student Update Error:', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Student update failed. Please try again later.',
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $user = auth()->user();
        if ($user instanceof User) {
            TeacherCourseAccess::ensureStudentAccess($user, $student);
        }

        foreach (['profile', 'education_certificate', 'other_documents'] as $field) {
            if ($student->{$field}) {
                Storage::disk('public')->delete($student->{$field});
            }
        }

        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully',
        ], 200);
    }

    public function toggleActive(Student $student)
    {
        $student->update(['is_active' => !$student->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Student status updated',
            'data' => $student->fresh(),
        ], 200);
    }
}

