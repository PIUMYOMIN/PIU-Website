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
        $news = News::where('slug', $slug)->firstOrFail();
        $dateParts = explode('-', $news->created_at);
        $timeParts = explode(':', $news->updated_at);
        $day = $dateParts[1];
        $month = date('M', mktime(0, 0, 0, $dateParts[1], 1));
        $year = $dateParts[0];
        $hour = $timeParts[0];
        $minute = $timeParts[1];
        return view('user.news.show',[
            'news' => $news,
            'day' => $day,
            'month' => $month,
            'year' => $year,
            'hour' => $hour,
            'minute' => $minute,
        ]);
    }
}