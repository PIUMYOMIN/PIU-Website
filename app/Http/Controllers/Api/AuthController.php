<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Support\StudentAuth;
use App\Models\User;
use App\Support\GoogleIdTokenVerifier;
use App\Support\ProfileImage;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
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
            'password' => 'required|string|min:8|confirmed',
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
            'account_type' => 'staff',
            'portal_area' => $user->portalArea(),
            'no_access_reason' => $user->noAccessReason(),
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

        // This is an API-only app (no routes/web.php, no session-backed
        // "web" middleware on these routes) — Sanctum's token auth is
        // the only auth mechanism in play. We intentionally do not call
        // Auth::login() here: it would create a server-side session
        // that nothing reads back, on top of the Sanctum token.
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User logged in successfully',
            'token' => $token,
            'account_type' => 'staff',
            'portal_area' => $user->portalArea(),
            'no_access_reason' => $user->noAccessReason(),
            'user' => $this->formatUserData($user),
        ]);
    }

    /**
     * Login (or first-time signup) using "Sign in with Google".
     *
     * This is stateless by design: there is no routes/web.php and no
     * session middleware on the API group, so the browser-redirect
     * Socialite flow doesn't fit this app. Instead, the frontend uses
     * Google's own client-side SDK to obtain a signed Google ID token
     * and POSTs it here. We verify that token's signature, issuer,
     * audience, and expiry ourselves (see GoogleIdTokenVerifier) rather
     * than calling Socialite::userFromToken(), which Google's API
     * rejects for ID tokens (it expects an OAuth access token instead —
     * a well-documented Socialite/Google mismatch).
     */
    public function googleLogin(Request $request)
    {
        $request->validate([
            'id_token' => 'required|string',
        ]);

        try {
            $claims = GoogleIdTokenVerifier::verify($request->input('id_token'));
        } catch (\Throwable $e) {
            Log::warning('Google login token verification failed', [
                'message' => $e->getMessage(),
            ]);
            return response()->json(['message' => 'Invalid or expired Google token.'], 401);
        }

        $user = User::where('provider', 'google')
            ->where('provider_id', $claims['sub'])
            ->with('roles')
            ->first();

        if (!$user && $claims['email'] && $claims['email_verified']) {
            // Link to an existing password-based account only when
            // Google has confirmed it owns this email address — an
            // unverified email claim must never be allowed to take
            // over an existing account.
            $existing = User::where('email', $claims['email'])->with('roles')->first();
            if ($existing) {
                $existing->forceFill([
                    'provider' => 'google',
                    'provider_id' => $claims['sub'],
                ])->save();
                $user = $existing;
            }
        }

        if (!$user) {
            $user = User::create([
                'name' => $claims['name'] ?? 'Google User',
                'email' => $claims['email'],
                'password' => null,
                'picture' => $claims['picture'],
                'provider' => 'google',
                'provider_id' => $claims['sub'],
            ]);
            $userRole = Role::firstOrCreate(['name' => 'user']);
            $user->assignRole($userRole);
            $user->load('roles');
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User logged in successfully',
            'token' => $token,
            'account_type' => 'staff',
            'portal_area' => $user->portalArea(),
            'no_access_reason' => $user->noAccessReason(),
            'user' => $this->formatUserData($user),
        ]);
    }

    public function logout(Request $request)
    {
        $authed = $request->user();
        if ($authed && method_exists($authed, 'currentAccessToken') && $authed->currentAccessToken()) {
            $authed->currentAccessToken()->delete();
        }

        return response()->json(['message' => 'User logged out successfully']);
    }

    /**
     * Login for student portal using a student ID and password.
     * New accounts use a registrar-issued temporary password (see
     * StudentAuth::generateTemporaryPassword) and must change it on
     * first login — see must_change_password in the response.
     */
    public function studentPortalLogin(Request $request)
    {
        $credentials = $request->validate([
            'student_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $studentId = trim((string) $credentials['student_id']);

        $student = Student::query()
            ->where('student_id', $studentId)
            ->first();

        if (!$student || !StudentAuth::verifyPortalPassword($student, (string) $credentials['password'])) {
            return response()->json(['message' => 'Invalid student ID or password.'], 401);
        }

        if (!$student->is_active) {
            return response()->json([
                'message' => 'This account is inactive. Please contact the registrar.',
            ], 403);
        }

        $token = $student->createToken('student_portal_token')->plainTextToken;

        return response()->json([
            'message' => 'Student logged in successfully',
            'token' => $token,
            'account_type' => 'student',
            'must_change_password' => StudentAuth::mustChangePassword($student),
            'user' => StudentAuth::formatForApi($student),
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
            'password' => 'required|string|min:8|confirmed',
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
            'bio' => $user->bio ?? null,
            'picture' => ProfileImage::urlForUser($user),
            'profile_image' => ProfileImage::urlForUser($user),
            'role' => $user->role,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
            'account_type' => 'staff',
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];
    }
}
