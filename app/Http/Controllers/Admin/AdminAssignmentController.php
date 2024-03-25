<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Module;
use App\Models\Subject;
use App\Models\StudentAssignment;
use Illuminate\Validation\Rule;

class AdminAssignmentController extends Controller
{
    public function index()
    {
       return view('admin.assignments.index',[
        'assignments' => Assignment::all(),
        'student_assignments' => StudentAssignment::all(),
        'modules' => Module::all(),
        'subjects' => Subject::all(),
       ]);
    }

    public function create()
    {
        return view('admin.assignments.create',[
            'courses' => Course::all(),
            'modules' => Module::all(),
            'subjects' => Subject::all(),
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

    public function details($slug)
    {
        $assignment = Assignment::where('slug', $slug)->firstOrFail();
        return view('admin.assignments.show', [
            'assignment' => $assignment,
        ]);
    }

    public function edit($slug)
    {
        $slug = Assignment::where('slug',$slug)->firstOrFail();
       return view('admin.assignments.edit',[
        'assignment' => $slug,
        'courses' => Course::all(),
        'modules' => Module::all(),
        'subjects' => Subject::all()
       ]);
    }

    public function update(Request $request, Assignment $assignment)
    {
        $assignment = Assignment::where('id', $assignment->id)->firstOrFail();
        $formData = request()->validate([
            'name' => ['required',Rule::unique('assignments','name')->ignore($assignment)],
            'description' => 'nullable',
            'course_id' => 'nullable',
            'module_id' => 'nullable',
            'subject_id' => 'nullable',
            'attach_file' => 'nullable|mimes:pdf,docx,doc',
        ]);

        $formData['slug'] = Str::slug($formData['name']);

        if($request->hasFile('attach_file')){
            $filePath = $request->file('attach_file')->store('assignment_attachments','public');
            $formData['attach_file'] = $filePath;
        }

        $formData['user_id'] = auth()->user()->id;

        $assignment->update($formData);

        return redirect('admin/assignments');
    }
}