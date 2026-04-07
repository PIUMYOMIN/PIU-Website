<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $students,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
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

            // ✅ DEFAULT PASSWORD
            $data['password'] = Hash::make('piustudent');
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

            $student = Student::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Student created successfully',
                'default_password' => 'piustudent',
                'data' => $student
            ], 201);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Student creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        try{
            $student = Student::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $student
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found'
            ], 404);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $student = Student::findOrFail($id);

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

                // 🔑 OPTIONAL PASSWORD
                'password' => 'nullable|string|min:6',

                'profile' => 'nullable|file|mimes:jpg,jpeg,png',
                'education_certificate' => 'nullable|file|mimes:pdf,doc,docx',
                'other_documents' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            ]);

            // 🔐 Update password only if provided
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            } else {
                unset($data['password']);
            }

            // 📁 File uploads
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
                'data' => $student
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Student update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);

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
}