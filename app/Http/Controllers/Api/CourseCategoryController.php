<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use Illuminate\Validation\Rule;

class CourseCategoryController extends Controller
{
    public function index()
    {
        $categories = CourseCategory::with('user:id,name,email')
            ->withCount('courses')
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

        $validated['name'] = trim($validated['name']);
        $validated['description'] = $validated['description'] ?? '';
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
        $courseCategory = CourseCategory::with('user:id,name,email')
            ->withCount('courses')
            ->findOrFail($id);
        return response()->json($courseCategory);
    }

    public function update(Request $request, string $id)
    {
        $category = CourseCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('course_categories', 'name')->ignore($category->id),
            ],
            'description' => 'nullable|string',
        ]);

        $validated['name'] = trim($validated['name']);
        $validated['description'] = $validated['description'] ?? '';
        $category->update($validated);
        $category->load('user:id,name,email')->loadCount('courses');

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully',
            'data' => $category,
        ]);
    }

    public function destroy(string $id)
    {
        $category = CourseCategory::withCount('courses')->findOrFail($id);

        if ($category->courses_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'This category cannot be deleted while courses are assigned to it.',
            ], 422);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course category deleted successfully',
        ]);
    }
}

