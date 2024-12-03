<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Year;
use App\Models\Course;
use App\Models\User;
use App\Models\StudentJoinedCourse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;


class AdminStudentController extends Controller
{
    public function index()
    {
        $students = Student::with('course', 'year')->get();
        return view('admin.students.index', [
         'students' => $students,
         'courses' => Course::all(),
         'years' => Year::all(),
         'users' => User::all(),
        ]);
    }

    public function create()
    {
        return view('admin.students.create', [
            'courses' => Course::all(),
            'years' => Year::all(),
        ]);
    }

    public function store(Request $request)
    {
        $formData = request()->validate([
             'fname' => 'required',
             'lname' => 'nullable',
             'email' => ['required', 'email', Rule::unique('students', 'email')],
             'phone' => 'required',
             'address' => 'required',
             'permanent_address' => 'nullable',
             'dob' => 'nullable',
             'city' => 'required',
             'country' => 'required',
             'student_id' => ['required', Rule::unique('students', 'student_id')],
             'national_id' => ['required', Rule::unique('students', 'national_id')],
             'passport_id' => ['nullable',Rule::unique('students', 'passport_id')],
             'course_id' => 'required',
             'marital_sts' => 'required',
             'gender_sts' => 'required',
             'year_id' => 'required',
             'profile' => 'nullable|file|mimes:jpg,jpeg,png',
             'education_certificate' => 'nullable|file|mimes:pdf,doc,docx',
             'other_documents' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
         ]);

        $formData['password'] = Hash::make('piustudent2024');
        $formData['user_id'] = auth()->id();

        // Asynchronously process the file uploads
        if ($request->hasFile('profile')) {
            $formData['profile'] = $request->file('profile')->store('student_profiles');
        }

        if ($request->hasFile('education_certificate')) {
            $formData['education_certificate'] = $request->file('education_certificate')->store('student_certificates');
        }

        if ($request->hasFile('other_documents')) {
            $formData['other_documents'] = $request->file('other_documents')->store('student_documents');
        }

        Student::create($formData);

        return redirect('admin/students');
    }

    public function show(Student $student)
    {
        return view('admin.students.show', [
         'student' => $student,
         'courses' => Course::all(),
        ]);
    }

    // joined course delete
    public function deleteCourse(Student $student, Year $year)
    {
        dd($student->courses());
        $student->courses()->detach($year->id);
        return redirect()->back()->with('success', 'Course deleted successfully.');
    }


    public function edit($id)
    {
        $student = Student::where('id', $id)->firstOrFail();

        if (($student->id == $id)) {
            return view('admin.students.edit', [
                'student' => $student,
                'courses' => Course::all(),
                'years' => Year::all(),
            ]);
        } else {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to edit this profile.']);
        }
    }


    public function update($id)
    {
        // Retrieve the student data based on the extracted student ID
        $student = Student::where('id', $id)->firstOrFail();

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

        return redirect('/admin/students');

    }

    public function addCourse(Request $request, Student $student)
{
    $formData = $request->validate([
        'course_id' => 'required',
        'joined_at' => 'required',
    ]);

    // Add the student ID manually
    $formData['student_id'] = $student->id;

    // Save the data to the student_joined_course table
    StudentJoinedCourse::create($formData);

    return redirect('admin/students');
}

    public function changePassword($identifier)
    {
        $student_id = substr($identifier, 0, 7);

        $student = Student::where('student_id', $student_id)->firstOrFail();

        return view('admin.student_profile.change_password', [
            'student' => $student,
            'identifier' => $identifier,
        ]);
    }

    public function passwordUpdate($identifier)
    {
        $student_id = substr($identifier, 0, 7);
        $student = Student::where('student_id',$student_id)->firstOrFail();
        $data = request()->validate([
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        // For users with a traditional password, check the old password
        $oldPassword = request('old_password');
        if (!Hash::check($oldPassword, $student->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }

        // Update the user's password
        $student->password = Hash::make($data['new_password']);
        $student->save();

        // Redirect the user with a success message
        return redirect()->route('admin.student.profile', ['identifier' => $identifier])->with('success', 'Password updated successfully!');
    }

    public function filterCourse(Request $request, $course_id)
    {
        $students = Student::with(['course', 'year', 'user'])
                    ->where('course_id', $course_id)
                    ->get();

        return response()->json($students);
    }

}