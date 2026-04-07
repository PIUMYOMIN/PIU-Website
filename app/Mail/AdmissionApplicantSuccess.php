<?php

namespace App\Mail;

use App\Models\Admission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdmissionApplicantSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public Admission $admission;
    public ?string $courseTitle;

    public function __construct(Admission $admission, ?string $courseTitle = null)
    {
        $this->admission = $admission;
        $this->courseTitle = $courseTitle;
    }

    public function build()
    {
        return $this->view('emails.admission.applicant_success')
            ->subject('Your admission application was received')
            ->from(config('mail.from.address'), config('mail.from.name'));
    }
}

