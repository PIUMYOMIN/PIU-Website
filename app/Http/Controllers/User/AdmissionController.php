<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\NewAdmissionFormSubmitted;

use App\Models\Admission;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Mail;


class AdmissionController extends Controller
{
    public function create(Course $courses)
    {
        return view('user.admission.create', [
            'courses' => Course::where('application_sts', true)->get(),
            'selected_course' => $courses,
        ]);
    }

    public function storeFirst(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'phone' => 'required|string|max:11',
            'address' => 'required|string',
            'country' => 'required|string',
            'city' => 'required|string',
            'zipcode' => 'required|string',
            'course_id' => ['required', Rule::exists('courses', 'id')],
            // Add more validation rules here
        ]);

        // Store the validated data in the session
        $request->session()->put('piu.application.first-form', $validatedData);

        // Redirect to the second page with the validated data
        return redirect('/piu/application/second-form')->with('validatedData', $validatedData);
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

    public function storeSecond(Request $request, Admission $admission)
    {
        $validatedData = $request->validate([
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

        // Retrieve the form data from the request
        $formData = $request->only([
            'name',
            'email',
            'phone',
            'address',
            'country',
            'city',
            'zipcode',
            'course_id',
        ]);

        // Generate a verification token
        $formData['verification_token'] = Str::random(40);

        // Store the language_proficiency file if "Yes" is selected
        if ($request->hasFile('language_proficiency')) {
            $formData['language_proficiency'] = request->file('language_proficiency')->store('admission_forms_docs','public');
        }

        // Store the education_certificate file
        if ($request->hasFile('education_certificate')) {
            $formData['education_certificate'] = $request->file('education_certificate')->store('admission_forms_docs', 'public');
        }

        // Store the profile file
        if ($request->hasFile('profile')) {
            $formData['profile'] = $request->file('profile')->store('admission_forms_docs', 'public');
        }

        // Store the personal_statement file
        if ($request->hasFile('personal_statement')) {
            $formData['personal_statement'] = $request->file('personal_statement')->store('admission_forms_docs', 'public');
        }

        // Store the other_document file if exists
        if ($request->hasFile('other_document')) {
            $formData['other_document'] = $request->file('other_document')->store('admission_forms_docs', 'public');
        }

        $admission->fill(array_merge($validatedData, $formData));

        dd($admission);

        $verificationToken = Str::random(40);
        $admission->verification_token = $verificationToken;

        $admission->save();

        $courseId = $request->input('course_id');
        $adminEmail = '';

    switch ($courseId) {
        case 1:
            $adminEmail = 'thantarhlaing.piu@gmail.com';
            break;
        case 2:
            $adminEmail = 'thantarhlaing.piu@gmail.com';
            break;
        case 3:
            $adminEmail = 'intellay@gmail.com';
            break;
        case 4:
            $adminEmail = 'oketama020@gmail.com';
            break;
        case 5:
            $adminEmail = 'thantarhlaing.piu@gmail.com';
            break;
        case 6:
            $adminEmail = 'ohmar.mme@gmail.com';
            break;
        case 7:
            $adminEmail = 'mayyimyint.pdopiu@gmail.com';
            break;
        case 8:
            $adminEmail = 'thantarhlaing.piu@gmail.com';
            break;
        case 9:
            $adminEmail = 'moet.khaing@gmail.com';
            break;
        default:
            $adminEmail = 'piuacademicaffairs@gmail.com';
    }


// Send notification email to admin with CC

    Mail::to($adminEmail)
        ->cc(['piu.webdeveloper@gmail.com', 'myatmonthu.aug@gmail.com', 'piuacademicaffairs@gmail.com','thantarhlaing.piu@gmail.com'])
        ->send(new NewAdmissionFormSubmitted($admission));

        return redirect("/piu/admission/application-form-successfully-submited/{$verificationToken}")
            ->with('status', 'Your application has been submitted. Your application form is in progress. We will contact you after considering your application.');

    }

    public function second(Course $courses)
    {
        $validatedData = session('piu.application.first-form');
        return view('user.admission.second', [
            'courses' => Course::all(),
            'validatedData' => $validatedData,
        ]);
    }

    public function show(Admission $admission)
    {
        return view('admin.admissions.show', [
            'admission' => $admission,
        ]);
    }

    public function login()
    {
        return view('admissions.login');
    }

    public function auth_login()
    {
        //validation
        $formData = request()->validate([
            'email' => ['required', 'email', 'max:255', Rule::exists('admissions', 'email')],
            'password' => ['required', 'min:8', 'max:255'],
        ], [
            'email.required' => 'We need your email address.',
            'password.min' => 'Password should be more than 8 characters.',
        ]);

        // dd($formData);

        //if user credentials correct -> redirect home
        if (auth()->attempt($formData)) {
            return redirect('/profiles/dashboard')->with('success', 'Welcome back');
        } else {
            //if user credentials fail -> redirect back to form with error
            return redirect()->back()->withErrors([
                'email' => 'User Credentials Wrong',
            ]);
        }
    }

    public function success($token)
    {
        $admission = Admission::where('verification_token', $token)->first();

        if (!$admission) {
            abort(404, 'Invalid token');
        }

        return view('user.admission.success', compact('admission'));
    }

    public function verify()
    {
        return view('admissions.verify');
    }

    public function destroy(Admission $admission)
    {
        $admission->delete();

        return back();
    }

    public function filterAdmissions(Request $request, $course_id)
    {
        $admissions = Admission::with('course')->where('course_id', $course_id)->get();

        // Modify the document URLs to include the full path to the storage directory
        foreach ($admissions as $admission) {
            if ($admission->education_certificate) {
                $admission->education_certificate = asset('storage/' . $admission->education_certificate);
            }
            if ($admission->personal_statement) {
                $admission->personal_statement = asset('storage/' . $admission->personal_statement);
            }
            if ($admission->other_document) {
                $admission->other_document = asset('storage/' . $admission->other_document);
            }
        }

        return response()->json($admissions);
    }
}