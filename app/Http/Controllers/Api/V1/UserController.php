<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return response()->Json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|max:25|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Ensure to hash the password
        ]);

        $token = $user->createToken('auth_token')->accessToken;

        return response()->json(['token' => $token], 201);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
     public function show(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
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
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }

    public function apiLogin(Request $request)
{
    $input = $request->all();

    $validation = Validator::make($input, [
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if ($validation->fails()) {
        return response()->json(['error' => $validation->errors()], 422);
    }

    if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $token = $user->createToken('MyToken')->accessToken;

        return response()->json([
            'token' => $token,
            'email' => $user->email,
            'name' => $user->name,
            'phone' => $user->phone,
            'address' => $user->address,
            'city' => $user->city,
            'country' => $user->country,
            'picture' => $user->picture,
        ]);
    } else {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }
}

    public function userDetails()
    {
        $user = Auth::guard('api')->user();
        return response()->json(['user'=>$user]);
    }
}