<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Position;

class AdminPositionController extends Controller
{
    public function index()
    {
       return view('admin.positions.index',[
        'positions' => Position::all()
       ]);
    }

    public function create()
    {
        return view('admin.positions.create');
    }

    public function store()
    {
       $data = request()->validate([
        'name' => 'required',
        'description' => 'nullable'
       ]);

       Position::create($data);

       return redirect('/admin/positions');
    }

    public function edit(Position $position)
    {
       return view('admin.positions.edit',[
        'position' => $position,
       ]);
    }

    public function update(Position $position)
    {
       $data = request()->validate([
        'name' => ['required',Rule::unique('positions','name')->ignore($position->id)],
        'description' => 'nullable',
       ]);

       $position->update($data);

       return redirect('/admin/positions');
    }
}