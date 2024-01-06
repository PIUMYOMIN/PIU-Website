<x-admin_layout>
    <div class="sb2-2-2">
        <ul>
            <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li class="active-bre"><a href="#"> Edit Team Member</a>
            </li>
            <li class="page-back"><a href="/admin/teams"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
            </li>
        </ul>
    </div>

    <!--== User Details ==-->
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp admin-form">
                    <div class="inn-title">
                        <h4>Edit Team Member</h4>
                        <p>Here you can edit your website basic details URL, Phone, Email, Address, User and password
                            and more</p>
                    </div>
                    <div class="tab-inn">
                        <form action="{{ route('admin.team.edit.form.submit',['team' => $team->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="input-field col s6">
                                    <input type="text" name="name" value="{{ $team->name }}" class="validate" required>
                                    <label class="">Name</label>
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="input-field col s6">
                                    <input name="email" value="{{ $team->email }}" />
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <input name="phone" value="{{ $team->phone }}" />
                                    @error('phone')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="input-field col s6">
                                    <input name="address" value="{{ $team->address }}" />
                                    @error('address')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <input type="text" name="country" value="{{ $team->country }}">
                                    <label class="">Country</label>
                                    @error('country')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="input-field col s6">
                                    <input type="text" name="city" value="{{ $team->city }}"/>
                                    <label class="" >City</label>
                                    @error('city')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <input type="text" name="link1" value="{{ $team->link1 }}" />
                                    <label class="">Social Link 1</label>
                                    @error('link1')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="input-field col s6">
                                    <input type="text" name="link2" value="{{ $team->link2 }}"/>
                                    <label class="">Social Link 2</label>
                                    @error('link2')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <textarea type="text" name="education" >{{ $team->education }}</textarea>
                                    <label class="">Education</label>
                                    @error('education')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="input-field col s6">
                                    <textarea name="experience">{{ $team->experience }}</textarea>
                                    <label class="">Experience</label>
                                    @error('experience')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <textarea name="carrier" class="validate">{{ $team->carrier }}</textarea>
                                    <label class="">Carrier</label>
                                    @error('carrier')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="input-field col s6">
                                    <textarea name="role" class="validate">{{ $team->role }}</textarea>
                                    <label class="">Role</label>
                                    @error('role')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <select name="department_id">
                                        @foreach ($departments as $department)
                                            <option {{ $department->id == old('category_id') ? 'selected' : '' }}
                                                value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="input-field col s6">
                                    <select name="position_id">
                                        @foreach ($positions as $position)
                                            <option {{ $position->id == old('category_id') ? 'selected' : '' }}
                                                value="{{ $position->id }}">{{ $position->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('position_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="file-field input-field col s12">
                                    <div class="btn admin-upload-btn">
                                        <span>File</span>
                                        <input type="file" name="profile">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" placeholder="Profile File">
                                    </div>
                                    <img
                                      src="{{ asset('storage/'.$team->profile) }}"
                                      class="img-fluid rounded-top"
                                      alt="" width="200"
                                    />
                                    @error('profile')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="waves-effect waves-light btn-large waves-input-wrapper"
                                        style=""><input type="submit" class="waves-button-input"></i>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin_layout>
