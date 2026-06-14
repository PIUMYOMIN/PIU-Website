<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CourseCommentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */


    public function build()
    {
        $senderEmail = data_get($this->data, 'email');
        $senderName = data_get($this->data, 'name', 'Course Comment');

        $message = $this
            ->subject('New Course Comment Received')
            ->view('emails.courseCommentMail')
            ->with([
                'data' => $this->data,
                'courseLink' => data_get($this->data, 'course_link'),
            ]);

        if ($senderEmail && filter_var($senderEmail, FILTER_VALIDATE_EMAIL)) {
            $message->replyTo($senderEmail, $senderName);
        }

        return $message;
    }
}