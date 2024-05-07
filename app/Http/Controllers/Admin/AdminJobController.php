<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;

class AdminJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.job.index',[
            'jobs' => Job::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.job.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $job = Job::where('id', $id)->firstOrFail();
        return view('admin.job.edit',[
            'job' => $job
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $job = Job::where('id', $id)->firstOrFail();
        $job->delete();
        return redirect()->back();
    }
}