<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Admission;

class NewAdmissionFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public Admission $admission;
    public ?string $courseTitle;
    public string $adminUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(Admission $admission, ?string $courseTitle = null, ?string $adminUrl = null)
    {
        $this->admission = $admission;
        $this->courseTitle = $courseTitle;
        $this->adminUrl = $adminUrl ?: rtrim(config('app.url'), '/') . '/piu/admin/admission';

    }

    public function build()
    {
        return $this->view('emails.admission.new_submission')
            ->subject('New Admission Application Received')
            ->from(config('mail.from.address'), config('mail.from.name'));

    }
}
