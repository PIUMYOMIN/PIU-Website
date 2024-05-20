<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admission;
use App\Http\Controllers\Api\V1\Validator;

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
        $data = request('profile');
        return response()->json(['message' => 'Data Accepted', 'data' => $data]);
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'country' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'dob' => 'required|date_format:Y-m-d',
            'zipcode' => 'required|string',
            'gender' => 'required|string',
            'national_id' => 'required',
            'marital_sts' => 'required',
            'alumni_sts' => 'required',
            'student_id' => 'nullable',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'language_proficiency' => 'nullable|file|mimes:pdf,doc,docx',
            'personal_statement' => 'required|file|mimes:pdf,doc,docx',
            'education_certificate' => 'required|file|mimes:pdf,doc,docx',
            'other_document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            'course_id' => 'required',
        ]);

        // Generate a verification token
        $validatedData['verification_token'] = Str::random(40);

        // Process file uploads
        $profilePath = $request->file('profile') ? $request->file('profile')->store('uploads/profiles', 'public') : null;
        $languageProficiencyPath = $request->file('language_proficiency') ? $request->file('language_proficiency')->store('uploads/language_proficiency', 'public') : null;
        $personalStatementPath = $request->file('personal_statement')->store('uploads/personal_statements', 'public');
        $educationCertificatePath = $request->file('education_certificate')->store('uploads/education_certificates', 'public');
        $otherDocumentPath = $request->file('other_document') ? $request->file('other_document')->store('uploads/other_documents', 'public') : null;

        // Store file paths in the validated data
        $validatedData['profile'] = $profilePath;
        $validatedData['language_proficiency'] = $languageProficiencyPath;
        $validatedData['personal_statement'] = $personalStatementPath;
        $validatedData['education_certificate'] = $educationCertificatePath;
        $validatedData['other_document'] = $otherDocumentPath;

        return response()->json(['message' => 'Data Accepted', 'data' => $validatedData]);

        // try {
        //     // Create a new admission record
        //     $admission = Admission::create($validatedData);

        //     // Return a success response with the created admission data
        //     return response()->json(['message' => 'Admission created successfully', 'data' => $admission], 201);
        // } catch (\Exception $e) {
        //     // Return an error response if something went wrong
        //     return response()->json(['message' => 'Failed to create admission', 'error' => $e->getMessage()], 500);
        // }
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