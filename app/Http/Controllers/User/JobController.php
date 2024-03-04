<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        return view('user.job.index');
    }

    public function show()
    {
        return view('user.job.show');
    }
}