<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Department;
use App\Models\Position;

class TeamController extends Controller
{
    public function index()
    {
        return view('user.team.index',[
            'teams' => Team::all(),
            'departments' => Department::all(),
            'positions' => Position::all(),
        ]);
    }

    public function show(Team $team)
    {
       return view('user.team.show',[
        'team' => $team,
       ]);
    }
}