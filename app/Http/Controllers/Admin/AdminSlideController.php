<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\User;

class AdminSlideController extends Controller
{
    public function index()
    {
       return view('admin.slides.index',[
        'slides' => Slide::all(),
        'user' => User::all()
       ]);
    }

    public function create()
    {
       return view('admin.slides.create');
    }

    public function store(Request $request)
    {
       $data = request()->validate([
            'title' => 'required|unique:slides,title',
            'image_tag' => 'required',
            'tag_link' => 'required',
            'description' => 'required',
            'slide_image' => 'required|image|mimes:png,jpg,jpeg'
       ]);

       if($request->hasFile('slide_image')){
            $filePatch = $request->file('slide_image')->store('slide_images','public');
            $data['slide_image'] = $filePatch;
       }

       $data['user_id'] = auth()->user()->id;

       Slide::create($data);

       return redirect('admin/slides');
    }

    public function edit(Slide $slide)
    {
        return view('admin.slides.edit',[
         'slide' => $slide,
        ]);
    }

    public function update(Request $request, Slide $slide)
    {
        $data = request()->validate([
            'title' => ['required', Rule::unique('slides','title')->ignore($slide->id)],
            'image_tag' => 'required',
            'tag_link' => 'required',
            'description' => 'required',
            'slide_image' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        if($request->hasFile('slide_image')){
            $filePatch = $request->file('slide_image')->store('slide_images','public');
            $data['slide_image'] = $filePatch;
        }

        $slide->update($data);

        return redirect('admin/slides');
    }

    public function delete(Slide $slide)
    {
        $slide->delete();

        return redirect()->back();
    }

    public function isActive(Request $request, Slide $slide)
    {
        $slide->update(['is_active' => !$slide->is_active]);

        return redirect()->back();
    }
}