<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function index($identifier)
{
    // Validate the format of the identifier
    if (!preg_match('/^[A-Z]{3}\d{6}[A-Za-z0-9]{15}$/', $identifier)) {
        abort(404);
    }

    // Extract the student ID from the identifier
    $randomStringLength = 15; // Length of the random string
    $student_id = substr($identifier, 0, -$randomStringLength);
    
    // Retrieve the student data based on the extracted student ID
    $student = Student::where('student_id', $student_id)->firstOrFail();

    // Verify that the extracted student ID matches the retrieved student record
    if ($student->student_id !== $student_id) {
        abort(404); // Identifier integrity check failed
    }

    return view('admin.student_profile.profile', [
        'student' => $student,
    ]);
}

}