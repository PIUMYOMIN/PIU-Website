<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CourseCommentMail;
use Illuminate\Http\Request;
use App\Models\CourseComment;
use Mail;

class AdminCourseCommentController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
            'course_id' => 'required',
            'course_link' => 'required|url',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        $data['user_id'] = auth()->user()->id;

        Mail::to('piu.webdeveloper@gmail.com')->send(new CourseCommentMail($data));

        //  CourseComment::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'course_id' => $data['course_id'],
        //     'message' => $data['message'],
        //     'user_id' => auth()->user()->id // Assuming user is logged in
        // ]);

        CourseComment::createComment($data);

        return redirect()->back()->with('message','Your comment is successfully sent. Thank you for your comment.');
    }

    public function update()
    {
       dd('hit');
    }
}