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
        try{
            // Validate the incoming request data for both first and second forms
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:admissions,email',
            'phone' => 'required|string|max:11',
            'address' => 'required|string',
            'country' => 'required|string',
            'city' => 'required|string',
            'zipcode' => 'required|string',
            'course_id' => 'required',
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

        // Log the validated data
        Log::info('Validated data:', $validatedData);

        // Save the admission data
        $admission = Admission::create($validatedData);

        if ($request->hasFile('language_proficiency')) {
            $filePath = $request->file('language_proficiency')->store('admission_forms_docs', 'public');
            $validatedData['language_proficiency'] = $filePath;
        }

        if ($request->hasFile('education_certificate')) {
            $filePath = $request->file('education_certificate')->store('admission_forms_docs', 'public');
            $validatedData['education_certificate'] = $filePath;
        }

        if ($request->hasFile('profile')) {
            $filePath = $request->file('profile')->store('admission_forms_docs', 'public');
            $validatedData['profile'] = $filePath;
        }

        if ($request->hasFile('personal_statement')) {
            $filePath = $request->file('personal_statement')->store('admission_forms_docs', 'public');
            $validatedData['personal_statement'] = $filePath;
        }

        if ($request->hasFile('other_document')) {
            $filePath = $request->file('other_document')->store('admission_forms_docs', 'public');
            $validatedData['other_document'] = $filePath;
        }

        // Send notification email to admin
        $adminEmail = $this->getFacultyEmail($request->input('course_id'));
        Mail::to($adminEmail)
            ->cc(['piu.webdeveloper@gmail.com', 'myatmonthu.aug@gmail.com', 'piuacademicaffairs@gmail.com', 'thantarhlaing.piu@gmail.com'])
            ->send(new NewAdmissionFormSubmitted($admission));

        return response()->json(['status' => 200,'message' => 'Admission form submitted successfully', 'data' => $admission]);
        }catch(\Exception $e){
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    protected function getFacultyEmail($courseId)
    {
        switch ($courseId) {
            case 1:
                return 'thantarhlaing.piu@gmail.com';
            case 2:
                return 'thantarhlaing.piu@gmail.com';
            case 3:
                return 'intellay@gmail.com';
            case 4:
                return 'oketama020@gmail.com';
            case 5:
                return 'thantarhlaing.piu@gmail.com';
            case 6:
                return 'ohmar.mme@gmail.com';
            case 7:
                return 'mayyimyint.pdopiu@gmail.com';
            case 8:
                return 'thantarhlaing.piu@gmail.com';
            case 9:
                return 'moet.khaing@gmail.com';
            default:
                return 'piuacademicaffairs@gmail.com';
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