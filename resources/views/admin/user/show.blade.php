<x-admin_layout>
    <div class="sb2-2-2">
        <ul>
            <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li class="active-bre"><a href="#"> Add New Role</a>
            </li>
            <li class="page-back"><a href="index-2.html"><i class="fa fa-backward" aria-hidden="true"></i>
                    Back</a>
            </li>
        </ul>
    </div>

    <!--== User Details ==-->
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp admin-form">
                    <div class="inn-title">
                        <h4>User Permission Edit</h4>
                        <p>Here you can edit your website basic details URL, Phone, Email, Address, User and
                            password and more</p>
                    </div>
                    <div class="tab-inn">
                        <form action="" method="">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" name="name" value="" class="validate" disabled>
                                    <label class="">{{ $user->name }}</label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-inn">
                        <form action="{{ route('admin.users.roles', $user->id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="">
                                    <h3>Roles</h3>
                                    <select name="role" autocomplete="role-name">
                                        <option value="" disabled selected>Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('role')
                                    <span class="text-danger text-sm-center">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="input-field col s2">
                                    <button type="submit"
                                        class="waves-effect waves-button-input waves-light btn-large waves-input-wrapper"
                                        style="">
                                        Assign
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                                <h5>Assigned Roles</h5>
                                @foreach ($user->roles as $user_role)
                                    <form
                                        action="{{ route('admin.users.roles.removeRole', ['user' => $user->id, 'role' => $user_role->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <span class="ad-st-view"
                                            onclick="deleteRole(this)" style="cursor:pointer;">&times; {{ $user_role->name }}</span>
                                    </form>
                                @endforeach
                            </div>
                    </div>
                    <div class="tab-inn">
                        <form action="{{ route('admin.users.permissions', $user->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="">
                                    <h3>Permissions</h3>
                                    <select name="permission" autocomplete="role-name">
                                        <option value="" disabled selected>Select Permission</option>
                                        @foreach ($permissions as $permission)
                                            <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('permission')
                                    <span class="text-danger text-sm-center">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="input-field col s2">
                                    <button type="submit"
                                        class="waves-effect waves-button-input waves-light btn-large waves-input-wrapper"
                                        style="">
                                        Assign
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                                <h5>Assigned Permission</h5>
                                @foreach ($user->permissions as $user_permission)
                                    <form action="{{ route('admin.users.permissions.revokePermission',['user' => $user->id, 'permission' => $user_permission->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <span class="ad-st-view" onclick="deletePermission(this)" style="cursor:pointer;">&times; {{ $user_permission->name }}</span>
                                    </form>
                                @endforeach
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deleteRole(element) {
            if (confirm('Are you sure you want to remove role: ' + element.innerText + '?')) {
                element.parentElement.submit();
            }
        }
        function deletePermission(element) {
            if (confirm('Are you sure you want to remove Permission: ' + element.innerText + '?')) {
                element.parentElement.submit();
            }
        }
    </script>
</x-admin_layout>
