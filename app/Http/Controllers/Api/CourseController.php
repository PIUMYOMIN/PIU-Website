<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return response()->json($courses, 201);
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        return response()->json($course);
    }
}