<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use App\Models\Partner;

class AdminPartnerController extends Controller
{
    public function index()
    {
        return view('admin.partner.index',[
            'partners' => Partner::all(),
        ]);
    }

    public function create()
    {
        return view('admin.partner.create');
    }

    public function store(Request $request)
    {
        // dd(request()->all());
        $formData = request()->validate([
            'name' => 'required',
            'web_address' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $formData['slug'] = Str::slug($formData['name']);

        if($request->hasFile('image')){
            $imagePath = $request->file('image')->store('mou_partnership_images','public');
            $formData['image'] = $imagePath;
        }

        Partner::create($formData);

        return redirect('/admin/partners');

    }

    public function edit($id)
    {
        $id = Partner::where('id',$id)->firstOrFail();
        return view('admin.partner.edit',[
            'partner' => $id,
        ]);
    }

    public function uploadImage(Request $request)
    {
        if($request->hasfile('upload')){
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_'. time(). '.'.$extension;
            $request->file('upload')->move(public_path('partner'),$fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('partner/'.$fileName);
            $msg = 'Image successfully uploaded';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>"; 
            // return responce()->json(['fileName' => $filename, 'uploaded'=>1, 'url'=>$url]);
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }

    public function update(Request $request, $id)
    {
        $partner = Partner::where('id',$id)->firstOrFail();
        $formData = request()->validate([
            'name' => 'required',
            'web_address' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $formData['slug'] = Str::slug($formData['name']);

        if($request->hasFile('image')){
            $imagePath = $request->file('image')->store('mou_partnership_images','public');
            $formData['image'] = $imagePath;
        }else{
            $formData['image'] = $partner->image;
        }

        $partner->update($formData);

        return redirect('/admin/partners');
    }

    public function delete($id)
    {
        $partner = Partner::where('id',$id)->firstOrFail();

        $partner->delete();

        return redirect()->back();
    }
}