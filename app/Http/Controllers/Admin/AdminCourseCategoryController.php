<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseCategory;

class AdminCourseCategoryController extends Controller
{
    public function index()
    {
       return view('admin.course_category.index',[
        'categories'=> CourseCategory::all(),
       ]);
    }

    public function create()
    {
        return view('admin.course_category.create');
    }

    public function store()
    {
       $data = request()->validate([
        'name' => 'required',
        'description' => 'required',
       ]);

       $data['user_id'] = auth()->user()->id;

       CourseCategory::create($data);

       return redirect('admin/course-categories');
    }

    public function edit(CourseCategory $category)
    {
        return view('admin.course_category.edit',[
            'category' => $category,
        ]);
    }

    public function update(CourseCategory $category)
    {
       $data = request()->validate([
        'name' => 'required',
        'description' => 'required',
       ]);

       $category->update($data);

       return redirect('admin/course-categories');
    }
}