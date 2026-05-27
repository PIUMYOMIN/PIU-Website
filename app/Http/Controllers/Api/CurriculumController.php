<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Curriculum;
use Illuminate\Validation\Rule;

class CurriculumController extends Controller
{
    public function index()
    {
        $curriculums = Curriculum::with([
            'course:id,title',
            'module:id,name,module_code,credit',
            'year:id,name',
            'user:id,name,email',
        ])->latest()->get();
        return response()->json($curriculums);
    }

    public function store(Request $request)
    {
        $request->merge([
            'title' => trim((string) $request->input('title', '')),
        ]);

        $data = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('curriculums', 'title'),
            ],
            'description' => 'required|string',
            'module_id' => 'required|exists:modules,id',
            'course_id' => 'required|exists:courses,id',
            'year_id' => 'required|exists:years,id',
        ]);

        $this->ensureUniqueCombination($data['course_id'], $data['year_id'], $data['module_id']);
        $data['user_id'] = $request->user()->id;

        $curriculum = Curriculum::create($data);
        $curriculum->load(['course:id,title', 'module:id,name,module_code,credit', 'year:id,name', 'user:id,name,email']);

        return response()->json([
            'success' => true,
            'message' => 'Curriculum created successfully',
            'data' => $curriculum,
        ], 201);
    }

    public function show(string $id)
    {
        $curriculum = Curriculum::with([
            'course:id,title',
            'module:id,name,module_code,credit',
            'year:id,name',
            'user:id,name,email',
        ])->findOrFail($id);
        return response()->json($curriculum);
    }

    public function update(Request $request, string $id)
    {
        $curriculum = Curriculum::findOrFail($id);

        if ($request->has('title')) {
            $request->merge([
                'title' => trim((string) $request->input('title', '')),
            ]);
        }

        $data = $request->validate([
            'title' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('curriculums', 'title')->ignore($curriculum->id),
            ],
            'description' => 'sometimes|required|string',
            'module_id' => 'sometimes|required|exists:modules,id',
            'course_id' => 'sometimes|required|exists:courses,id',
            'year_id' => 'sometimes|required|exists:years,id',
        ]);

        $courseId = $data['course_id'] ?? $curriculum->course_id;
        $yearId = $data['year_id'] ?? $curriculum->year_id;
        $moduleId = $data['module_id'] ?? $curriculum->module_id;
        $this->ensureUniqueCombination($courseId, $yearId, $moduleId, $curriculum->id);

        if (isset($data['title'])) {
            $data['title'] = trim($data['title']);
        }
        $data['user_id'] = $request->user()->id;

        $curriculum->update($data);
        $curriculum->load(['course:id,title', 'module:id,name,module_code,credit', 'year:id,name', 'user:id,name,email']);

        return response()->json([
            'success' => true,
            'message' => 'Curriculum updated successfully',
            'data' => $curriculum,
        ]);
    }

    public function destroy(string $id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $curriculum->delete();

        return response()->json([
            'success' => true,
            'message' => 'Curriculum deleted successfully',
        ], 200);
    }

    private function ensureUniqueCombination(int $courseId, int $yearId, int $moduleId, ?int $ignoreId = null): void
    {
        $query = Curriculum::where('course_id', $courseId)
            ->where('year_id', $yearId)
            ->where('module_id', $moduleId);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        if ($query->exists()) {
            abort(response()->json([
                'success' => false,
                'message' => 'This course, year, and module combination already exists.',
                'errors' => [
                    'module_id' => ['This module is already assigned to the selected course and year.'],
                ],
            ], 422));
        }
    }
}

