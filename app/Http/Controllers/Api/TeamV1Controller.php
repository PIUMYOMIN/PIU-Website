<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;

class TeamV1Controller extends Controller
{
    public function index()
    {
        $teams = Team::where('is_active', 1)
            ->with('department')
            ->with('position')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($teams);
    }

    public function show(string $slug)
    {
        $team = Team::where('slug', $slug)
            ->with('position')
            ->with('department')
            ->firstOrFail();

        return response()->json($team);
    }
}

