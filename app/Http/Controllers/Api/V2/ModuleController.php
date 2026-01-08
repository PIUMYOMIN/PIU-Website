<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $module = Module::all();
        return response()->json($module);
    }

    /**
     * Store a newly created resource in storage.
     */
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
            'data' => $module
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $id = Module::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $id
        ], 200
        );
    }

    /**
     * Update the specified resource in storage.
     */
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
            'data' => $module
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}