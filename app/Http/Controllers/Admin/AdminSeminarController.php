<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Seminar;

class AdminSeminarController extends Controller
{
    public function index()
    {
       return view('admin.seminars.index',[
        'seminars' => Seminar::all(),
        'users' => User::all()
       ]);
    }

    public function create()
    {
        return view('admin.seminars.create');
    }

    public function store(Request $request)
    {
       $data = request()->validate([
            'name' => ['required',Rule::unique('seminars','name')],
            'description' => 'required',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required',
            'seat' => 'required',
            'city' => 'required',
            'country' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:1024',
       ]);

       $data['slug'] = Str::slug($data['name']);

       if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('seminar_images','public');
       }

       $data['user_id'] = auth()->user()->id;

       Seminar::create($data);

       return redirect('/admin/seminars');
    }

    public function edit(Seminar $seminar)
    {
       return view('admin.seminars.edit',[
        'seminar' => $seminar,
       ]);
    }

    public function update(Request $request, Seminar $seminar)
    {
       $data = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required',
            'seat' => 'required',
            'city' => 'required',
            'country' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:1024',
       ]);

       $data['slug'] = Str::slug($data['name']);

       if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('seminar_images','public');
       }

       $seminar->update($data);

       return redirect('/admin/seminars');
    }

    public function delete(Seminar $seminar)
    {
        $seminar->delete();

        return redirect()->back();
    }
}