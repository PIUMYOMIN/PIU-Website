<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ContactV1Controller extends Controller
{
    protected function normalizeEmails(array $emails): array
    {
        $out = [];
        foreach ($emails as $email) {
            $email = trim((string) $email);
            if ($email === '') continue;
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) $out[] = $email;
        }
        return array_values(array_unique($out));
    }

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
                $adminRecipients = (array) config('admissions.admin_recipients', []);
                $alwaysCc = (array) config('admissions.cc_recipients', []);

                $to = $this->normalizeEmails(array_merge(
                    $adminRecipients,
                    ['piu.webdeveloper@gmail.com', (string) config('mail.from.address')]
                ));
                $cc = $this->normalizeEmails($alwaysCc);

                if (empty($to)) {
                    $fallback = config('mail.from.address');
                    if ($fallback) $to = [$fallback];
                }

                Mail::to($to)->cc($cc)->send(new ContactFormMail($contact));
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

