<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMail;
use App\Models\Contact;
use App\Support\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ContactV1Controller extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'phone' => ['required', 'string', 'max:50'],
                'country' => ['required', 'string', 'max:255'],
                'message' => ['required', 'string'],
            ]);

            $contact = Contact::create($data);

            $mailStatus = [
                'sent' => false,
                'error' => null,
            ];

            try {
                $recipients = Mailer::contactRecipients();
                $pending = Mail::to($recipients['to']);

                if (!empty($recipients['cc'])) {
                    $pending->cc($recipients['cc']);
                }

                $pending->send(new ContactFormMail($contact));
                $mailStatus['sent'] = true;
            } catch (\Throwable $mailError) {
                \Log::warning('Contact mail failed (continuing): ' . $mailError->getMessage());
                $mailStatus['error'] = $mailError->getMessage();
            }

            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent successfully. Thank you for contacting us.',
                'mail' => $mailStatus,
            ], 200);
        } catch (ValidationException $ve) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $ve->errors(),
            ], 422);
        }
    }
}
