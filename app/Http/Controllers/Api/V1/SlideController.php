<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slide;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $slides = Slide::where('is_active',true)->latest()->get();
        return response()->json($slides);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json(['message' => 'Create method is supported for creating new slides.'], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'image_tag' => 'required|string',
            'tag_link' => 'nullable|string',
            'slide_image' => 'required|string',
            'is_active' => 'required|boolean',
            'user_id' => 'required|string',
        ]);

        // Ensure that the user_id matches the authenticated user's ID
        if ($validatedData['user_id'] !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized user.'], 403);
        }

            $slide = Slide::create($validatedData);

            return response()->json($slide, 201);
        } catch (ValidationException $exception) {
            return response()->json(['error' => $exception->errors()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        try {
            $slide = Slide::findOrFail($id);
            return response()->json($slide);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Slide not found.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $slide = Slide::where('id',$id)->firstOrFail();
        try {
            $slide = Slide::findOrFail($id);
            return response()->json($slide);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Slide not found.'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
        $slide = Slide::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'image_tag' => 'required|string',
            'tag_link' => 'nullable|string',
            'slide_image' => 'required|string',
            'is_active' => 'required|boolean',
            'user_id' => 'required|string',
        ]);

        // Ensure that the user_id matches the authenticated user's ID
        if ($validatedData['user_id'] !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized user.'], 403);
        }

        $slide->update($validatedData);

        return response()->json($slide, 200);
    } catch (ModelNotFoundException $exception) {
        return response()->json(['error' => 'Slide not found.'], 404);
    } catch (ValidationException $exception) {
        return response()->json(['error' => $exception->errors()], 422);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}