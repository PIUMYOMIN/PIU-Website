<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admission;

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

            // Send email to faculty
            $adminEmail = $this->getFacultyEmail($validatedData['course_id']);

            Mail::to($adminEmail)
                ->cc([
                    'piu.webdeveloper@gmail.com',
                    'myatmonthu.aug@gmail.com',
                    'piuacademicaffairs@gmail.com',
                    'thantarhlaing.piu@gmail.com'
                ])
                ->send(new NewAdmissionFormSubmitted($admission));

            return response()->json([
                'success' => true,
                'message' => 'Admission form submitted successfully',
                'data' => $admission
            ], 201);

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

    /**
     * Faculty email mapping by course
     */
    protected function getFacultyEmail(int $courseId): string
    {
        return match ($courseId) {
            1, 2, 5, 8 => 'thantarhlaing.piu@gmail.com',
            3 => 'intellay@gmail.com',
            4 => 'oketama020@gmail.com',
            6 => 'ohmar.mme@gmail.com',
            7 => 'mayyimyint.pdopiu@gmail.com',
            9 => 'moet.khaing@gmail.com',
            default => 'piuacademicaffairs@gmail.com',
        };
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