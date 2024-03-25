<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Validation\Rule;

class AdminSubjectController extends Controller
{
    public function index()
    {
        return view('admin.subjects.index',[
            'subjects' => Subject::all(),
            'courses' =>Course::all(),
            'modules' =>Module::all(),
        ]);
    }

    public function create()
    {
        return view('admin.subjects.create',[
            'subjects' => Subject::all(),
            'courses' =>Course::all(),
            'modules' =>Module::all(),
        ]);
    }

    public function store(Request $request)
    {
        // dd(request()->all());
       $data = request()->validate([
        'name' => 'required|unique:subjects,name',
        'description' => 'nullable',
        'course_id' => 'required',
        'module_id' => 'required',
       ]);

       $data['user_id'] = auth()->user()->id;

       Subject::create($data);
       return redirect('/admin/subjects');
    }

    public function edit($id)
    {
        $subject = Subject::where('id',$id)->firstOrFail();
       return view('admin.subjects.edit',[
        'subject' => $subject,
        'courses' =>Course::all(),
        'modules' =>Module::all(),
       ]);
    }

    public function update($id)
    {
        $subject = Subject::where('id',$id)->firstOrFail();
       $data = request()->validate([
        'name' => ['required',Rule::unique('subjects','name')->ignore($subject->id)],
        'description' => 'nullable',
        'course_id' => 'required',
        'module_id' => 'required',
       ]);

       $data['user_id'] = auth()->user()->id;

       $subject->update($data);
       return redirect('/admin/subjects');
    }
}