<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventRegister;

class AdminEventRegisterController extends Controller
{

    public function index()
    {
       return view('admin.event_enquiry.index',[
        'enquiries' => EventRegister::all(),
       ]);
    }

    public function store()
    {
       $data = request()->validate([
        'name' => 'required',
        'email' => 'required',
        'phone' => 'required',
        'city' => 'required',
        'country' => 'required',
        'event_id' => 'required',
       ]);

       EventRegister::create($data);

       return redirect('/events')->with('success','Your event registeration is successfully registered');
    }
}