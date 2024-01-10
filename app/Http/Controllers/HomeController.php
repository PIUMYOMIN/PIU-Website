<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Slide;
use App\Models\Gallery;
use App\Models\Event;
use App\Models\Job;

class HomeController extends Controller
{
    public function index()
    {
       return view('index',[
        'slides' => Slide::all(),
        'galleries' => Gallery::take(12)
                    ->get(),
        'courses' => Course::latest()->get(),
        'events' => Event::latest()->take(4)->get(),
        'jobs' => Job::latest()->take(4)->get(),
       ]);
    }
}