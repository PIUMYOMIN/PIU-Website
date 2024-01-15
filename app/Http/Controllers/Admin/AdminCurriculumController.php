<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Curriculum;
use App\Models\Module;
use App\Models\Year;
use Illuminate\Validation\Rule;

class AdminCurriculumController extends Controller
{
    public function index()
    {
        return view('admin.curriculums.index', [
            'curriculums' => Curriculum::all(),
            'courses' => Course::all(),
            'modules' => Module::all(),
            'years' => Year::all(),
        ]);
    }

    public function create()
    {
        return view('admin.curriculums.create', [
            'courses' => Course::all(),
            'modules' => Module::all(),
            'years' => Year::all(),
        ]);
    }

    public function store()
    {
        $data = request()->validate([
            'title' => ['required', Rule::unique('curriculums', 'title')],
            'description' => 'required',
            'course_id' => 'required',
            'module_id' => 'required',
            'year_id' => 'required',
        ]);

        $data['user_id'] = auth()->user()->id;

        Curriculum::create($data);

        return redirect()->route('admin.curriculum.index');
    }

    public function edit(Curriculum $curriculum)
    {
        return view('admin.curriculums.edit', [
            'curriculum' => $curriculum,
        ]);
    }

    public function update(Curriculum $curriculum)
    {
        dd(request()->all());
    }

}
