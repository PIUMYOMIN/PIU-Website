<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
// use App\Mail\NewAdmissionFormSubmitted;
use App\Models\Admission;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdmissionController extends Controller
{
    public function index()
    {
        $activeCourses = Course::where('is_active', true)->get();
        return view('admin.admissions.index', [
            'admissions' => Admission::latest()->get(),
            'courses' => $activeCourses,
        ]);
    }

    public function create(Course $courses)
    {
        return view('user.admission.create', [
            'courses' => Course::where('is_active', 1)->get(),
            'selected_course' => $courses,
        ]);
    }

    public function storeFirst(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:admissions,email|max:255',
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

    public function storeSecond(Request $request, Admission $admission)
    {
        $validatedData = $request->validate([
            'gender' => 'required|string',
            'dob' => 'required|date_format:Y-m-d',
            'national_id' => 'required',
            'marital_sts' => 'required',
            'alumni_sts' => 'required',
            'student_id' => 'nullable',
            'language_proficiency' => ($request->input('language_proficiency') === 'Yes') ? 'required|file|mimes:pdf,doc,docx' : 'nullable',

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
        if ($request->input('language_proficiency') === 'Yes') {
            if ($request->hasFile('language_proficiency')) {
                $formData['language_proficiency'] = $request->file('language_proficiency')->store('public/uploads');
            }
        } else {
            $formData['language_proficiency'] = null;
        }

        // Store the education_certificate file
        if ($request->hasFile('education_certificate')) {
            $formData['education_certificate'] = $request->file('education_certificate')->store('public/uploads');
        }

        // Store the profile file
        if ($request->hasFile('profile')) {
            $formData['profile'] = $request->file('profile')->store('public/uploads');
        }

        // Store the personal_statement file
        if ($request->hasFile('personal_statement')) {
            $formData['personal_statement'] = $request->file('personal_statement')->store('public/uploads');
        }

        // Store the other_document file if exists
        if ($request->hasFile('other_document')) {
            $formData['other_document'] = $request->file('other_document')->store('public/uploads');
        }

        $admission->fill(array_merge($validatedData, $formData));

        $verificationToken = Str::random(40);
        $admission->verification_token = $verificationToken;

        $admission->save();

        $courseId = $request->input('course_id');
        $adminEmail = '';

        // Determine the admin email based on the course id
        // if ($courseId == 9) {
        //     $adminEmail = 'oketama020@gmail.com';
        // } elseif ($courseId == 16) {
        //     $adminEmail = 'moet.khaing@gmail.com';
        // } elseif ($courseId == 3) {
        //     $adminEmail = 'ohmar.mme@gmail.com';
        // } elseif ($courseId == 4) {
        //     $adminEmail = 'wint.wtun@gmail.com';
        // } elseif ($courseId == 6) {
        //     $adminEmail = 'mayyimyint.pdopiu@gmail.com';
        // } elseif ($courseId == 10) {
        //     $adminEmail = 'intellay@gmail.com';
        // } elseif ($courseId == 17) {
        //     $adminEmail = 'wint.wtun@gmail.com';
        // } elseif ($courseId == 19) {
        //     $adminEmail = 'wint.wtun@gmail.com';
        // }

        // Send notification email to admin with CC
        // Mail::to($adminEmail)
        //     ->cc(['piu.webdeveloper@gmail.com', 'myatmonthu.aug@gmail.com', 'piuacademicaffairs@gmail.com'])
        //     ->send(new NewAdmissionFormSubmitted($admission));

        // Send email verification notification to user
        // $admission->sendEmailVerificationNotification();

        return redirect("/piu/admission/application-form-successfully-submited/{$verificationToken}")
            ->with('status', 'Your application has been submitted. Please check your email to verify your email address.');

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
