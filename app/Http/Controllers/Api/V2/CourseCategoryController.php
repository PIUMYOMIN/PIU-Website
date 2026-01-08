<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use Illuminate\Support\Facades\Auth;

class CourseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CourseCategory::with('user:id,name,email')
            ->latest()
            ->get();

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:course_categories,name',
            'description' => 'nullable|string',
        ]);

        // Add the authenticated user's ID
        $validated['user_id'] = auth()->id();

        $category = CourseCategory::create($validated);

        // Load the user relationship
        $category->load('user:id,name,email');

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'data' => $category,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $courseCategory = CourseCategory::with('user:id,name,email')->findOrFail($id);
        return response()->json($courseCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = CourseCategory::findOrFail($id);

        // Check if user owns the category (optional authorization)
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

        // Reload the user relationship
        $category->load('user:id,name,email');

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully',
            'data' => $category,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = CourseCategory::findOrFail($id);

        // Check if user owns the category (optional authorization)
        if ($category->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to delete this category',
            ], 403);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course category deleted successfully'
        ]);
    }
}
