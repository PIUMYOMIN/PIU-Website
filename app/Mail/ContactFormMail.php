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

        return $this
            // Gmail/most SMTP providers require FROM to be the authenticated mailbox.
            // Use replyTo so admins can reply to the sender.
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->replyTo($email ?: config('mail.from.address'), $name)
            ->subject('Contact Form Message')
            ->view('emails.contact_mail')
            ->with('data', $this->data);
    }
}