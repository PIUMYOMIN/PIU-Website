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
                                    <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
                                      @csrf
                                      @method('PATCH')
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="text" name="name" value="" class="validate" required>
                                                <label class="">{{ $permission->name }}</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <h5>Role Permissions</h5>
                                            @foreach ($permission->roles as $permission_role)
                                            <form 
                                            action="{{ route('admin.permissions.roles.revoke',[$permission->id,$permission_role->id]) }}"
                                            method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger text-lowercase">{{ $permission_role->name }}</button>
                                            </form>
                                            @endforeach
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s2">
                                                <button type="submit" class="waves-effect waves-button-input waves-light btn-large waves-input-wrapper" style="">
                                                    Update
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-inn">
                                    <form action="{{ route('admin.permissions.roles', $permission->id) }}" method="POST">
                                      @csrf
                                        <div class="row">
                                            <div class="">
                                                <select name="role" autocomplete="role-name">
                                                    @foreach ($roles as $role)
									                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                    @endforeach
									            </select>
                                            </div>
                                            @error('name')
                                                <span class="text-danger text-sm-center">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s2">
                                                <button type="submit" class="waves-effect waves-button-input waves-light btn-large waves-input-wrapper" style="">
                                                    Assign
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</x-admin_layout>
