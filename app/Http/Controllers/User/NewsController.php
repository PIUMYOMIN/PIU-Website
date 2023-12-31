<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
       return view('user.news.index',[
        'news' => News::all(),
       ]);
    }

    public function show($slug)
    {
        $new = News::where('slug', $slug)->firstOrFail();
        return view('user.news.show',[
            'new' => $new,
        ]);
    }
}