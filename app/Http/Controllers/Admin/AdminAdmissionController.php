<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Course;

class AdminAdmissionController extends Controller
{
    public function index()
    {
        $activeCourses = Course::where('application_sts', true)->get();
        return view('admin.admissions.index', [
            'admissions' => Admission::latest()->get(),
            'courses' => $activeCourses,
        ]);
    }

    public function filterByCourse($courseId)
    {
        $course = Course::findOrFail($courseId);

        $admissions = Admission::with(['course'])
        ->where('course_id', $courseId)->get()
        ->get();

        return response()->json($admissions);
    }
}