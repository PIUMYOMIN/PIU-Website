<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Blog;

class AdminBlogController extends Controller
{
    public function index()
    {
       return view('admin.blog.index',[
        'blogs' => Blog::latest()->get()
       ]);
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $formData = request()->validate([
            'title' => ['required',Rule::unique('blogs','title')],
            'description' => 'required',
        ]);

        if($request->hasFile('image')){
            $filePath = $request->file('image')->store('blogs','public');
            $formData['image'] = $filePath;
        };

        $formData['user_id'] = auth()->user()->id;

        Blog::create($formData);

        return redirect('/admin/blogs');
    }

    public function edit($id)
    {
        $blog = Blog::where('id',$id)->firstOrFail();
       return view('admin.blog.edit',[
        'blog' => $blog
       ]);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::where('id',$id)->firstOrFail();
       $formData = request()->validate([
            'title' => ['required',Rule::unique('blogs','title')->ignore($blog->id)],
            'description' => 'required',
        ]);

        if($request->hasFile('image')){
            $filePath = $request->file('image')->store('blogs','public');
            $formData['image'] = $filePath;
        };

        $blog->update($formData);

        return redirect('/admin/blogs');
    }

    public function destroy($id)
    {
        $blog = Blog::where('id',$id)->firstOrFail();
        $blog->delete();

        return back();
    }

    public function isActive(Request $request, Blog $blog)
    {
        $blog->update(['is_active' => !$blog->is_active]);

        return redirect()->back();
    }

    public function uploadImage(Request $request)
    {
        if($request->hasfile('upload')){
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_'. time(). '.'.$extension;
            $request->file('upload')->move(public_path('blogs'),$fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('blogs/'.$fileName);
            $msg = 'Image successfully uploaded';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>"; 
            // return responce()->json(['fileName' => $filename, 'uploaded'=>1, 'url'=>$url]);
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }
}