<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slide;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get only active slides for public API, all for admin
        if (request()->is('api/v2/slides') && !Auth::check()) {
            $slides = Slide::where('is_active', true)
                ->orderBy('order', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $slides = Slide::orderBy('order', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_tag' => 'nullable|string|max:255',
            'tag_link' => 'nullable|url',
            'slide_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:5120',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Handle file uploads
        if ($request->hasFile('slide_image')) {
            $imagePath = $request->file('slide_image')->store('slides', 'public');
            $validated['slide_image'] = $imagePath;
        }

        // Add user_id from authenticated user
        $validated['user_id'] = auth()->id();

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
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

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
     * Toggle the active status of the specified slide.
     */
    public function isActive(Request $request, Slide $slide)
    {
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
     * Update slide order (for sorting)
     */
    public function updateOrder(Request $request)
    {
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