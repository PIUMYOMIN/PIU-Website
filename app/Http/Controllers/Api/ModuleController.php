<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use Illuminate\Validation\Rule;

class ModuleController extends Controller
{
    public function index()
    {
        $module = Module::withCount([
            'curriculums',
            'assignments',
            'subjects',
            'gradings',
            'studentAssignments',
        ])->latest()->get();
        return response()->json($module);
    }

    public function store(Request $request)
    {
        $request->merge([
            'name' => trim((string) $request->input('name', '')),
            'module_code' => strtoupper(trim((string) $request->input('module_code', ''))),
        ]);

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:modules,name',
            'module_code' => 'required|string|max:255|unique:modules,module_code',
            'credit' => 'required|integer|min:1|max:100',
        ]);

        $module = Module::create($data);
        return response()->json([
            'success' => true,
            'data' => $module,
        ], 201);
    }

    public function show(string $id)
    {
        $module = Module::withCount([
            'curriculums',
            'assignments',
            'subjects',
            'gradings',
            'studentAssignments',
        ])->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $module,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $module = Module::findOrFail($id);

        $request->merge([
            'name' => trim((string) $request->input('name', '')),
            'module_code' => strtoupper(trim((string) $request->input('module_code', ''))),
        ]);

        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('modules', 'name')->ignore($module->id),
            ],
            'module_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('modules', 'module_code')->ignore($module->id),
            ],
            'credit' => 'required|integer|min:1|max:100',
        ]);

        $module->update($data);

        return response()->json([
            'success' => true,
            'data' => $module,
        ], 200);
    }

    public function destroy(string $id)
    {
        $module = Module::withCount([
            'curriculums',
            'assignments',
            'subjects',
            'gradings',
            'studentAssignments',
        ])->findOrFail($id);

        $usageCount = $module->curriculums_count
            + $module->assignments_count
            + $module->subjects_count
            + $module->gradings_count
            + $module->student_assignments_count;

        if ($usageCount > 0) {
            return response()->json([
                'success' => false,
                'message' => 'This module cannot be deleted while it is used by curriculum, assignments, subjects, or grades.',
            ], 422);
        }

        $module->delete();

        return response()->json([
            'success' => true,
            'message' => 'Module deleted successfully.',
        ], 200);
    }
}

