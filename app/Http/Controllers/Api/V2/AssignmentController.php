<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\StudentAssignment;
use App\Models\Course;
use App\Models\Module;
use App\Models\Subject;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'assignments' => Assignment::latest()->get(),
                'student_assignments' => StudentAssignment::all(),
                'courses' => Course::all(),
                'modules' => Module::all(),
                'subjects' => Subject::all(),
            ]
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|unique:assignments,name',
                'description' => 'nullable|string',
                'course_id' => 'required|integer',
                'module_id' => 'required|integer',
                'subject_id' => 'nullable|integer',
                'attach_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            ]);

            $data['slug'] = Str::slug($data['name']);
            $data['user_id'] = auth()->id();

            if ($request->hasFile('attach_file')) {
                $data['attach_file'] = $request->file('attach_file')
                    ->store('assignment_attachments', 'public');
            }

            $assignment = Assignment::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Assignment created successfully',
                'data' => $assignment
            ], 201);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Assignment creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $assignment = Assignment::where('slug', $id)->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $assignment
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $assignment = Assignment::findOrFail($id);

            $data = $request->validate([
                'name' => [
                    'sometimes',
                    'string',
                    Rule::unique('assignments', 'name')->ignore($assignment->id),
                ],
                'description' => 'nullable|string',
                'course_id' => 'nullable|integer',
                'module_id' => 'nullable|integer',
                'subject_id' => 'nullable|integer',
                'attach_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            ]);

            if (isset($data['name'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            if ($request->hasFile('attach_file')) {
                // delete old file
                if ($assignment->attach_file) {
                    Storage::disk('public')->delete($assignment->attach_file);
                }

                $data['attach_file'] = $request->file('attach_file')
                    ->store('assignment_attachments', 'public');
            }

            $data['user_id'] = auth()->id();

            $assignment->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Assignment updated successfully',
                'data' => $assignment
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Assignment update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $assignment = Assignment::findOrFail($id);

        if ($assignment->attach_file) {
            Storage::disk('public')->delete($assignment->attach_file);
        }

        $assignment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Assignment deleted successfully'
        ], 200);
    }
}