<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\News;
use Illuminate\Validation\Rule;

class AdminNewsController extends Controller
{
    public function index()
    {
       return view('admin.news.index',[
        'news' => News::all(),
       ]);
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'title' => 'required|unique:news,title',
            'body' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:2048',
        ]);

        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news_images', 'public');
            $data['image'] = $imagePath;
        }

        $data['user_id'] = auth()->id();

        News::create($data);

        return redirect('/admin/news');
    }

    public function edit($id)
    {
        $new = News::where('id',$id)->firstOrFail();
        return view('admin.news.edit', [
            'new' => $new,
        ]);
    }

    public function update(Request $request, $id)
    {
        $new = News::where('id',$id)->firstOrFail();
        $data = request()->validate([
            'title' => ["required",Rule::unique('news','title')->ignore($new->id)],
            'body' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif|max:2048',
        ]);

        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news_images', 'public');
            $data['image'] = $imagePath;
        }

        $new->update($data);

        return redirect('/admin/news');
    }

    public function destroy($slug, User $user, Role $role)
    {
        if($user->hasRole('admin')){
            return back()->with('message', 'You are not an admin');
        }

        $news = News::where('slug', $slug)->firstOrFail();

        $news->delete();

        return redirect()->back();
    }
}