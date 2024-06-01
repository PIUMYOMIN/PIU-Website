<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Team;
use App\Models\Department;
use App\Models\Position;

class AdminTeamController extends Controller
{
    public function index()
    {
       return view('admin.teams.index',[
        'teams' => Team::all()
       ]);
    }

    public function create()
    {
        return view('admin.teams.create',[
            'departments' => Department::all(),
            'positions' => Position::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'name' => ['required',Rule::unique('teams','name')],
            'email' => ['required',Rule::unique('teams','email')],
            'phone' => 'required',
            'address'=> 'required',
            'country' => 'nullable',
            'city' => 'nullable',
            'link1' => 'nullable',
            'link2' => 'nullable',
            'description' => 'nullable',
            'department_id' => 'required',
            'position_id' => 'required',
            'profile' => 'required|mimes:png,jpg,jpeg',
        ]);

        if($request->hasFile('profile')){
            $filePatch = $request->file('profile')->store('team_profiles','public');
        }

        $data['profile'] = $filePatch;
        $data['slug'] = Str::slug($data['name']);
        $data['user_id'] = auth()->user()->id;

        Team::create($data);

        return redirect('/admin/teams');
    }

    public function edit($slug)
    {
        $team = Team::where('slug',$slug)->firstOrFail();
        return view('admin.teams.edit',[
            'team' => $team,
            'departments' => Department::all(),
            'positions' => Position::all(),
        ]);
    }

    public function update(Request $request, $slug)
    {
        $team = Team::where('slug',$slug)->firstOrFail();
       $data = request()->validate([
            'name' => 'required',
            'email' => ["required",Rule::unique('teams','email')->ignore($team->id)],
            'phone' => 'required',
            'address'=> 'required',
            'country' => 'nullable',
            'city' => 'nullable',
            'link1' => 'nullable',
            'link2' => 'nullable',
            'description' => 'nullable',
            'department_id' => 'required',
            'position_id' => 'required',
            'profile' => 'nullable|mimes:png,jpg,jpeg',
        ]);

        if($request->hasFile('profile')){
            $filePatch = $request->file('profile')->store('team_profiles','public');
            $data['profile'] = $filePatch;
        }else{
            $data['profile'] = $team->profile;
        }

        $data['slug'] = Str::slug($data['name']);


        $team->update($data);

        return redirect('/admin/teams');
    }

    public function destroy($slug)
    {
        $team = Team::where('slug',$slug)->firstOrFail();
        $team->delete();

        return redirect()->back();
    }
}