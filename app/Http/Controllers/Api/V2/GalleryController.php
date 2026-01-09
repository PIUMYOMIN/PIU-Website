<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Schema;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if gallery table has is_active column
        $hasIsActiveColumn = Schema::hasColumn('galleries', 'is_active');
        
        // Get all galleries (for admin) or only active galleries (for public)
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            $query = Gallery::with('user:id,name,email')
                ->orderBy('created_at', 'desc');
        } else {
            $query = Gallery::with('user:id,name,email')
                ->orderBy('created_at', 'desc');
            
            // Only filter by is_active if column exists
            if ($hasIsActiveColumn) {
                $query->where('is_active', true);
            }
        }

        $galleries = $query->get();

        // Add full URL for images
        $galleries->transform(function ($gallery) {
            if ($gallery->image && !filter_var($gallery->image, FILTER_VALIDATE_URL)) {
                $gallery->image = asset('storage/' . $gallery->image);
            }
            return $gallery;
        });

        return response()->json($galleries);
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
            'image_tag' => 'required|string|max:255|unique:galleries,image_tag',
            'link1' => 'nullable|url',
            'link2' => 'nullable|url',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:5120',
        ]);

        // Only add is_active if column exists
        if (Schema::hasColumn('galleries', 'is_active')) {
            $validated['is_active'] = $request->input('is_active', true);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('galleries', 'public');
            $validated['image'] = $imagePath;
        }

        // Add user_id from authenticated user
        $validated['user_id'] = Auth::id();

        $gallery = Gallery::create($validated);

        // Load user relationship
        $gallery->load('user:id,name,email');

        return response()->json([
            'success' => true,
            'message' => 'Gallery item created successfully',
            'data' => $gallery,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gallery = Gallery::with('user:id,name,email')->findOrFail($id);

        // Add full URL for image
        if ($gallery->image && !filter_var($gallery->image, FILTER_VALIDATE_URL)) {
            $gallery->image = asset('storage/' . $gallery->image);
        }

        return response()->json($gallery);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gallery = Gallery::findOrFail($id);

        // Check if user is authorized (owner or admin)
        if ($gallery->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this gallery item.'
            ], 403);
        }

        $validated = $request->validate([
            'image_tag' => ['nullable', 'string', 'max:255', Rule::unique('galleries', 'image_tag')->ignore($gallery->id)],
            'link1' => 'nullable|url',
            'link2' => 'nullable|url',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
        ]);

        // Only update is_active if column exists
        if (Schema::hasColumn('galleries', 'is_active')) {
            $validated['is_active'] = $request->input('is_active', $gallery->is_active);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }

            $imagePath = $request->file('image')->store('galleries', 'public');
            $validated['image'] = $imagePath;
        } else {
            // Keep old image if not uploading new one
            unset($validated['image']);
        }

        $gallery->update($validated);

        // Reload user relationship
        $gallery->load('user:id,name,email');

        return response()->json([
            'success' => true,
            'message' => 'Gallery item updated successfully',
            'data' => $gallery,
        ]);
    }

    /**
     * Toggle active status of gallery item (only if column exists).
     */
    public function toggleActive(string $id)
    {
        // Check if column exists
        if (!Schema::hasColumn('galleries', 'is_active')) {
            return response()->json([
                'success' => false,
                'message' => 'is_active column does not exist in galleries table.'
            ], 400);
        }

        $gallery = Gallery::findOrFail($id);

        // Check if user is authorized (owner or admin)
        if ($gallery->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this gallery item.'
            ], 403);
        }

        $gallery->update(['is_active' => !$gallery->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Gallery item status updated',
            'data' => [
                'id' => $gallery->id,
                'is_active' => $gallery->is_active,
                'image_tag' => $gallery->image_tag
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gallery = Gallery::findOrFail($id);

        // Check if user is authorized (owner or admin)
        if ($gallery->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete this gallery item.'
            ], 403);
        }

        // Delete image file if exists
        if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gallery item deleted successfully'
        ]);
    }

    /**
     * Get galleries by tag/category
     */
    public function byTag(string $tag)
    {
        $hasIsActiveColumn = Schema::hasColumn('galleries', 'is_active');
        
        $query = Gallery::where('image_tag', 'like', "%{$tag}%")
            ->with('user:id,name,email')
            ->orderBy('created_at', 'desc');
            
        // Only filter by is_active if column exists
        if ($hasIsActiveColumn) {
            $query->where('is_active', true);
        }
        
        $galleries = $query->get();

        // Add full URL for images
        $galleries->transform(function ($gallery) {
            if ($gallery->image && !filter_var($gallery->image, FILTER_VALIDATE_URL)) {
                $gallery->image = asset('storage/' . $gallery->image);
            }
            return $gallery;
        });

        return response()->json($galleries);
    }

    /**
     * Get recent galleries
     */
    public function recent(int $limit = 10)
    {
        $hasIsActiveColumn = Schema::hasColumn('galleries', 'is_active');
        
        $query = Gallery::with('user:id,name,email')
            ->orderBy('created_at', 'desc')
            ->limit($limit);
            
        // Only filter by is_active if column exists
        if ($hasIsActiveColumn) {
            $query->where('is_active', true);
        }
        
        $galleries = $query->get();

        // Add full URL for images
        $galleries->transform(function ($gallery) {
            if ($gallery->image && !filter_var($gallery->image, FILTER_VALIDATE_URL)) {
                $gallery->image = asset('storage/' . $gallery->image);
            }
            return $gallery;
        });

        return response()->json($galleries);
    }
}