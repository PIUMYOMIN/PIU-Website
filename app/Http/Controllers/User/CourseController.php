<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseComment;
use App\Models\Event;
use App\Models\Curriculum;

class CourseController extends Controller
{

    public function index(Request $request)
    {
        return view('user.courses.index',[
            'courses' => Course::where('is_active',1)->latest()->get(),
            'categories' => CourseCategory::all(),
        ]);
    }

    public function show($slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        return view('user.courses.show',[
            'course' => $course,
            'categories' => CourseCategory::all(),
            'comments' => CourseComment::all(),
            'events' => Event::all(),
            'curriculums' => Curriculum::all(),
        ]);
    }
}