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
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        if(Request::is('api/*')){
            return new UserResource($users);
        }else{
            return view('admin.user.index',[
                'users' => User::all(),
                'roles' => Role::all()
            ]);
        }
    }

    public function register()
    {
        return view('admin.auth.register');
    }

    public function login()
    {
        return view('admin.auth.login');
    }

    public function store(Request $request)
{

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

    return redirect()->back()->with('success', 'Registration successful! Please Login');
}


    public function show(User $user)
    {
       return view('admin.user.show',[
        'user' => $user,
        'roles' => Role::all(),
        'permissions' => Permission::all(),
       ]);
    }

    public function editUserProfile(User $user)
    {
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

        $user = User::where('email', $identifier)->first();
        $student = Student::where('student_id', $identifier)->first();

        // dd($user,$student,$password);

        $credentials = [
            'student_id' => $identifier,
            'password' => $password,
        ];

        if ($user && Auth::attempt(['email' => $identifier, 'password' => $password])) {

            Auth::login($user);

            if ($user->hasRole('admin')) {
            return redirect('/admin')->with('success', 'Welcome back');
            } else {
            return redirect('/')->with('success', 'Welcome back');
            }

        } elseif ($student && Auth::guard('student')->attempt(['student_id' => $credentials, 'password' => $password])) {
            Auth::guard('student')->login($student);
            // dd('Student login successful');
            // return redirect()->route('admin.profile', ['student' => $student->student_id]);
            return redirect()->intended(route('admin.profile'));
        } else {
            return redirect('/login')->withErrors(['login' => 'Invalid login credentials.']);
        }


        // $validatedData = $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required',
        // ]);

        // $credentials = [
        //     'email' => $validatedData['email'],
        //     'password' => $validatedData['password'],
        // ];

        // if (Auth::attempt($credentials, $request->has('remember'))) {
        //     // Authentication passed
        //     return redirect()->back()->with('message','Login Successfully.');
        // }else{
        //     return redirect('/login')->withErrors(['email' => 'Invalid email or password.']);
        // }
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
        return view('admin.user.changePassword',[
            'user' => $user
        ]);
    }

    public function passwordUpdate(User $user)
    {
        $data = request()->validate([
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        // If the user is registered through social media, update the password directly
        if ($user->provider_id) {
            $user->password = Hash::make($data['new_password']);
            $user->save();

            return redirect()->route('admin.user.profile.edit', ['user' => $user->id])  ->with('success', 'Password updated successfully!');
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
        return redirect()->route('admin.user.profile.edit', ['user' => $user->id])->with('success', 'Password updated successfully!');
    }


    public function profile()
    {
        return view('admin.profile.index');
    }
}