<?php

namespace App\Http\Controllers\Api\V1;

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
        $test = request()->all();
        return response()->json(['message' => 'Data accepted', 'data' => $test]);
        // Validation rules for admission fields
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'country' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'dob' => 'required|date_format:Y-m-d',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'zipcode' => 'required|string',
            'gender' => 'required|string',
            'national_id' => 'required',
            'marital_sts' => 'required',
            'alumni_sts' => 'required',
            'student_id' => 'nullable',
            'language_proficiency' => 'nullable|file|mimes:pdf,doc,docx',
            'personal_statement' => 'required|file|mimes:pdf,doc,docx',
            'education_certificate' => 'required|file|mimes:pdf,doc,docx',
            'other_document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            'course_id' => 'required',
        ]);

        $validatedData['verification_token'] = Str::random(40);

        return response()->json(['message' => 'Validation successful', 'data' => $validatedData]);

        // try {
        //     // Create a new admission
        //     $admission = Admission::create($validatedData);

        //     // Return a success response with the created admission
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