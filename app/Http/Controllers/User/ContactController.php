<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\ContactFormMail;
use Mail;

class ContactController extends Controller
{
    public function index()
    {
       return view('user.contact.index');
    }

    public function store()
    {
       $data = request()->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'country' => 'required',
        'message' => 'required',
        // 'g-recaptcha-response' => 'required|captcha',
       ]);

        Contact::Create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'country' => $data['country'],
            'message' => $data['message'],
        ]);

        Mail::to('piu.webdeveloper@gmail.com')->send(new ContactFormMail($data));

       return back()->with('message_sent', 'Your message has been sent successfully. Thank you for contacting us.');
    }
}