<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function index()
    {
       return view('user.courses.index',[
        'courses' => Course::all(),
        'categories' => CourseCategory::all(),
       ]);
    }

    public function show($slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
            return view('user.courses.show',[
                'course' => $course,
                'categories' => CourseCategory::all(),
            ]);
    }
}