<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
       return view('admin.roles.index',[
        'roles' => Role::all()
       ]);
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
       $validator = Validator::make($request->all(),[
        'name' => 'required|unique:roles,name'
       ]);

       if($validator->fails()){
        return back()->with('toast_error',$validator->messate()->all()[0])->withInput();
       }

       Role::create([
        'name'=> $request->name
       ]);

       return redirect()->route('admin.roles.index')->with('toast_success', 'Permission created successfully.');
    }

    public function edit(Role $role)
    {
       return view('admin.roles.edit',[
        'role' => $role,
        'permissions' => Permission::all()
       ]);
    }

    public function update(Role $role)
    {
        $formData = request()->validate([
            'name' => 'required',
        ]);

        $role->update($formData);
        return redirect('/admin/roles');
    }

    public function givePermission(Request $request, Role $role)
    {
        if($role->hasPermissionTo($request->permission)){
            return back()->with('message', 'Permission already exist.');
        }

        $role->givePermissionTo($request->permission);
        return back()->with('message', 'Permission added.');
    }

    public function revokePermission(Role $role, Permission $permission)
    {
        if($role->hasPermissionTo($permission)){
            $role->revokePermissionTo($permission);
            return back()->with('message', 'Permission revoked.');
        }

        return back()->with('message', 'Permission not exists.');
    }

}