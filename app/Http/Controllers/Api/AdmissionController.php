<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\NewAdmissionFormSubmitted;
use App\Mail\AdmissionApplicantSuccess;
use App\Models\Course;
use Illuminate\Validation\ValidationException;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admissions = Admission::all();
        return response()->json($admissions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:admissions,email',
                'phone' => 'required|string|max:11',
                'address' => 'required|string',
                'country' => 'required|string',
                'city' => 'required|string',
                'zipcode' => 'required|string',
                'course_id' => 'required|integer',
                'gender' => 'required|string',
                'dob' => 'required|date_format:Y-m-d',
                'national_id' => 'required|string',
                'marital_sts' => 'required|string',
                'alumni_sts' => 'required|string',
                'student_id' => 'nullable|string',

                'language_proficiency' => 'nullable|file|mimes:pdf,doc,docx',
                'profile' => 'nullable|file|mimes:jpg,jpeg,png',
                'personal_statement' => 'required|file|mimes:pdf,doc,docx',
                'education_certificate' => 'required|file|mimes:pdf,doc,docx',
                'other_document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            ]);

            $validatedData['verification_token'] = Str::random(40);

            // Handle file uploads
            $fileFields = [
                'language_proficiency',
                'education_certificate',
                'profile',
                'personal_statement',
                'other_document'
            ];

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $validatedData[$field] = $request
                        ->file($field)
                        ->store('admission_forms_docs', 'public');
                }
            }

            $admission = Admission::create($validatedData);

            $mailStatus = [
                'admin_notified' => false,
                'applicant_confirmed' => false,
                'error' => null,
            ];

            try {
                $course = Course::find($validatedData['course_id']);
                $courseTitle = $course?->title;

                $adminUrl = rtrim(config('app.url'), '/') . '/piu/admin/admission';

                $adminRecipients = (array) config('admissions.admin_recipients', []);
                $alwaysCc = (array) config('admissions.cc_recipients', []);
                $programManager = $this->getProgramManagerEmail((int) $validatedData['course_id']);

                $to = $this->normalizeEmails($adminRecipients);
                $cc = $this->normalizeEmails(array_merge($alwaysCc, $programManager ? [$programManager] : []));

                if (!empty($to) || !empty($cc)) {
                    // If only CC is configured, fall back to sending TO the first CC address.
                    if (empty($to) && !empty($cc)) {
                        $to = [array_shift($cc)];
                    }

                    Mail::to($to)
                        ->cc($cc)
                        ->send(new NewAdmissionFormSubmitted($admission, $courseTitle, $adminUrl));
                    $mailStatus['admin_notified'] = true;
                }

                // Applicant success email
                if (!empty($admission->email)) {
                    Mail::to($admission->email)->send(new AdmissionApplicantSuccess($admission, $courseTitle));
                    $mailStatus['applicant_confirmed'] = true;
                }
            } catch (\Throwable $mailError) {
                Log::warning('Admission mail failed (continuing):', [
                    'message' => $mailError->getMessage(),
                ]);
                $mailStatus['error'] = $mailError->getMessage();
            }

            return response()->json([
                'success' => true,
                'message' => 'Admission form submitted successfully',
                'data' => $admission,
                'mail' => $mailStatus,
            ], 201);

        } catch (ValidationException $ve) {
            // Return proper 422 instead of masking as 500
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $ve->errors(),
            ], 422);
        } catch (\Throwable $e) {

            Log::error('Admission Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Admission submission failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    protected function normalizeEmails(array $emails): array
    {
        $out = [];
        foreach ($emails as $email) {
            $email = trim((string) $email);
            if ($email === '') continue;
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $out[] = $email;
            }
        }
        return array_values(array_unique($out));
    }

    /**
     * Program manager email mapping by course_id.
     */
    protected function getProgramManagerEmail(int $courseId): ?string
    {
        $map = (array) config('admissions.program_managers', []);
        $email = $map[$courseId] ?? null;

        if (!$email) {
            Log::warning('No program manager email configured for course_id', [
                'course_id' => $courseId,
            ]);
        }
        return $email ? (string) $email : null;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admission = Admission::findOrFail($id);
        return response()->json($admission);
    }

    /**
     * Update the specified admission (API).
     */
    public function update(Request $request, string $id)
    {
        try {
            $admission = Admission::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:admissions,email,' . $admission->id,
                'phone' => 'sometimes|required|string|max:11',
                'address' => 'sometimes|required|string',
                'country' => 'sometimes|required|string',
                'city' => 'sometimes|required|string',
                'zipcode' => 'sometimes|required|string',
                'course_id' => 'sometimes|required|integer',
                'gender' => 'sometimes|required|string',
                'dob' => 'sometimes|required|date_format:Y-m-d',
                'national_id' => 'sometimes|required|string',
                'marital_sts' => 'sometimes|required|string',
                'alumni_sts' => 'sometimes|required|string',
                'student_id' => 'nullable|string',

                'language_proficiency' => 'nullable|file|mimes:pdf,doc,docx',
                'profile' => 'nullable|file|mimes:jpg,jpeg,png',
                'personal_statement' => 'nullable|file|mimes:pdf,doc,docx',
                'education_certificate' => 'nullable|file|mimes:pdf,doc,docx',
                'other_document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            ]);

            // Handle file updates
            $fileFields = [
                'language_proficiency',
                'education_certificate',
                'profile',
                'personal_statement',
                'other_document'
            ];

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $validatedData[$field] = $request
                        ->file($field)
                        ->store('admission_forms_docs', 'public');
                }
            }

            $admission->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Admission updated successfully',
                'data' => $admission
            ], 200);

        } catch (\Throwable $e) {

            \Log::error('Admission Update Error:', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Admission update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

