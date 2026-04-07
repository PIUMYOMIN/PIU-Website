<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Constructor to apply middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with('category')->latest()->get();

        // Add full URL for images
        $courses->transform(function ($course) {
            $course->image = $course->image
                ? asset('storage/' . $course->image)
                : asset('storage/course_images/default.png');
            return $course;
        });

        return response()->json($courses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:courses',
            'description' => 'required|string',
            'eligibility' => 'nullable|string',
            'requirement' => 'nullable|string',
            'fees' => 'nullable|string',
            'apply' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'duration' => 'nullable|string',
            'total_seat' => 'nullable|integer|min:1',
            'ic_name' => 'nullable|string|max:255',
            'ic_phone' => 'nullable|string|max:20',
            'course_category_id' => 'required|exists:course_categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'is_active' => 'boolean',
            'application_sts' => 'boolean',
        ]);

        // Generate slug from title
        $validated['slug'] = Str::slug($validated['title']);

        // Set current user as creator
        $validated['user_id'] = auth()->id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses', 'public');
            $validated['image'] = $imagePath;
        }

        $course = Course::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Course created successfully',
            'data' => $course->load(['category', 'user']),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::with(['category', 'user'])->findOrFail($id);

        // Add full URL for the image
        $course->image = $course->image
            ? asset('storage/' . $course->image)
            : asset('storage/course_images/default.png');

        return response()->json($course);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:courses,title,' . $course->id,
            'description' => 'required|string',
            'eligibility' => 'nullable|string',
            'requirement' => 'nullable|string',
            'fees' => 'nullable|string',
            'apply' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'duration' => 'nullable|string',
            'total_seat' => 'nullable|integer|min:1',
            'ic_name' => 'nullable|string|max:255',
            'ic_phone' => 'nullable|string|max:20',
            'course_category_id' => 'required|exists:course_categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'is_active' => 'boolean',
            'application_sts' => 'boolean',
        ]);

        // Generate slug from title
        $validated['slug'] = Str::slug($validated['title']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }

            $imagePath = $request->file('image')->store('courses', 'public');
            $validated['image'] = $imagePath;
        } else {
            // Keep old image if not uploading new one
            unset($validated['image']);
        }

        $course->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Course updated successfully',
            'data' => $course->load(['category', 'user']),
        ]);
    }

    /**
     * Toggle the active status of the specified resource.
     */
    public function isActive(Request $request, Course $course)
    {
        // Toggle the is_active status
        $course->update(['is_active' => !$course->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Course active status updated',
            'data' => [
                'id' => $course->id,
                'is_active' => $course->is_active,
                'title' => $course->title
            ]
        ]);
    }

    /**
     * Toggle the application status of the specified resource.
     */
    public function application(Request $request, Course $course)
    {
        // Toggle the application_sts status (assuming it's boolean)
        $course->update(['application_sts' => !$course->application_sts]);

        return response()->json([
            'success' => true,
            'message' => 'Course application status updated',
            'data' => [
                'id' => $course->id,
                'application_sts' => $course->application_sts,
                'title' => $course->title
            ]
        ]);
    }

    /**
     * Search for courses based on a search term.
     */
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $courses = Course::where('title', 'like', "%$searchTerm%")->get();

        return response()->json([
            'success' => true,
            'data' => $courses
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully'
        ]);
    }
}

