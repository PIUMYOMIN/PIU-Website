<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Department::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'nullable|string',
        ]);

        $department = Department::create($data);

        return response()->json([
            'success' => true,
            'data' => $department,
        ], 201);
    }

    public function show(string $id)
    {
        $department = Department::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $department,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $department = Department::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:departments,name,' . $department->id,
            'description' => 'sometimes|nullable|string',
        ]);

        $department->update($data);

        return response()->json([
            'success' => true,
            'data' => $department,
        ]);
    }

    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return response()->json([
            'success' => true,
            'message' => 'Department deleted successfully',
        ]);
    }
}

