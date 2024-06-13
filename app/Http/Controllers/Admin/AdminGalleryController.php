<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;

class AdminGalleryController extends Controller
{
    public function index()
    {
        return view('admin.gallery.index',[
            'galleries' => Gallery::all(),
        ]);
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
       $data = request()->validate([
        'image_tag' => 'required|unique:galleries,image_tag',
        'link1' => 'nullable',
        'link2' => 'nullable',
        'image' => 'required|image|mimes:png,jpg,jpeg'
       ]);

       if($request->hasFile('image')){
        $fileStore = $request->file('image')->store('gallery_photos','public');
        $data['image'] = $fileStore;
       }

       $data['user_id'] = auth()->user()->id;

       Gallery::create($data);

       return redirect('/admin/galleries');
    }

    public function edit(Gallery $gallery)
    {
       return view('admin.gallery.edit',[
        'gallery' => $gallery
       ]);
    }

    public function update(Request $request, Gallery $gallery)
    {
       $data = request()->validate([
        'image_tag' => 'nullable|unique:galleries,image_tag',
        'link1' => 'nullable',
        'link2' => 'nullable',
        'image' => 'nullable|image|mimes:png,jpg,jpeg'
       ]);

       if($request->hasFile('image')){
        $fileStore = $request->file('image')->store('gallery_photos','public');
        $data['image'] = $fileStore;
       }

       $data['user_id'] = auth()->user()->id;

       $gallery->update($data);

       return redirect('/admin/galleries');
    }

    public function delete(Gallery $gallery)
    {
        $gallery->delete();

        return redirect('/admin/galleries');
    }

    public function isActive(Request $request, Gallery $gallery)
    {

        $gallery->update(['is_active' => !$gallery->is_active]);

        return redirect()->back();
    }
}