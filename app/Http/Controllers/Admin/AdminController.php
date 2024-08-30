<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\Contact;
use App\Models\Admission;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        // $mostVisitedPages = Analytics::fetchMostVisitedPages(Period::days(7));
        // $visitorPages = Analytics::fetchVisitorsAndPageViews(Period::days(7));
       return view('admin.index',[
        'course' => Course::all(),
        'courses' => Course::latest()->get(),
        'student' => Student::all(),
        'students' => Student::latest()->take(10)->get(),
        'users' => User::all(),
        'contacts' => Contact::all(),
        'admissions' => Admission::all(),
        // 'mostVisitedPages' => $mostVisitedPages,
        // 'visitorPages' => $visitorPages,
       ]);
    }
}