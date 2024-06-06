<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Mail\ForgotPasswordMail;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();

        return view('admin.user.index', [
            'users' => $users,
            'roles' => Role::all()
        ]);
    }

    public function register()
    {
        return view('user.auth.register');
    }

    public function login()
    {
        return view('user.auth.login');
    }

    public function store(Request $request)
    {
        // dd(request()->all());
        $data = $request->validate([
            'name' => 'required',
            'email' => ['required','email',Rule::unique('users','email')],
            'phone' => 'nullable',
            'address' => 'nullable',
            'password' => 'required|min:8|max:25|confirmed',
            'picture' => 'image|mimes:jpg,jpeg,png',
            'provider_id' => 'nullable',
        ]);

        $request->validate([
            'g-recaptcha-response' => 'required|captcha',
        ]);

        $data['password'] = Hash::make($data['password']);


        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store('user_profiles', 'public');
            $data['picture'] = $imagePath;
        } else {
            $data['picture'] = 'img/picture.png';
        }

        $user = User::create($data);

        Auth::login($user);

        return redirect('/admin')->back()->with('success', 'Registration successful! Please Login');
    }


    public function show($id)
    {
        $user = User::where('id', $id)->firstOrFail();
       return view('admin.user.show',[
        'user' => $user,
        'roles' => Role::all(),
        'permissions' => Permission::all(),
       ]);
    }

    public function editUserProfile(User $user)
    {
        $authenticatedUser = auth()->user();

        if ($authenticatedUser->id !== $user->id) {
            return redirect()->back()->withErrors(['error' => 'You are not authorized to edit this profile.']);
        }

       return view('admin.user.edit',[
        'user' => $user
       ]);
    }

    public function update(Request $request, User $user)
    {
        // dd(request()->all());
        $data = $request->validate([
            'name' => 'nullable',
            'email' => ["nullable", Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => 'nullable',
            'address' => 'nullable',
            'city' => 'nullable',
            'country' => 'nullable',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store('user_profiles', 'public');
            $data['picture'] = $imagePath;
        } else {
            unset($data['picture']);
        }

        // dd($data);

        $user->update($data);

        return back()->with('success', 'User updated successfully');
    }

public function user_login(Request $request)
{
    $identifier = $request->input('identifier');
    $password = $request->input('password');

    // Check if the identifier is an email
    if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
        // Attempt to find a user with the provided email
        $user = User::where('email', $identifier)->first();

        if ($user && Auth::attempt(['email' => $identifier, 'password' => $password])) {
            Auth::login($user);

            // if ($user->hasRole('admin')) {
            //     return redirect('/admin')->with('success', 'Welcome back');
            // } elseif($user->hasRole('manager|faculty|registrar')) {
            //     return redirect()->route('admin.users.profile.edit',[$user->id])->with('success', 'Welcome back');
            // } else {
            //     return redirect('/')->with('success', 'Welcome back');
            // }

            if ($user->hasRole('admin')) {
                return redirect('/admin')->with('success', 'Welcome back');
            } elseif($user->hasRole('manager|faculty|registrar')) {
                return redirect()->route('admin.users.profile.edit',[$user->id])->with('success', 'Welcome back');
            } else {
                return redirect()->route('admin.users.profile.edit',[$user->id])->with('success', 'Welcome back');
            }
        }
    } else {
        // dd('hit');
        // Attempt to find a student with the provided student_id
        $student = Student::where('student_id', $identifier)->first();

        if ($student && Auth::guard('student')->attempt(['student_id' => $identifier, 'password' => $password])) {
            Auth::guard('student')->login($student);

            // Generate a random string
            $randomString = Str::random(15);

            // Concatenate student ID with random string
            $mixedIdentifier = $student->student_id . $randomString;
            // dd($mixedIdentifier);


            // Redirect with the mixed identifier appended to the route
            return redirect()->intended(route('admin.student.profile', ['identifier' => $mixedIdentifier]));
        }
    }

    // If neither user nor student login is successful, redirect back with an error
    return redirect('/login')->withErrors(['login' => 'Invalid login credentials.']);
}



    public function assignRole(Request $request, User $user)
    {
        if($user->hasRole($request->role)){
            return back()->with('message', 'Role exit.');
        }
        $user->assignRole($request->role);
        return back()->with('message', 'Role assigned.');
    }

    public function givePermission(Request $request, User $user)
    {
        if($user->hasPermissionTo($request->permission)){
            return back()->with('message', 'Permission already exit.');
        }
        $user->givePermissionTo($request->permission);
        return back()->with('message', 'Permission added.');
    }

    public function giveRole(Request $request, User $user)
    {
        if($user->hasRole($request->role)){
            return back()->with('message', 'Role exit.');
        }
        $user->assignRole($request->role);
        return back()->with('message', 'Role assigned.');
    }


    //user role remove
    public function removeRole(User $user, Role $role)
    {
        if($user->hasRole($role)){
            $user->removeRole($role);
            return back()->with('message', 'Role removed.');
        }

        return back()->with('message', 'Role not exists.');
    }

    //user permission remove
    public function revokePermission(User $user, Permission $permission)
{
    if ($user->hasPermissionTo($permission)) {
        $user->revokePermissionTo($permission);
        return back()->with('message', 'Permission revoked successfully.');
    }

    return back()->with('message', 'Permission not found or not assigned to the user.');
}


    //user delete
    public function destroy(User $user)
    {
        if($user->hasRole('admin')){
            return back()->with('message', 'You are an admin');
        }

        $user->delete();

        return back()->with('message', 'User deleted.');
    }


    //user logout
    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }

    public function studentLogout()
    {
        Auth::guard('student')->logout();
        return redirect('/');
    }

    // Google redirect link
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Google callback
    public function googleCallback(Request $request)
    {
        $user = Socialite::driver('google')->user();

        $exitingUser = User::where('email',$user->email)->first();

        if($exitingUser){
            auth()->login($exitingUser);
        }else{
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => null,
                'picture' => $user->avatar,
                'provider_id' => $user->id,
            ]);

            auth()->login($newUser);
        }

        return redirect('/')->with('success', 'Welcome ' . auth()->user()->name);
    }

    // facebook login redirect 
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    //facebook callback
    public function facebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (Exception $e) {
            return redirect('/')->with('error', 'Failed to authenticate with Facebook.');
        };

        $exitingUser = User::where('email', $user->email)->first();

        if($exitingUser){
            auth()->login($exitingUser);
        }else{
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email ?? null,
                'phone' => $user->phone ?? null,
                'password' => null,
                'picture' => $user->avatar,
                'provider_id' => $user->id,
            ]);

            auth()->login($newUser);
        }

        return redirect('/')->with('success', 'Welcome ' . auth()->user()->name);
    }


