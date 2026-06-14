<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
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
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        $email = data_get($this->data, 'email');
        $name = data_get($this->data, 'name') ?: 'Contact Form';

        $message = $this
            ->subject('Contact Form Message')
            ->view('emails.contact_mail')
            ->with('data', $this->data);

        if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message->replyTo($email, $name);
        }

        return $message;
    }
}