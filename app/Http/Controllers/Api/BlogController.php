<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            $blogs = Blog::with('user:id,name,email')->latest()->get();
        } else {
            $blogs = Blog::where('is_active', true)
                ->with('user:id,name,email')
                ->latest()
                ->get();
        }

        $blogs->transform(function ($blog) {
            if ($blog->image && !filter_var($blog->image, FILTER_VALIDATE_URL)) {
                $blog->image = asset('storage/' . $blog->image);
            }
            return $blog;
        });

        return response()->json($blogs);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.',
            ], 403);
        }

        $validated = $request->validate([
            'title' => 'required|unique:blogs,title',
            'description' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:5120',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

        $validated['user_id'] = Auth::id();
        $blog = Blog::create($validated);
        $blog->load('user:id,name,email');

        return response()->json([
            'success' => true,
            'message' => 'Blog created successfully',
            'data' => $blog,
        ], 201);
    }

    public function show(string $id)
    {
        $blog = Blog::with('user:id,name,email')->findOrFail($id);

        if ($blog->image && !filter_var($blog->image, FILTER_VALIDATE_URL)) {
            $blog->image = asset('storage/' . $blog->image);
        }

        return response()->json($blog);
    }

    public function showBySlug(string $slug)
    {
        $blog = Blog::where('slug', $slug)
            ->with('user:id,name,email')
            ->firstOrFail();

        if ($blog->image && !filter_var($blog->image, FILTER_VALIDATE_URL)) {
            $blog->image = asset('storage/' . $blog->image);
        }

        return response()->json($blog);
    }

    public function update(Request $request, string $id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this blog.',
            ], 403);
        }

        $validated = $request->validate([
            'title' => ['required', Rule::unique('blogs', 'title')->ignore($blog->id)],
            'description' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:5120',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                Storage::disk('public')->delete($blog->image);
            }
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        } else {
            unset($validated['image']);
        }

        $blog->update($validated);
        $blog->load('user:id,name,email');

        return response()->json([
            'success' => true,
            'message' => 'Blog updated successfully',
            'data' => $blog,
        ]);
    }

    public function toggleActive(string $id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this blog.',
            ], 403);
        }

        $blog->update(['is_active' => !$blog->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Blog status updated',
            'data' => [
                'id' => $blog->id,
                'is_active' => $blog->is_active,
                'title' => $blog->title,
            ],
        ]);
    }

    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete this blog.',
            ], 403);
        }

        if ($blog->image && Storage::disk('public')->exists($blog->image)) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return response()->json([
            'success' => true,
            'message' => 'Blog deleted successfully',
        ]);
    }

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

        $blogs->transform(function ($blog) {
            if ($blog->image && !filter_var($blog->image, FILTER_VALIDATE_URL)) {
                $blog->image = asset('storage/' . $blog->image);
            }
            return $blog;
        });

        return response()->json($blogs);
    }

    public function uploadImage(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'error' => [
                    'message' => 'Unauthorized. Please login to upload images.',
                ],
            ], 401);
        }

        $request->validate([
            'upload' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->storeAs('public/blogs/content', $fileName);

            $url = asset('storage/blogs/content/' . $fileName);

            return response()->json([
                'uploaded' => 1,
                'fileName' => $fileName,
                'url' => $url,
            ]);
        }

        return response()->json([
            'uploaded' => 0,
            'error' => [
                'message' => 'Image upload failed.',
            ],
        ], 400);
    }
}

