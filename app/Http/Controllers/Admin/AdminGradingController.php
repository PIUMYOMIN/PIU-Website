<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grading;
use App\Models\Student;
use App\Models\Course;
use App\Models\Term;
use App\Models\Module;
use App\Models\Assignment;
use App\Models\Year;
use App\Models\Semester;

class AdminGradingController extends Controller
{
    public function index()
    {
       return view('admin.students.grading.index',[
        'students' => Student::all(),
        'courses' => Course::all()
       ]);
    }

    public function create()
    {
        return view('admin.students.grading.create');
    }

    public function addGradingPoint(Student $student, Semester $semester)
    {
        return view('admin.students.grading.create',[
            'student' => $student,
            'semester' => $semester,
            'courses' => Course::all(),
            'semesters' => Semester::all(),
            'modules' => Module::all(),
            'assignments' => Assignment::all(),
            'years' => Year::latest()->get(),
        ]);
    }

    public function gradingStore(Request $request, Student $student, Semester $semester)
    {
        $formData = $request->validate([
            'user_id' => 'required',
            'student_id' => 'required',
            'course_id' => 'required',
            'module_id' => 'required',
            'year_id' => 'required',
            'assignment_id' => 'required',
            'mark' => 'required|numeric|max:100',
            'grade_point' => 'required|numeric',
            'grade_value' => 'required',
        ]);

        $formData['term_id'] = $request->has('term_id') ? $request->term_id : null;
        $formData['semester_id'] = $request->input('semester_id') ?: $semester->id;
        $formData['user_id'] = auth()->user()->id;
        Grading::create($formData);

        return redirect('admin/students/grading/check');
    }

    public function viewGrading()
    {
        return view('admin.students.grading.result',[
            'students' => Student::all(),
            'gradings' => Grading::all(),
            'courses' => Course::all(),
            'years' => Year::all(),
            'semesters' => Semester::all(),
        ]);
    }


    public function semesterGrading(Student $student, Semester $semester, Year $year)
    {
        $gradings = Grading::where([
        'student_id' => $student->id,
        'semester_id' => $semester->id,
        'year_id' => $year->id,
    ])->get();
       return view('admin.students.grading.show',[
            'student' => $student,
            'semester' => $semester,
            'year' => $year,
            'gradings' => Grading::where([
                'student_id' => $student->id,
                'semester_id' => $semester->id,
                'year_id' => $year->id,
            ])->get()
       ]);
    }

    public function edit(Request $request, Student $student, Grading $grading, Semester $semester)
    {
        return view('admin.students.grading.edit', [
            'grading' => $grading,
            'student' => $grading->student,
            'semester' => $grading->semester,
            'courses' => Course::all(),
            'modules' => Module::all(),
            'assignments' => Assignment::all(),
            'years' => Year::latest()->get(),
        ]);
    }

    public function update(Request $request, Student $student, Grading $grading, Semester $semester)
    {
        $formData = request()->validate([
            "student_id" => 'required',
            "semester_id" => 'required',
            "user_id" => 'required',
            "course_id" => 'required',
            "year_id" => 'required',
            "module_id" => 'required',
            "assignment_id" => 'required',
            'mark' => 'required|numeric|max:100',
            "grade_point" => 'required',
            "grade_value" => 'required',
        ]);

        $grading->update($formData);

        return redirect('admin/students/grading/check');
    }

    public function filterCourse(Request $request, $course_id)
    {
        $students = Student::with(['course', 'year', 'user'])
                    ->where('course_id', $course_id)
                    ->get();

        return response()->json($students);
    }


    public function studentGrading($id)
    {
        $student = Student::where('id',$id)->firstOrFail();
        return view('admin.students.grading.grading',[
            'student' => $student,
            'years' => Year::all()
        ]);
    }

    public function studentGradingByYear($studentId, $yearId)
    {
        $student = Student::where('id',$studentId)->findOrFail($studentId);
        $year = Year::where('id',$yearId)->firstOrFail();
        $gradings = Grading::where('student_id', $studentId)
                       ->where('year_id', $yearId)
                       ->get();
        return view('admin.students.grading.studentGradingYearlyResult',[
            'student' => $student,
            'year' => $year,
            'gradings' => $gradings,
        ]);
    }

}