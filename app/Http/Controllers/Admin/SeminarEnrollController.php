<?php

namespace App\Http\Controllers\Admin;
use App\Models\Seminar;
use App\Models\SeminarEnroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeminarEnrollController extends Controller
{

    public function index()
    {
       return view('admin.seminar_enquiry.index',[
        'enquiries' => SeminarEnroll::all(),
        'seminars' => Seminar::all()
       ]);
    }
    public function store()
    {
       $data = request()->validate([
        'name' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
        'city' => 'required',
        'country' => 'required',
        'seminar_id' => 'required',
       ]);

       SeminarEnroll::create($data);

       return redirect('/')->with('success', 'Your senimar enroll is successfully submited');
    }
}