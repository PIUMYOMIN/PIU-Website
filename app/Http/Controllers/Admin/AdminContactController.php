<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\ContactFormMail;
use Mail;

class AdminContactController extends Controller
{
    public function index()
    {
       return view('admin.contact.index',[
        'contacts' => Contact::all(),
       ]);
    }
}