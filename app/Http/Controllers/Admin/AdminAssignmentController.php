<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Module;

class AdminAssignmentController extends Controller
{
    public function index()
    {
       return view('admin.assignments.index',[
        'assignments' => Assignment::all(),
       ]);
    }

    public function create()
    {
        return view('admin.assignments.create',[
            'courses' => Course::all(),
            'modules' => Module::all(),
        ]);
    }

    public function store(Request $request)
    {
        $formData = request()->validate([
            'name' => 'required|unique:assignments,name',
            'description' => 'nullable',
            'course_id' => 'required',
            'module_id' => 'required',
            'attach_file' => 'nullable|mimes:pdf,docx,doc',
        ]);
        $formData['slug'] = Str::slug($formData['name']);

        if($request->hasFile('attach_file')){
            $filePath = $request->file('attach_file')->store('assignment_attachments','public');
            $formData['attach_file'] = $filePath;
        }

        $formData['user_id'] = auth()->user()->id;
        Assignment::create($formData);

        return redirect('admin/assignments');
    }

    public function edit($slug)
    {
        $slug = Assignment::where('slug',$slug)->firstOrFail();
       return view('admin.assignments.edit',[
        'assignment' => $slug,
        'courses' => Course::all(),
        'modules' => Module::all()
       ]);
    }

    public function update(Request $request, Assignment $slug)
    {
        $formData = request()->validate([
            'name' => 'required|unique:assignments,name',
            'description' => 'nullable',
            'course_id' => 'required',
            'module_id' => 'required',
            'attach_file' => 'nullable|mimes:pdf,docx,doc',
        ]);
        $formData['slug'] = Str::slug($formData['name']);

        if($request->hasFile('attach_file')){
            $filePath = $request->file('attach_file')->store('assignment_attachments','public');
            $formData['attach_file'] = $filePath;
        }

        $formData['user_id'] = auth()->user()->id;

        $slug->update($formData);

        return redirect('admin/assignments');
    }
}