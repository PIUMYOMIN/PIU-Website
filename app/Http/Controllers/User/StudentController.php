<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function index(Student $student)
    {
        return view('admin.student_profile.index',[
            'student' => $student,
        ]);
    }
}