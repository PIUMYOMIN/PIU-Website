<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seminar;

class SeminarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seminars = Seminar::all();
        return response()->json($seminars);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'speaker' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $seminar = Seminar::create($data);
        return response()->json(['message' => 'Seminar created successfully', 'seminar' => $seminar], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $seminar = Seminar::findOrFail($id);
        return response()->json($seminar);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $seminar = Seminar::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'speaker' => 'sometimes|required|string|max:255',
            'date' => 'sometimes|required|date',
            'location' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $seminar->update($data);
        return response()->json(['message' => 'Seminar updated successfully', 'seminar' => $seminar]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $seminar = Seminar::findOrFail($id);
        $seminar->delete();
        return response()->json(['message' => 'Seminar deleted successfully']);
    }
}