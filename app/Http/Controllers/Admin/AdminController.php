<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class AdminController extends Controller
{
    public function index()
    {
       return view('admin.index',[
        'courses' => Course::latest()->get(),
       ]);
    }
}