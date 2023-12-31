<x-admin_layout>
    <div class="sb2-2-2">
            <ul>
                <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                </li>
                <li class="active-bre"><a href="#"> Update Your Profile</a>
                </li>
                <li class="page-back"><a href="{{ route('admin.user.profile.edit', ['user' => auth()->user()->id]) }}"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
                </li>
            </ul>
        </div>

        <!--== User Details ==-->
        <div class="sb2-2-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-inn-sp admin-form">
                        <div class="inn-title">
                            <h4>User Information</h4>
                            <p>Here you can edit your website basic details URL, Phone, Email, Address, User and
                                password and more</p>
                        </div>
                        <div class="tab-inn">
                            <form action="{{ route('admin.user.edit.form.submit', $user->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input type="text" value="{{ $user->name }}" name="name"
                                            class="validate">
                                        @error('name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="input-field col s6">
                                        <input type="email" name="email" class="validate" value="{{ $user->email }}" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input type="number" value="{{ $user->phone }}" name="phone"
                                            class="validate">
                                        <label class="">Phone number</label>
                                        @error('phone')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="input-field col s6">
                                        <input type="text" class="validate" value="{{ $user->address }}"
                                            name="address">
                                        <label class="">Address</label>
                                        @error('address')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input type="text" value="{{ $user->city }}" name="city"
                                            class="validate">
                                        <label class="">City</label>
                                        @error('city')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="input-field col s6">
                                        <input type="text" value="{{ $user->country }}" name="country"
                                            class="validate">
                                        <label class="">Country</label>
                                        @error('country')
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
											<input class="file-path validate" type="text" placeholder="Profile Image">
										</div>
                                        <img src="{{ $user->picture }}" alt="{{ $user->picture }}" width="200">
									</div>
                                    @error('picture')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
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
