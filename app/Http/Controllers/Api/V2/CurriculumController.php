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
            'description' => 'required|string',
            'module_id' => 'required|exists:modules,id',
            'course_id' => 'required|exists:courses,id',
            'year_id' => 'required|exists:years,id',
        ]);

        $data['user_id'] = $request->user()->id;

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
            'description' => 'sometimes|required|string',
            'module_id' => 'sometimes|required|exists:modules,id',
            'course_id' => 'sometimes|required|exists:courses,id',
            'year_id' => 'sometimes|required|exists:years,id',
        ]);

        $data['user_id'] = $request->user()->id;

        $curriculum->update($data);
        return response()->json(['message' => 'Curriculum updated successfully', 'curriculum' => $curriculum]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $curriculum->delete();

        return response()->json([
            'success' => true,
            'message' => 'Curriculum deleted successfully',
        ], 200);
    }
}