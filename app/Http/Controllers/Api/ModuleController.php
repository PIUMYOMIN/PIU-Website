<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;

class ModuleController extends Controller
{
    public function index()
    {
        $module = Module::all();
        return response()->json($module);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:modules,name',
            'module_code' => 'required|string',
            'credit' => 'required|integer',
        ]);

        $module = Module::create($data);
        return response()->json([
            'success' => true,
            'data' => $module,
        ], 201);
    }

    public function show(string $id)
    {
        $module = Module::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $module,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $module = Module::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|unique:modules,name,' . $module->id,
            'module_code' => 'required|string',
            'credit' => 'required|integer',
        ]);

        $module->update($data);

        return response()->json([
            'success' => true,
            'data' => $module,
        ], 200);
    }

    public function destroy(string $id)
    {
        $module = Module::findOrFail($id);
        $module->delete();

        return response()->json([
            'success' => true,
            'message' => 'Module deleted successfully.',
        ], 200);
    }
}

