<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Module;
use App\Models\StudentAssignment;
use Illuminate\Http\Request;

class StudentAssignmentController extends Controller
{

    public function index()
    {
       return view('admin.student_profile.student_assignment',[
        'assignments' => StudentAssignment::all(),
       ]);
    }

    public function submit($slug)
    {
        $assignment = Assignment::where('slug', $slug)->firstOrFail();
        return view('admin.student_profile.assignmentSubmit', [
            'assignment' => $assignment,
            'courses' => Course::all(),
            'modules' => Module::all(),
        ]);
    }

    public function turn(Request $request)
    {
        // dd(request()->all());
        $formData = request()->validate([
            'assignment_id' => 'required|numeric',
            'course_id' => 'required|numeric',
            'module_id' => 'required|numeric',
            'student_id' => 'required|numeric',
            'body' => 'nullable',
            'attach_file' => 'nullable',
        ]);

        if($request->hasFile('attach_file')){
            $filePath = $request->file('attach_file')->store('student_submited_assignments','public');
            $formData['attach_file'] = $filePath;
        }

        StudentAssignment::create($formData);

        return redirect('/admin/student/assignments');
    }

}