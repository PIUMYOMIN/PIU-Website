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
         $user = Auth::user();
         $userId = $user->id;
         dd($userId);
        if ($user->hasRole('admin')) {
                return redirect('/admin')->with('success', 'Welcome back');
            } elseif($user->hasAnyRole('manager','faculty','registrar')) {
                dd('hit');
                return redirect()->route('admin.users.profile.edit',[$user->id])->with('success', 'Welcome back');
            }
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