<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    private function normalizeRoleName(?string $role): ?string
    {
        if (!$role) return null;
        $normalized = strtolower(trim($role));
        if ($normalized === 'faculty') return 'teacher';
        return $normalized;
    }

    private function resolveRoleForSync(string $role): Role
    {
        $normalized = $this->normalizeRoleName($role) ?? 'user';

        $existing = Role::query()
            ->whereRaw('LOWER(name) = ?', [$normalized])
            ->first();

        if ($existing) {
            // Keep role naming consistent going forward.
            if ($existing->name !== $normalized) {
                $existing->name = $normalized;
                $existing->save();
            }
            return $existing;
        }

        return Role::firstOrCreate(['name' => $normalized]);
    }

    public function index()
    {
        $users = User::with('roles')->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'nullable|string|in:admin,student,teacher,faculty,user,registrar',
        ]);

        $password = $data['password'] ?? 'password';
        $data['password'] = Hash::make($password);

        $role = $this->normalizeRoleName($data['role'] ?? 'user');
        unset($data['role']);

        $user = User::create($data);
        $user->syncRoles([$this->resolveRoleForSync($role)->name]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'user' => $this->formatUserData($user->fresh()->load('roles')),
        ], 201);
    }

    public function profile(Request $request)
    {
        $user = $request->user()->load('roles');

        return response()->json([
            'success' => true,
            'user' => $this->formatUserData($user),
        ]);
    }

    public function show(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        return response()->json($user);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'phone' => 'sometimes|nullable|string|max:20',
            'address' => 'sometimes|nullable|string|max:255',
            'city' => 'sometimes|nullable|string|max:100',
            'country' => 'sometimes|nullable|string|max:100',
            'bio' => 'sometimes|nullable|string|max:500',
            'profile_image' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $data['profile_image'] = $imagePath;
        }

        if (!$request->hasFile('profile_image')) {
            unset($data['profile_image']);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'user' => $this->formatUserData($user->fresh()->load('roles')),
        ]);
    }

    public function changePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect',
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully',
        ]);
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'phone' => 'sometimes|nullable|string|max:20',
            'address' => 'sometimes|nullable|string|max:255',
            'city' => 'sometimes|nullable|string|max:100',
            'country' => 'sometimes|nullable|string|max:100',
            'password' => 'sometimes|nullable|string|min:6|confirmed',
            'role' => 'sometimes|string|in:admin,student,teacher,faculty,user,registrar',
            'profile_image' => 'sometimes|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $roleToSync = isset($data['role']) ? $this->normalizeRoleName($data['role']) : null;
        unset($data['role']);

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $data['profile_image'] = $imagePath;
        }

        if (!$request->hasFile('profile_image')) {
            unset($data['profile_image']);
        }

        $user->update($data);

        if ($roleToSync) {
            $user->syncRoles([$this->resolveRoleForSync($roleToSync)->name]);
        }

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'user' => $this->formatUserData($user->fresh()->load('roles')),
        ]);
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
        ]);
    }

    /**
     * Audit users with missing or invalid roles.
     */
    public function auditRoles()
    {
        $validRoles = ['admin', 'teacher', 'registrar', 'user', 'student', 'faculty'];
        $users = User::with('roles')->get();

        $missing = [];
        $invalid = [];
        $okCount = 0;

        foreach ($users as $user) {
            $roles = $user->getRoleNames()->values();

            if ($roles->isEmpty()) {
                $missing[] = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ];
                continue;
            }

            $bad = $roles->filter(function ($r) use ($validRoles) {
                return !in_array((string) $r, $validRoles, true);
            })->values();

            if ($bad->isNotEmpty()) {
                $invalid[] = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $roles,
                    'invalid_roles' => $bad,
                ];
            } else {
                $okCount++;
            }
        }

        return response()->json([
            'success' => true,
            'summary' => [
                'total_users' => $users->count(),
                'ok_users' => $okCount,
                'missing_role_users' => count($missing),
                'invalid_role_users' => count($invalid),
            ],
            'missing_role_users' => $missing,
            'invalid_role_users' => $invalid,
            'valid_roles' => $validRoles,
        ]);
    }

    /**
     * Assign default role to users that currently have no role.
     */
    public function assignMissingRoles(Request $request)
    {
        $data = $request->validate([
            'default_role' => 'nullable|string|in:admin,teacher,faculty,registrar,user,student',
        ]);

        $defaultRole = $this->normalizeRoleName($data['default_role'] ?? 'user');
        $role = $this->resolveRoleForSync($defaultRole);

        $users = User::with('roles')->get();
        $updated = [];

        foreach ($users as $user) {
            if ($user->getRoleNames()->isEmpty()) {
                $user->assignRole($role);
                $updated[] = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'assigned_role' => $defaultRole,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Missing roles assigned successfully',
            'default_role' => $defaultRole,
            'updated_count' => count($updated),
            'updated_users' => $updated,
        ]);
    }

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

