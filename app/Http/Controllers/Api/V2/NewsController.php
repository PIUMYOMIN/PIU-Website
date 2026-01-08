<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::all();
        return response()->json($news);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|unique:news|max:255',
            'slug' => 'required|max:255',
            'body' => 'required',
            'image' => 'nullable|image',
            'user_id' => 'required|exists:users,id',
        ]);

        $news = News::create($data);
        return response()->json($news, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $news = News::findOrFail($id);
        return response()->json($news);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $news = News::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|required|unique:news,title,' . $news->id . '|max:255',
            'slug' => 'sometimes|required|max:255',
            'body' => 'sometimes|required',
            'image' => 'nullable|image',
            'user_id' => 'sometimes|required|exists:users,id',
        ]);

        $news->update($data);
        return response()->json(['message' => 'News updated successfully', 'news' => $news]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}