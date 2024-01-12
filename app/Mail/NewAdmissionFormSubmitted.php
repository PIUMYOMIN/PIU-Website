<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewAdmissionFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $formData;

    /**
     * Create a new message instance.
     */
    public function __construct($formData)
    {
        $this->formData = $formData;

    }

    public function build()
    {
        $url = route('admin.admission.forms');

        return $this->view('user.admission.newAdmissionFormSubmit', compact('url'))
            ->subject('New Admission Form Received')
            ->from(config('mail.from.address'), config('mail.from.name'));

    }
}
