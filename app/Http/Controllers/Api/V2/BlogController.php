<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all blogs (for admin) or only active blogs (for public)
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            $blogs = Blog::with('user:id,name,email')
                ->latest()
                ->get();
        } else {
            $blogs = Blog::where('is_active', true)
                ->with('user:id,name,email')
                ->latest()
                ->get();
        }

        // Add full URL for images
        $blogs->transform(function ($blog) {
            if ($blog->image && !filter_var($blog->image, FILTER_VALIDATE_URL)) {
                $blog->image = asset('storage/' . $blog->image);
            }
            return $blog;
        });

        return response()->json($blogs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if user has admin role
        if (!Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.'
            ], 403);
        }

        $validated = $request->validate([
            'title' => 'required|unique:blogs,title',
            'description' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:5120',
            'is_active' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
            $validated['image'] = $imagePath;
        }

        // Add user_id from authenticated user
        $validated['user_id'] = Auth::id();

        $blog = Blog::create($validated);

        // Load user relationship
        $blog->load('user:id,name,email');

        return response()->json([
            'success' => true,
            'message' => 'Blog created successfully',
            'data' => $blog,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blog = Blog::with('user:id,name,email')->findOrFail($id);

        // Add full URL for image
        if ($blog->image && !filter_var($blog->image, FILTER_VALIDATE_URL)) {
            $blog->image = asset('storage/' . $blog->image);
        }

        return response()->json($blog);
    }

    /**
     * Display blog by slug.
     */
    public function showBySlug(string $slug)
    {
        $blog = Blog::where('slug', $slug)
            ->with('user:id,name,email')
            ->firstOrFail();

        // Add full URL for image
        if ($blog->image && !filter_var($blog->image, FILTER_VALIDATE_URL)) {
            $blog->image = asset('storage/' . $blog->image);
        }

        return response()->json($blog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $blog = Blog::findOrFail($id);

        // Check if user is authorized (owner or admin)
        if ($blog->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this blog.'
            ], 403);
        }

        $validated = $request->validate([
            'title' => ['required', Rule::unique('blogs', 'title')->ignore($blog->id)],
            'description' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:5120',
            'is_active' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                Storage::disk('public')->delete($blog->image);
            }

            $imagePath = $request->file('image')->store('blogs', 'public');
            $validated['image'] = $imagePath;
        } else {
            // Keep old image if not uploading new one
            unset($validated['image']);
        }

        $blog->update($validated);

        // Reload user relationship
        $blog->load('user:id,name,email');

        return response()->json([
            'success' => true,
            'message' => 'Blog updated successfully',
            'data' => $blog,
        ]);
    }

    /**
     * Toggle active status of blog.
     */
    public function toggleActive(string $id)
    {
        $blog = Blog::findOrFail($id);

        // Check if user is authorized (owner or admin)
        if ($blog->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this blog.'
            ], 403);
        }

        $blog->update(['is_active' => !$blog->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Blog status updated',
            'data' => [
                'id' => $blog->id,
                'is_active' => $blog->is_active,
                'title' => $blog->title
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);

        // Check if user is authorized (owner or admin)
        if ($blog->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete this blog.'
            ], 403);
        }

        // Delete image file if exists
        if ($blog->image && Storage::disk('public')->exists($blog->image)) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return response()->json([
            'success' => true,
            'message' => 'Blog deleted successfully'
        ]);
    }

    /**
     * Search blogs by title or description.
     */
    public function search(Request $request)
    {
        $query = $request->input('search');

        $blogs = Blog::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->with('user:id,name,email')
            ->latest()
            ->get();

        // Add full URL for images
        $blogs->transform(function ($blog) {
            if ($blog->image && !filter_var($blog->image, FILTER_VALIDATE_URL)) {
                $blog->image = asset('storage/' . $blog->image);
            }
            return $blog;
        });

        return response()->json($blogs);
    }

    /**
     * Upload image for CKEditor (for blog content).
     */
    public function uploadImage(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'error' => [
                    'message' => 'Unauthorized. Please login to upload images.'
                ]
            ], 401);
        }

        $request->validate([
            'upload' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            // Store in public storage
            $request->file('upload')->storeAs('public/blogs/content', $fileName);

            $url = asset('storage/blogs/content/' . $fileName);

            return response()->json([
                'uploaded' => 1,
                'fileName' => $fileName,
                'url' => $url
            ]);
        }

        return response()->json([
            'uploaded' => 0,
            'error' => [
                'message' => 'Image upload failed.'
            ]
        ], 400);
    }
}