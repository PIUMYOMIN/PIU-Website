<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::latest()->get();
        return response()->json([
            'success' => true,
            'data' => $partners,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'web_address' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $data['slug'] = Str::slug($data['name']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('mou_partnership_images', 'public');
        }

        $partner = Partner::create($data);

        return response()->json([
            'success' => true,
            'data' => $partner,
        ], 201);
    }

    public function show(string $id)
    {
        $partner = Partner::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $partner,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $partner = Partner::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'web_address' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        if ($request->hasFile('image')) {
            if ($partner->image && Storage::disk('public')->exists($partner->image)) {
                Storage::disk('public')->delete($partner->image);
            }
            $data['image'] = $request->file('image')->store('mou_partnership_images', 'public');
        } else {
            unset($data['image']);
        }

        $partner->update($data);

        return response()->json([
            'success' => true,
            'data' => $partner,
        ]);
    }

    public function destroy(string $id)
    {
        $partner = Partner::findOrFail($id);
        if ($partner->image && Storage::disk('public')->exists($partner->image)) {
            Storage::disk('public')->delete($partner->image);
        }
        $partner->delete();

        return response()->json([
            'success' => true,
            'message' => 'MOU partner deleted successfully',
        ]);
    }
}
