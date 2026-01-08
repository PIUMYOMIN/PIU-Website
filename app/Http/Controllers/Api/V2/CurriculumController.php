<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curriculum;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $curriculums = Curriculum::all();
        return response()->json($curriculums);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'module_ids' => 'nullable|array',
            'course_id' => 'required|exists:courses,id',
            'year_id' => 'required|exists:years,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $curriculum = Curriculum::create($data);
        return response()->json(['message' => 'Curriculum created successfully', 'curriculum' => $curriculum], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $curriculum = Curriculum::findOrFail($id);
        return response()->json($curriculum);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $curriculum = Curriculum::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'module_ids' => 'sometimes|nullable|array',
            'course_id' => 'sometimes|required|exists:courses,id',
            'year_id' => 'sometimes|required|exists:years,id',
            'user_id' => 'sometimes|required|exists:users,id',
        ]);

        $curriculum->update($data);
        return response()->json(['message' => 'Curriculum updated successfully', 'curriculum' => $curriculum]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}