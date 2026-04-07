<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class NewsController extends Controller
{
    public function index()
    {
        $hasIsActiveColumn = \Schema::hasColumn('news', 'is_active');

        if (Auth::check() && Auth::user()->hasRole('admin')) {
            $query = News::with('user:id,name,email')->latest();
        } else {
            $query = News::with('user:id,name,email')->latest();
            if ($hasIsActiveColumn) {
                $query->where('is_active', true);
            }
        }

        $news = $query->get();

        $news->transform(function ($newsItem) {
            if ($newsItem->image && !filter_var($newsItem->image, FILTER_VALIDATE_URL)) {
                $newsItem->image = asset('storage/' . $newsItem->image);
            }
            return $newsItem;
        });

        return response()->json($news);
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
            'title' => 'required|unique:news,title',
            'body' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:5120',
        ]);

        if (\Schema::hasColumn('news', 'is_active')) {
            $validated['is_active'] = $request->input('is_active', true);
        }

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        $validated['user_id'] = Auth::id();
        $news = News::create($validated);
        $news->load('user:id,name,email');

        return response()->json([
            'success' => true,
            'message' => 'News created successfully',
            'data' => $news,
        ], 201);
    }

    public function show(string $id)
    {
        $news = News::with('user:id,name,email')->findOrFail($id);

        if ($news->image && !filter_var($news->image, FILTER_VALIDATE_URL)) {
            $news->image = asset('storage/' . $news->image);
        }

        return response()->json($news);
    }

    public function showBySlug(string $slug)
    {
        $hasIsActiveColumn = \Schema::hasColumn('news', 'is_active');

        $query = News::where('slug', $slug)->with('user:id,name,email');
        if ($hasIsActiveColumn) {
            $query->where('is_active', true);
        }

        $news = $query->firstOrFail();

        if ($news->image && !filter_var($news->image, FILTER_VALIDATE_URL)) {
            $news->image = asset('storage/' . $news->image);
        }

        return response()->json($news);
    }

    public function update(Request $request, string $id)
    {
        $news = News::findOrFail($id);

        if ($news->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this news.',
            ], 403);
        }

        $validated = $request->validate([
            'title' => ['required', Rule::unique('news', 'title')->ignore($news->id)],
            'body' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:5120',
        ]);

        if (\Schema::hasColumn('news', 'is_active')) {
            $validated['is_active'] = $request->input('is_active', $news->is_active);
        }

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }
            $validated['image'] = $request->file('image')->store('news', 'public');
        } else {
            unset($validated['image']);
        }

        $news->update($validated);
        $news->load('user:id,name,email');

        return response()->json([
            'success' => true,
            'message' => 'News updated successfully',
            'data' => $news,
        ]);
    }

    public function toggleActive(string $id)
    {
        if (!\Schema::hasColumn('news', 'is_active')) {
            return response()->json([
                'success' => false,
                'message' => 'is_active column does not exist in news table.',
            ], 400);
        }

        $news = News::findOrFail($id);

        if ($news->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this news.',
            ], 403);
        }

        $news->update(['is_active' => !$news->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'News status updated',
            'data' => [
                'id' => $news->id,
                'is_active' => $news->is_active,
                'title' => $news->title,
            ],
        ]);
    }

    public function destroy(string $id)
    {
        $news = News::findOrFail($id);

        if ($news->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete this news.',
            ], 403);
        }

        if ($news->image && Storage::disk('public')->exists($news->image)) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return response()->json([
            'success' => true,
            'message' => 'News deleted successfully',
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $hasIsActiveColumn = \Schema::hasColumn('news', 'is_active');

        $newsQuery = News::where(function ($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
                ->orWhere('body', 'like', "%{$query}%");
        });

        if ($hasIsActiveColumn) {
            $newsQuery->where('is_active', true);
        }

        $news = $newsQuery->with('user:id,name,email')->latest()->get();

        $news->transform(function ($newsItem) {
            if ($newsItem->image && !filter_var($newsItem->image, FILTER_VALIDATE_URL)) {
                $newsItem->image = asset('storage/' . $newsItem->image);
            }
            return $newsItem;
        });

        return response()->json($news);
    }
}

