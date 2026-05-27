<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'phone' => 'nullable|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Assign default role 'user' if it exists, otherwise create it
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $user->assignRole($userRole);

        // Create token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $token,
            'user' => $this->formatUserData($user),
        ], 201);
    }

    /**
     * Login user and create token.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required_without:phone|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'] ?? null)
            ->with('roles')
            ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Login using Laravel's session
        \Auth::login($user);

        // Create Sanctum token for API
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User logged in successfully',
            'token' => $token,
            'user' => $this->formatUserData($user),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'User logged out successfully']);
    }

    /**
     * Login for student portal using email or student ID.
     */
    public function studentPortalLogin(Request $request)
    {
        $request->validate([
            'email_or_student_id' => 'required_without_all:email,student_id|string',
            'email' => 'nullable|string',
            'student_id' => 'nullable|string',
            'password' => 'required|string',
        ]);

        $identifier = trim((string) ($request->input('email_or_student_id')
            ?? $request->input('email')
            ?? $request->input('student_id')
            ?? ''));

        $student = Student::query()
            ->where('email', $identifier)
            ->orWhere('student_id', $identifier)
            ->first();

        if (!$student || !Hash::check((string) $request->input('password'), (string) $student->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = null;
        if (!empty($student->user_id)) {
            $linkedUser = User::find($student->user_id);
            if ($linkedUser) {
                $token = $linkedUser->createToken('student_portal_token')->plainTextToken;
            }
        }

        $fullName = trim((string) (($student->fname ?? '') . ' ' . ($student->lname ?? '')));

        return response()->json([
            'message' => 'Student logged in successfully',
            'token' => $token,
            'user' => [
                'id' => $student->id,
                'name' => $fullName !== '' ? $fullName : 'Student',
                'email' => $student->email,
                'phone' => $student->phone,
                'city' => $student->city,
                'country' => $student->country,
                'student_id' => $student->student_id,
                'program' => null,
                'department' => null,
                'year' => $student->year_id,
                'profile' => $student->profile ? asset('storage/' . $student->profile) : null,
                'role' => 'student',
                'roles' => ['student'],
                'created_at' => $student->created_at,
                'updated_at' => $student->updated_at,
            ],
        ], 200);
    }

    /**
     * Send a password reset link to the given email.
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => __($status),
            ], 200);
        }

        return response()->json([
            'message' => __($status),
        ], 422);
    }

    /**
     * Reset password using token.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'message' => __($status),
            ], 200);
        }

        return response()->json([
            'message' => __($status),
        ], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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

    /**
     * Format user data for API response.
     */
    private function formatUserData(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'city' => $user->city,
            'country' => $user->country,
            'bio' => $user->bio,
            'profile_image' => $user->profile_image ? asset('storage/' . $user->profile_image) : null,
            'role' => $user->role,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];
    }
}
