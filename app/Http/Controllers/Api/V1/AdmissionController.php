<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Admission;
use App\Mail\NewAdmissionFormSubmitted;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Course;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data for both first and second forms
        $validatedData = $request->validate([
            // First form fields
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'phone' => 'required|string|max:11',
            'address' => 'required|string',
            'country' => 'required|string',
            'city' => 'required|string',
            'zipcode' => 'required|string',
            'course_id' => ['required', Rule::exists('courses', 'id')],
            'gender' => 'required|string',
            'dob' => 'required|date_format:Y-m-d',
            'national_id' => 'required',
            'marital_sts' => 'required',
            'alumni_sts' => 'required',
            'student_id' => 'nullable',
            'language_proficiency' => 'nullable|file|mimes:pdf,doc,docx',
            'profile' => 'nullable|file|mimes:jpg,jpeg,png',
            'personal_statement' => 'required|file|mimes:pdf,doc,docx',
            'education_certificate' => 'required|file|mimes:pdf,doc,docx',
            'other_document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
        ]);

        // Generate a verification token
        $verificationToken = Str::random(40);

        // Store the language_proficiency file if "Yes" is selected
        if ($request->hasFile('language_proficiency')) {
            $filePath = $request->file('language_proficiency')->store('language_proficiency_docs', 'public');
            $validatedData['language_proficiency'] = $filePath;
        }

        // Store the personal_statement file if "Yes" is selected
        if ($request->hasFile('personal_statement')) {
            $filePath = $request->file('personal_statement')->store('personal_statement_docs', 'public');
            $validatedData['personal_statement'] = $filePath;
        }

        // Store the other_document file if "Yes" is selected
        if ($request->hasFile('other_document')) {
            $filePath = $request->file('other_document')->store('other_document_docs', 'public');
            $validatedData['other_document'] = $filePath;
        }

        // Save the admission data
        $admission = Admission::create($validatedData);

        // Send notification email to admin
        $adminEmail = $this->getFacultyEmail($request->input('course_id'));
        Mail::to($adminEmail)
            ->cc(['piu.webdeveloper@gmail.com', 'myatmonthu.aug@gmail.com', 'piuacademicaffairs@gmail.com', 'thantarhlaing.piu@gmail.com'])
            ->send(new NewAdmissionFormSubmitted($admission));

        return response()->json(['message' => 'Admission form submitted successfully', 'data' => $admission]);
    }

    protected function getFacultyEmail($courseId)
    {
        // Implement your logic to determine faculty email based on the $courseId
        // For example:
        switch ($courseId) {
            case 4:
                return 'myominthu819@gmail.com';
            case 7:
                return 'lwinmarkhaing27@gmail.com';
            case 8:
                return 'mgmyomin819g@gmail.com';
            case 9:
                return 'infinitylearn44g@gmail.com';
            default:
                return 'piu.webdeveloper@gmail.com';
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}