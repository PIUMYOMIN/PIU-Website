<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if news table has is_active column
        $hasIsActiveColumn = \Schema::hasColumn('news', 'is_active');

        if (Auth::check() && Auth::user()->hasRole('admin')) {
            // Admin can see all news
            $query = News::with('user:id,name,email')
                ->latest();
        } else {
            // Public users - only show active news if column exists
            $query = News::with('user:id,name,email')
                ->latest();

            if ($hasIsActiveColumn) {
                $query->where('is_active', true);
            }
        }

        $news = $query->get();

        // Add full URL for images
        $news->transform(function ($newsItem) {
            if ($newsItem->image && !filter_var($newsItem->image, FILTER_VALIDATE_URL)) {
                $newsItem->image = asset('storage/' . $newsItem->image);
            }
            return $newsItem;
        });

        return response()->json($news);
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
            'title' => 'required|unique:news,title',
            'body' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:5120',
        ]);

        // Only add is_active if column exists
        if (\Schema::hasColumn('news', 'is_active')) {
            $validated['is_active'] = $request->input('is_active', true);
        }

        // Generate slug from title
        $validated['slug'] = Str::slug($validated['title']);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
            $validated['image'] = $imagePath;
        }

        // Add user_id from authenticated user
        $validated['user_id'] = Auth::id();

        $news = News::create($validated);

        // Load user relationship
        $news->load('user:id,name,email');

        return response()->json([
            'success' => true,
            'message' => 'News created successfully',
            'data' => $news,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $news = News::with('user:id,name,email')->findOrFail($id);

        // Add full URL for image
        if ($news->image && !filter_var($news->image, FILTER_VALIDATE_URL)) {
            $news->image = asset('storage/' . $news->image);
        }

        return response()->json($news);
    }

    /**
     * Display news by slug.
     */
    public function showBySlug(string $slug)
    {
        // Check if news table has is_active column
        $hasIsActiveColumn = \Schema::hasColumn('news', 'is_active');

        $query = News::where('slug', $slug)
            ->with('user:id,name,email');

        // Only filter by is_active if column exists
        if ($hasIsActiveColumn) {
            $query->where('is_active', true);
        }

        $news = $query->firstOrFail();

        // Add full URL for image
        if ($news->image && !filter_var($news->image, FILTER_VALIDATE_URL)) {
            $news->image = asset('storage/' . $news->image);
        }

        return response()->json($news);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $news = News::findOrFail($id);

        // Check if user is authorized (owner or admin)
        if ($news->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this news.'
            ], 403);
        }

        $validated = $request->validate([
            'title' => ['required', Rule::unique('news', 'title')->ignore($news->id)],
            'body' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:5120',
        ]);

        // Only update is_active if column exists
        if (\Schema::hasColumn('news', 'is_active')) {
            $validated['is_active'] = $request->input('is_active', $news->is_active);
        }

        // Generate slug from title
        $validated['slug'] = Str::slug($validated['title']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }

            $imagePath = $request->file('image')->store('news', 'public');
            $validated['image'] = $imagePath;
        } else {
            // Keep old image if not uploading new one
            unset($validated['image']);
        }

        $news->update($validated);

        // Reload user relationship
        $news->load('user:id,name,email');

        return response()->json([
            'success' => true,
            'message' => 'News updated successfully',
            'data' => $news,
        ]);
    }

    /**
     * Toggle active status of news (only if column exists).
     */
    public function toggleActive(string $id)
    {
        // Check if column exists
        if (!\Schema::hasColumn('news', 'is_active')) {
            return response()->json([
                'success' => false,
                'message' => 'is_active column does not exist in news table.'
            ], 400);
        }

        $news = News::findOrFail($id);

        // Check if user is authorized (owner or admin)
        if ($news->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this news.'
            ], 403);
        }

        $news->update(['is_active' => !$news->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'News status updated',
            'data' => [
                'id' => $news->id,
                'is_active' => $news->is_active,
                'title' => $news->title
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = News::findOrFail($id);

        // Check if user is authorized (owner or admin)
        if ($news->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete this news.'
            ], 403);
        }

        // Delete image file if exists
        if ($news->image && Storage::disk('public')->exists($news->image)) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return response()->json([
            'success' => true,
            'message' => 'News deleted successfully'
        ]);
    }

    /**
     * Search news by title or body.
     */
    public function search(Request $request)
    {
        $query = $request->input('search');

        // Check if news table has is_active column
        $hasIsActiveColumn = \Schema::hasColumn('news', 'is_active');

        $newsQuery = News::where(function ($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
                ->orWhere('body', 'like', "%{$query}%");
        });

        // Only filter by is_active if column exists
        if ($hasIsActiveColumn) {
            $newsQuery->where('is_active', true);
        }

        $news = $newsQuery->with('user:id,name,email')
            ->latest()
            ->get();

        // Add full URL for images
        $news->transform(function ($newsItem) {
            if ($newsItem->image && !filter_var($newsItem->image, FILTER_VALIDATE_URL)) {
                $newsItem->image = asset('storage/' . $newsItem->image);
            }
            return $newsItem;
        });

        return response()->json($news);
    }
}