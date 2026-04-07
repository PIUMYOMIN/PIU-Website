<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slide;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class SlideController extends Controller
{
    public function index()
    {
        $hasIsActiveColumn = Schema::hasColumn('slides', 'is_active');
        $hasOrderColumn = Schema::hasColumn('slides', 'order');

        if (request()->is('api/v2/slides') && !Auth::check()) {
            $query = Slide::query();
            if ($hasIsActiveColumn) $query->where('is_active', true);

            if ($hasOrderColumn) $query->orderBy('order', 'asc')->orderBy('created_at', 'desc');
            else $query->orderBy('created_at', 'desc');

            $slides = $query->get();
        } else {
            $query = Slide::query();
            if ($hasOrderColumn) $query->orderBy('order', 'asc')->orderBy('created_at', 'desc');
            else $query->orderBy('created_at', 'desc');
            $slides = $query->get();
        }

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

    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Admin access required.',
            ], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_tag' => 'nullable|string|max:255',
            'tag_link' => 'nullable|url',
            'slide_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        $hasOrderColumn = Schema::hasColumn('slides', 'order');
        $hasIsActiveColumn = Schema::hasColumn('slides', 'is_active');

        if ($hasOrderColumn) $validated['order'] = $request->input('order', 0);
        if ($hasIsActiveColumn) $validated['is_active'] = $request->input('is_active', true);

        if ($request->hasFile('slide_image')) {
            $validated['slide_image'] = $request->file('slide_image')->store('slides', 'public');
        }

        $validated['user_id'] = Auth::id();
        $slide = Slide::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Slide created successfully',
            'data' => $slide,
        ], 201);
    }

    public function show(string $id)
    {
        $slide = Slide::findOrFail($id);

        if ($slide->slide_image && !filter_var($slide->slide_image, FILTER_VALIDATE_URL)) {
            $slide->slide_image = asset('storage/' . $slide->slide_image);
        }
        if ($slide->image_tag && !filter_var($slide->image_tag, FILTER_VALIDATE_URL)) {
            $slide->image_tag = asset('storage/' . $slide->image_tag);
        }

        return response()->json($slide);
    }

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

        $hasOrderColumn = Schema::hasColumn('slides', 'order');
        $hasIsActiveColumn = Schema::hasColumn('slides', 'is_active');

        if ($hasOrderColumn) $validated['order'] = $request->input('order', $slide->order);
        if ($hasIsActiveColumn) $validated['is_active'] = $request->input('is_active', $slide->is_active);

        if ($request->hasFile('slide_image')) {
            if ($slide->slide_image && Storage::disk('public')->exists($slide->slide_image)) {
                Storage::disk('public')->delete($slide->slide_image);
            }
            $validated['slide_image'] = $request->file('slide_image')->store('slides', 'public');
        } else {
            unset($validated['slide_image']);
        }

        $slide->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Slide updated successfully',
            'data' => $slide,
        ]);
    }

    public function toggleActive(Request $request, Slide $slide)
    {
        return $this->isActive($request, $slide);
    }

    public function isActive(Request $request, Slide $slide)
    {
        if (!Schema::hasColumn('slides', 'is_active')) {
            return response()->json([
                'success' => false,
                'message' => 'is_active column does not exist in slides table.',
            ], 400);
        }

        $slide->update(['is_active' => !$slide->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Slide status updated',
            'data' => [
                'id' => $slide->id,
                'is_active' => $slide->is_active,
                'title' => $slide->title,
            ],
        ]);
    }

    public function updateOrder(Request $request)
    {
        if (!Schema::hasColumn('slides', 'order')) {
            return response()->json([
                'success' => false,
                'message' => 'order column does not exist in slides table.',
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
            'message' => 'Slide order updated successfully',
        ]);
    }

    public function destroy(string $id)
    {
        $slide = Slide::findOrFail($id);

        if ($slide->slide_image && Storage::disk('public')->exists($slide->slide_image)) {
            Storage::disk('public')->delete($slide->slide_image);
        }

        $slide->delete();

        return response()->json([
            'success' => true,
            'message' => 'Slide deleted successfully',
        ]);
    }
}

