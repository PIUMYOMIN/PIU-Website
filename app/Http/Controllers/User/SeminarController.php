<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seminar;

class SeminarController extends Controller
{
    public function index()
    {
       return view('');
    }

    public function show($slug)
    {
        $seminar = Seminar::where('slug',$slug)->firstOrFail();
       return view('user.seminars.show',[
        'seminar' => $seminar
       ]);
    }
}