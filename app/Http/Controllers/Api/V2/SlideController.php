<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slide;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slides = Slide::all();
        return response()->json($slides);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_tag' => 'required|url',
            'tag_link' => 'nullable|url',
            'slide_image' => 'required|url',
            'is_active' => 'boolean',
            'user_id' => 'required|exists:users,id'
        ]);

        $slide = Slide::create($data);
        return response()->json([
            'message' => 'Slide created successfully',
            'slide' => $slide,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $slide = Slide::findOrFail($id);
        return response()->json($slide);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $slide = Slide::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_tag' => 'required|url',
            'tag_link' => 'nullable|url',
            'slide_image' => 'required|url',
            'is_active' => 'boolean',
            'user_id' => 'required|exists:users,id'
        ]);

        $slide->update($data);
        return response()->json([
            'message' => 'Slide updated successfully',
            'slide' => $slide,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}