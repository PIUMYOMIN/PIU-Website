<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with(['department', 'position'])->latest()->get();
        return response()->json([
            'success' => true,
            'data' => $teams,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', Rule::unique('teams', 'name')],
            'email' => ['required', 'email', Rule::unique('teams', 'email')],
            'phone' => ['required', 'string'],
            'address' => ['required', 'string'],
            'country' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'link1' => ['nullable', 'string'],
            'link2' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'department_id' => ['required', 'integer'],
            'position_id' => ['required', 'integer'],
            'is_active' => ['nullable', 'boolean'],
            'profile' => ['required', 'file', 'mimes:png,jpg,jpeg'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['user_id'] = auth()->id();
        $data['profile'] = $request->file('profile')->store('team_profiles', 'public');

        $team = Team::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Team member created successfully',
            'data' => $team->fresh()->load(['department', 'position']),
        ], 201);
    }

    public function show(string $id)
    {
        $team = Team::with(['department', 'position'])->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $team,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $team = Team::findOrFail($id);

        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', Rule::unique('teams', 'name')->ignore($team->id)],
            'email' => ['sometimes', 'required', 'email', Rule::unique('teams', 'email')->ignore($team->id)],
            'phone' => ['sometimes', 'required', 'string'],
            'address' => ['sometimes', 'required', 'string'],
            'country' => ['sometimes', 'nullable', 'string'],
            'city' => ['sometimes', 'nullable', 'string'],
            'link1' => ['sometimes', 'nullable', 'string'],
            'link2' => ['sometimes', 'nullable', 'string'],
            'description' => ['sometimes', 'nullable', 'string'],
            'department_id' => ['sometimes', 'required', 'integer'],
            'position_id' => ['sometimes', 'required', 'integer'],
            'is_active' => ['sometimes', 'boolean'],
            'profile' => ['sometimes', 'nullable', 'file', 'mimes:png,jpg,jpeg'],
        ]);

        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        if ($request->hasFile('profile')) {
            if ($team->profile) {
                Storage::disk('public')->delete($team->profile);
            }
            $data['profile'] = $request->file('profile')->store('team_profiles', 'public');
        } else {
            unset($data['profile']);
        }

        $team->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Team member updated successfully',
            'data' => $team->fresh()->load(['department', 'position']),
        ], 200);
    }

    public function destroy(string $id)
    {
        $team = Team::findOrFail($id);

        if ($team->profile) {
            Storage::disk('public')->delete($team->profile);
        }

        $team->delete();

        return response()->json([
            'success' => true,
            'message' => 'Team member deleted successfully',
        ], 200);
    }

    public function toggleActive(Team $team)
    {
        $team->update(['is_active' => !$team->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Team status updated',
            'data' => $team->fresh(),
        ], 200);
    }
}

