<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Job;

class AdminJobController extends Controller
{
    public function index()
    {
        return view('admin.job.index',[
            'jobs' => Job::all(),
        ]);
    }

    public function create()
    {
        return view('admin.job.create');
    }

    public function store(Request $request)
    {
        $formData = request()->validate([
            'title' => ['required',Rule::unique('jobs','title')],
            'description' => 'required',
            'num_of_posts' => 'required',
            'job_campus' => 'required',
            'expire_date' => 'required',
            'expire_time' => 'required',
            'city' => 'required',
            'country' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png',
        ]);

        if($request->hasFile('image')){
            $filePath = $request->file('image')->store('job_posters','public');
            $formData['image'] = $filePath;
        }

        $formData['user_id'] = auth()->user()->id;

        Job::create($formData);

        return redirect()->route('admin.jobs');
    }

    public function edit($id)
    {
        $job = Job::where('id', $id)->firstOrFail();
        return view('admin.job.edit',[
            'job' => $job
        ]);
    }

    public function update(Request $request, $id)
    {
        $job = Job::where('id', $id)->firstOrFail();
        $formData = request()->validate([
            'title' => ['required',Rule::unique('jobs','title')->ignore($job->id)],
            'description' => 'required',
            'num_of_posts' => 'required',
            'job_campus' => 'required',
            'expire_date' => 'required',
            'expire_time' => 'required',
            'city' => 'required',
            'country' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if($request->hasFile('image')){
            $filePath = $request->file('image')->store('job_posters','public');
            $formData['image'] = $filePath;
        }else{
            $data['image'] = $job->image;
        }

        $formData['user_id'] = auth()->user()->id;

        $job->update($formData);

        return redirect('admin/jobs');
    }

    public function destroy($id)
    {
        $job = Job::where('id', $id)->firstOrFail();
        $job->delete();
        return redirect()->back();
    }
}