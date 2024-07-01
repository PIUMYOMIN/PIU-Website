<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Contact;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'country'=> 'required',
            'message' => 'required',
            'reCapt' => 'required|captcha',
        ]);

        return response()->json($validator);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country'=> $request->country,
            'message' => $request->message
        ]);

        // Sending email
        Mail::to('piu.webdeveloper@gmail.com')->send(new ContactFormMail($data));

        return response()->json(['message' => 'Your message has been sent successfully. Thank you for contacting us.'], 200);
    }
}