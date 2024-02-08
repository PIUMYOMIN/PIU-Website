<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\Contact;
use App\Models\Admission;

class AdminController extends Controller
{
    public function index()
    {
       return view('admin.index',[
        'courses' => Course::latest()->get(),
        'students' => Student::latest()->take(10)->get(),
        'users' => User::all(),
        'contacts' => Contact::all(),
        'admissions' => Admission::all(),
       ]);
    }
}