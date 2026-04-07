<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseCategory;

class CourseCategoryController extends Controller
{
    public function index()
    {
        $categories = CourseCategory::with('user:id,name,email')
            ->latest()
            ->get();

        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:course_categories,name',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        $category = CourseCategory::create($validated);
        $category->load('user:id,name,email');

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'data' => $category,
        ], 201);
    }

    public function show(string $id)
    {
        $courseCategory = CourseCategory::with('user:id,name,email')->findOrFail($id);
        return response()->json($courseCategory);
    }

    public function update(Request $request, string $id)
    {
        $category = CourseCategory::findOrFail($id);

        if ($category->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this category',
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:course_categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($validated);
        $category->load('user:id,name,email');

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully',
            'data' => $category,
        ]);
    }

    public function destroy(string $id)
    {
        $category = CourseCategory::findOrFail($id);

        if ($category->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to delete this category',
            ], 403);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course category deleted successfully',
        ]);
    }
}

