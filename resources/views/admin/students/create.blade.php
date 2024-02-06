<x-admin_layout>
    <div class="sb2-2-2">
            <ul>
                <li><a href="/"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                </li>
                <li class="active-bre"><a href="#"> Dashboard</a>
                </li>
                <li class="page-back"><a href="/admin"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
                </li>
            </ul>
        </div>

        <!--== User Details ==-->
        <div class="sb2-2-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-inn-sp admin-form">
                        <div class="inn-title">
                            <h4>Website Setting</h4>
                            <p>Here you can edit student basic details name, Phone, Email, Address, course and
                                gpa and more</p>
                        </div>
                        <div class="tab-inn">
                            <form action="{{ route('admin.student.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id">
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="fname" type="text" name="fname" value="{{ old('fname') }}"
                                            class="validate" required>
                                        <label for="fname" class="">First Name</label>
                                        @error('fname')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="input-field col s6">
                                        <input id="lname" type="text" name="lname" value="{{ old('lname') }}"
                                            class="validate">
                                        <label for="lname" class="">Last Name (Optional)</label>
                                        @error('lname')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="stuId" type="text" name="student_id"
                                            value="{{ old('student_id') }}" class="validate" required>
                                        <label for="stuId" class="">Student Id</label>
                                        @error('student_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="file-field input-field col s6">
                                        <input id="dob" type="date" name="dob" value="{{ old('dob') }}"
                                            class="validate">
                                        @error('dob')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <select class="input-field col s12" name="year_id" required>
                                            <option value="" disabled selected>Select Academic Year</option>
                                            @foreach ($years as $year)
                                                <option {{ $year->id == old('year_id') ? 'selected' : '' }}
                                                    value="{{ $year->id }}">{{ $year->name }}
                                                </option>
                                                @error('year_id')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-field col s6">
                                        <select class="input-field col s12" name="course_id" required>
                                            <option value="" disabled selected>Study Program</option>
                                            @foreach ($courses as $course)
                                                <option {{ $course->id == old('course_id') ? 'selected' : '' }}
                                                    value="{{ $course->id }}">{{ $course->title }}
                                                </option>
                                                @error('course_id')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="phone" type="number" name="phone" value="{{ old('phone') }}"
                                            class="validate" required>
                                        <label for="phone">Phone number</label>
                                        @error('phone')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="input-field col s6">
                                        <input type="email" name="email" id="email" class="validate"
                                            value="{{ old('email') }}" required>
                                        <label for="email" class="">Email</label>
                                        @error('email')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="address" type="text" name="address"
                                            value="{{ old('address') }}" class="validate" required>
                                        <label for="address" class="">Address</label>
                                        @error('address')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="input-field col s6">
                                        <input type="text" name="permanent_address" id="address2"
                                            class="validate" value="{{ old('permanent_address') }}">
                                        <label for="address2" class="">Permanent Address (Optional)</label>
                                        @error('permanent_address')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="city" type="text" name="city"
                                            value="{{ old('city') }}" class="validate" required>
                                        <label for="city" class="">City</label>
                                        @error('city')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="input-field col s6">
                                        <input id="country" type="text" name="country"
                                            value="{{ old('country') }}" class="validate" required>
                                        <label for="country" class="">Country</label>
                                        @error('country')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="id" type="text" name="national_id"
                                            value="{{ old('national_id') }}" class="validate" required>
                                        <label for="id" class="">National No (e.g. MDY(N)123456)</label>
                                        @error('national_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="input-field col s6">
                                        <input id="id" type="text" name="passport_id"
                                            value="{{ old('passport_id') }}" class="validate">
                                        <label for="id" class="">Passport No (Optional)</label>
                                        @error('passport_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <select name="gender_sts" id="" required>
                                            <option disabled selected value="{{ old('gender_sts') }}">Gender Status
                                            </option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        @error('gender_sts')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="input-field col s6">
                                        <select name="marital_sts" id="" required>
                                            <option disabled selected value="{{ old('marital_sts') }}">Marital Status
                                            </option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Divorce">Divorce</option>
                                            <option value="Divorce">Other</option>
                                        </select>
                                        @error('marital_sts')
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
                                            <input class="file-path validate" type="text"
                                                value="{{ old('profile') }}"
                                                placeholder="Student Profile (Optional)">
                                        </div>
                                        @error('profile')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="file-field input-field col s12">
                                        <div class="btn admin-upload-btn">
                                            <span>File</span>
                                            <input type="file" name="education_certificate">
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text"
                                                value="{{ old('education_certificate') }}"
                                                placeholder="Education Certificate (Opitional)">
                                        </div>
                                        @error('education_certificate')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="file-field input-field col s12">
                                        <div class="btn admin-upload-btn">
                                            <span>File</span>
                                            <input type="file" name="other_documents">
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text"
                                                value="{{ old('other_documents') }}"
                                                placeholder="Other Documents (Optional)">
                                        </div>
                                        @error('other_documents')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <i class="waves-effect waves-light btn-large waves-input-wrapper"><input
                                                type="submit" class="waves-button-input"></i>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-admin_layout>