// twitter redirect

    public function redirectToTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    //twitter callback
    public function twitterCallback()
    {
        $user = Socialite::driver('twitter')->user();
        dd($user);
        try {
            $user = Socialite::driver('twitter')->user();
        } catch (Exception $e) {
            return redirect('/')->with('error', 'Failed to authenticate with Twitter.');
        };

        $exitingUser = User::where('email', $user->email)->first();

        if($exitingUser){
            auth()->login($exitingUser);
        }else{
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email ?? null,
                'phone' => $user->phone ?? null,
                'password' => null,
                'picture' => $user->avatar,
                'provider_id' => $user->id,
            ]);

            auth()->login($newUser);
        }

        return redirect('/')->with('success', 'Welcome ' . auth()->user()->name);
    }

    public function passwordChange(User $user)
    {
        if($user->id !== auth()->user()->id){
            abort(403);
        }

        return view('admin.user.changePassword',[
            'user' => $user
        ]);
    }

    public function passwordUpdate(User $user)
    {
        if($user->id !== auth()->user()->id){
            abort(403);
        }

        $data = request()->validate([
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        // If the user is registered through social media, update the password directly
        if ($user->provider_id) {
            $user->password = Hash::make($data['new_password']);
            $user->save();

            return redirect()->route('admin.users.profile.edit', ['user' => $user->id])  ->with('success', 'Password updated successfully!');
        }

        // For users with a traditional password, check the old password
        $oldPassword = request('old_password');
        if (!Hash::check($oldPassword, $user->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }

        // Update the user's password
        $user->password = Hash::make($data['new_password']);
        $user->save();

        // Redirect the user with a success message
        return redirect()->route('admin.users.profile.edit', ['user' => $user->id])->with('success', 'Password updated successfully!');
    }


    public function profile()
    {
        return view('admin.profile.index');
    }

    public function forget_password()
    {
        return view('user.auth.forget_password');
    }

    public function forget_password_form(Request $request)
    {
        $email = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $email['email'])->first();

        if ($user) {
            $token = Str::random(60);
            $user->update(['remember_token' => $token]);
            Mail::to($user->email)->send(new ForgotPasswordMail($user, $token));
            return redirect('auth/passwords/password_reset_link_sent')->with('status', 'We have e-mailed your password reset link!');
        }else{
            return redirect()->route('forget-password')->with('message','Email is not registered.');
        }

        return redirect()->back()->withErrors(['email' => 'We could not find a user with that email address.']);
    }

    public function password_reset_link_successfull_sent()
    {
        return view('user.auth.password_reset_link_sent');
    }

    public function showResetPasswordForm($token)
    {
        $user = User::where('remember_token', $token)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Invalid password reset token');
        }

        return view('user.auth.reset_password')->with(['token' => $token, 'email' => $user->email]);
    }

    public function forgotPasswordUpdate()
    {
        $formData = request()->validate([
            'token' => 'required',
            'password' => 'required|max:255|min:8',
            'password_confirmation' => ['required', 'same:password'],
        ]);

        $user = User::where('remember_token', $formData['token'])->firstOrFail();

        $user->password = bcrypt($formData['password']);
        $user->remember_token = null;
        $user->save();

        return redirect('/login')->with('success', 'Welcome' . $user->name);
    }

     public function checkUserRole()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user has the 'admin' role
        if ($user->hasRole('admin')) {
            $roleName = "Admin";
        } elseif($user->hasRole('Registrar')) {
            $roleName = "Registrar";
        }else{
            $roleName = "User";
        }
        return $roleName;
    }
}