<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Department;

class AdminDepartmentController extends Controller
{
    public function index()
    {
       return view('admin.departments.index',[
        'departments' => Department::all(),
       ]);
    }

    public function create()
    {
        return view('admin.departments.create');
    }

    public function store()
    {
       $data = request()->validate([
        'name' => 'required|unique:departments,name',
        'description' => 'nullable',
       ]);

       Department::create($data);

       return redirect('/admin/departments');
    }

    public function edit(Department $department)
    {
       return view('admin.departments.edit',[
        'department' => $department
       ]);
    }

    public function update(Request $request, Department $department)
    {
        $data = request()->validate([
            'name' => ["required",Rule::unique('departments','name')->ignore($department->id)],
            'description' => 'nullable',
        ]);

        $department->update($data);

        return redirect('/admin/departments');
    }
}