<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminJobsController extends Controller
{
    public function index()
    {
        return view('admin.job.index',[
            'jobs' => Job::all(),
        ]);
    }

    public function store()
    {
        $formData = request()->validate([
            'title' => ['required',Rule::unique('jobs','title')],
            'description' => 'required',
            'num_of_posts' => 'required',
            'job_campus' => 'required',
            'expired_time' => 'required',
            'city' => 'required',
            'country' => 'required',
            'image' => 'required',
        ]);

        $formData['user_id'] = auth()->user()->id;

        Job::create($formData);

        return redirect('')->route('admin.jobs');
    }
}