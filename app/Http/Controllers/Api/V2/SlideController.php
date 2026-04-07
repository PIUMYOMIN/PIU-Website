<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slide;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check which columns exist in the slides table
        $hasIsActiveColumn = Schema::hasColumn('slides', 'is_active');
        $hasOrderColumn = Schema::hasColumn('slides', 'order');

        // Get only active slides for public API, all for admin
        if (request()->is('api/v2/slides') && !Auth::check()) {
            // Public API - only active slides
            $query = Slide::query();

            // Only filter by is_active if column exists
            if ($hasIsActiveColumn) {
                $query->where('is_active', true);
            }

            // Only order by order if column exists, otherwise by created_at
            if ($hasOrderColumn) {
                $query->orderBy('order', 'asc')
                    ->orderBy('created_at', 'desc');
            } else {
                $query->orderBy('created_at', 'desc');
            }

            $slides = $query->get();
        } else {
            // Admin API - all slides
            $query = Slide::query();

            if ($hasOrderColumn) {
                $query->orderBy('order', 'asc')
                    ->orderBy('created_at', 'desc');
            } else {
                $query->orderBy('created_at', 'desc');
            }

            $slides = $query->get();
        }

        // Add full URL for images
        $slides->transform(function ($slide) {
            if ($slide->slide_image && !filter_var($slide->slide_image, FILTER_VALIDATE_URL)) {
                $slide->slide_image = asset('storage/' . $slide->slide_image);
            }
            if ($slide->image_tag && !filter_var($slide->image_tag, FILTER_VALIDATE_URL)) {
                $slide->image_tag = asset('storage/' . $slide->image_tag);
            }
            return $slide;
        });

        return response()->json($slides);
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_tag' => 'nullable|string|max:255',
            'tag_link' => 'nullable|url',
            'slide_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        // Check if order column exists
        $hasOrderColumn = Schema::hasColumn('slides', 'order');
        $hasIsActiveColumn = Schema::hasColumn('slides', 'is_active');

        // Add order if column exists
        if ($hasOrderColumn) {
            $validated['order'] = $request->input('order', 0);
        }

        // Add is_active if column exists
        if ($hasIsActiveColumn) {
            $validated['is_active'] = $request->input('is_active', true);
        }

        // Handle file uploads
        if ($request->hasFile('slide_image')) {
            $imagePath = $request->file('slide_image')->store('slides', 'public');
            $validated['slide_image'] = $imagePath;
        }

        // Add user_id from authenticated user
        $validated['user_id'] = Auth::id();

        $slide = Slide::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Slide created successfully',
            'data' => $slide,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $slide = Slide::findOrFail($id);

        // Add full URL for images
        if ($slide->slide_image && !filter_var($slide->slide_image, FILTER_VALIDATE_URL)) {
            $slide->slide_image = asset('storage/' . $slide->slide_image);
        }
        if ($slide->image_tag && !filter_var($slide->image_tag, FILTER_VALIDATE_URL)) {
            $slide->image_tag = asset('storage/' . $slide->image_tag);
        }

        return response()->json($slide);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $slide = Slide::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_tag' => 'nullable|string|max:255',
            'tag_link' => 'nullable|url',
            'slide_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        // Check if order and is_active columns exist
        $hasOrderColumn = Schema::hasColumn('slides', 'order');
        $hasIsActiveColumn = Schema::hasColumn('slides', 'is_active');

        // Add order if column exists
        if ($hasOrderColumn) {
            $validated['order'] = $request->input('order', $slide->order);
        }

        // Add is_active if column exists
        if ($hasIsActiveColumn) {
            $validated['is_active'] = $request->input('is_active', $slide->is_active);
        }

        // Handle slide_image upload
        if ($request->hasFile('slide_image')) {
            // Delete old image if exists
            if ($slide->slide_image && Storage::disk('public')->exists($slide->slide_image)) {
                Storage::disk('public')->delete($slide->slide_image);
            }

            $imagePath = $request->file('slide_image')->store('slides', 'public');
            $validated['slide_image'] = $imagePath;
        } else {
            // Keep old image if not uploading new one
            unset($validated['slide_image']);
        }

        $slide->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Slide updated successfully',
            'data' => $slide,
        ]);
    }

    /**
     * Backwards-compatible toggle route handler.
     */
    public function toggleActive(Request $request, Slide $slide)
    {
        return $this->isActive($request, $slide);
    }

    /**
     * Toggle the active status of the specified slide (only if column exists).
     */
    public function isActive(Request $request, Slide $slide)
    {
        // Check if is_active column exists
        if (!Schema::hasColumn('slides', 'is_active')) {
            return response()->json([
                'success' => false,
                'message' => 'is_active column does not exist in slides table.'
            ], 400);
        }

        $slide->update(['is_active' => !$slide->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Slide status updated',
            'data' => [
                'id' => $slide->id,
                'is_active' => $slide->is_active,
                'title' => $slide->title
            ]
        ]);
    }

    /**
     * Update slide order (only if order column exists).
     */
    public function updateOrder(Request $request)
    {
        // Check if order column exists
        if (!Schema::hasColumn('slides', 'order')) {
            return response()->json([
                'success' => false,
                'message' => 'order column does not exist in slides table.'
            ], 400);
        }

        $request->validate([
            'slides' => 'required|array',
            'slides.*.id' => 'required|exists:slides,id',
            'slides.*.order' => 'required|integer',
        ]);

        foreach ($request->slides as $item) {
            Slide::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Slide order updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slide = Slide::findOrFail($id);

        // Delete image file if exists
        if ($slide->slide_image && Storage::disk('public')->exists($slide->slide_image)) {
            Storage::disk('public')->delete($slide->slide_image);
        }

        $slide->delete();

        return response()->json([
            'success' => true,
            'message' => 'Slide deleted successfully'
        ]);
    }
}