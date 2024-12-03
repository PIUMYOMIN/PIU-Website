<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Year;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\StudentJoinedCourse;
use App\Models\Grading;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index($identifier)
{
    // dd($identifier);

    // Extract the student ID from the identifier
    $student_id = substr($identifier, 0, 7);

    // dd($student_id);

    // Retrieve the student data based on the extracted student ID
    $student = Student::where('student_id', $student_id)->firstOrFail();

    // dd($student);

    // Ensure authenticated user is correctly retrieved
    $studentAuth = auth()->guard('student')->user();

    // Verify that the extracted student ID matches the retrieved student record
    if ($studentAuth && $student->student_id !== auth()->guard('student')->user()->student_id) {
        abort(404); // Identifier integrity check failed
    }

    return view('student.profile', [
        'student' => $student,
        'identifier' => $identifier
    ]);
}

// Dashboard Route
    public function dashboard($identifier)
    {
        // Extract the student ID from the identifier
        $student_id = substr($identifier, 0, 7);

        // dd($student_id);

        // Fetch the student details
        $student = Student::where('student_id', $student_id)->firstOrFail();

        if ($student->student_id !== auth()->guard('student')->user()->student_id) {
            abort(404); // Identifier integrity check failed
        }

        $joinedCourses = StudentJoinedCourse::with('course')
        ->where('student_id', $student->id)
        ->get();

        // $gradings = Grading::with('gradings')
        // ->where('student_id',$student->id)
        // ->get();

        $gradings = Grading::where('student_id',$student->id)
        ->get();

        return view('student.dashboard', [
            'student' => $student,
            'identifier' => $identifier,
            'joinedCourses' => $joinedCourses,
            'gradings' => $gradings
        ]);
    }

    public function courses($identifier)
    {
        // Extract the student ID from the identifier
        $student_id = substr($identifier, 0, 7);

        // dd($student_id);

        // Fetch the student details
        $student = Student::where('student_id', $student_id)->firstOrFail();

        if ($student->student_id !== auth()->guard('student')->user()->student_id) {
            abort(404); // Identifier integrity check failed
        }

        return view('student.courses', [
            'student' => $student,
            'identifier' => $identifier // Keep the identifier consistent
        ]);
    }

    public function exams($identifier)
    {
        // Extract the student ID from the identifier
        $student_id = substr($identifier, 0, 7);

        // dd($student_id);

        // Fetch the student details
        $student = Student::where('student_id', $student_id)->firstOrFail();

        if ($student->student_id !== auth()->guard('student')->user()->student_id) {
            abort(404); // Identifier integrity check failed
        }

        return view('student.exams', [
            'student' => $student,
            'identifier' => $identifier // Keep the identifier consistent
        ]);
    }

    public function timeLine($identifier)
    {
        // Extract the student ID from the identifier
        $student_id = substr($identifier, 0, 7);

        // dd($student_id);

        // Fetch the student details
        $student = Student::where('student_id', $student_id)->firstOrFail();

        if ($student->student_id !== auth()->guard('student')->user()->student_id) {
            abort(404); // Identifier integrity check failed
        }

        return view('student.time_line', [
            'student' => $student,
            'identifier' => $identifier // Keep the identifier consistent
        ]);
    }

// student edit page
    public function edit($identifier)
    {
        // Extract the student ID from the identifier
        $student_id = substr($identifier, 0, 7);

        // Retrieve the student data based on the extracted student ID
        $student = Student::where('student_id', $student_id)->firstOrFail();

        $authenticatedUser = Auth::user();
        $authenticatedStudent = Auth::guard('student')->user();

        if (($authenticatedUser && $authenticatedUser->hasAnyRole(['admin', 'registrar'])) || ($authenticatedStudent && $authenticatedStudent->id === $student->id)) {
            return view('admin.student_profile.edit', [
                'student' => $student,
                'courses' => Course::all(),
                'years' => Year::all(),
                'identifier' => $identifier,
            ]);
        } else {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to edit this profile.']);
        }
    }

    public function update($identifier)
    {
        $student_id = substr($identifier, 0, 7);
        $student = Student::where('student_id', $student_id)->firstOrFail();
        if($student_id == $student->student_id){
            $formData = request()->validate([
                'fname' => 'nullable',
                'lname' => 'nullable',
                'email' => ['required', 'email', Rule::unique('students', 'email')->ignore($student->id)],
                'phone' => 'nullable',
                'address' => 'nullable',
                'permanent_address' => 'nullable',
                'dob' => 'nullable',
                'city' => 'nullable',
                'country' => 'nullable',
                'student_id' => ['nullable', Rule::unique('students', 'student_id')->ignore($student->id)],
                'national_id' => ['nullable', Rule::unique('students', 'national_id')->ignore($student->id)],
                'passport_id' => ['nullable', Rule::unique('students', 'passport_id')->ignore($student->id)],
                'course_id' => 'nullable',
                'marital_sts' => 'nullable',
                'gender_sts' => 'nullable',
                'year_id' => 'nullable',
                'profile' => 'nullable|file|mimes:jpg,jpeg,png',
                'education_certificate' => 'nullable|file|mimes:pdf,doc,docx',
                'other_documents' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            ]);

            // $formData['user_id'] = auth()->id();

            // Asynchronously process the file uploads
            if (request()->hasFile('profile')) {
                $formData['profile'] = request()->file('profile')->store('profiles');
            }

            if (request()->hasFile('education_certificate')) {
                $formData['education_certificate'] = request()->file('education_certificate')->store('certificates');
            }

            if (request()->hasFile('other_documents')) {
                $formData['other_documents'] = request()->file('other_documents')->store('documents');
            }

            $student->update($formData);

            return redirect()->route('admin.student.profile', ['identifier' => $identifier]);
        }else{
            return redirect()->back()->withErrors(['error' => 'Your are not authorized to edit this profile']);
        }
    }

}