<x-admin_layout>
    <div class="sb2-2-2">
            <ul>
                <li><a href="/"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                </li>
                <li class="active-bre"><a href="#"> Dashboard</a>
                </li>
                <li class="page-back"><a href="{{ route('admin.student.profile',['identifier' => $identifier]) }}"><i class="fa fa-backward" aria-hidden="true"></i> Back to Profile</a>
                </li>
            </ul>
        </div>

        <!--== User Details ==-->
        <div class="sb2-2-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-inn-sp admin-form">
                        <div class="inn-title">
                            <h4>Student Information Update</h4>
                            <p>Here you can edit student basic details name, Phone, Email, Address, course and
                                gpa and more</p>
                        </div>
                        <div class="tab-inn">
                            <form action="{{ route('admin.student.update', ['identifier' => $identifier]) }}"
                                method="POST" enctype="multipart/form-data">
                                @method('patch')
                                @csrf
                                <input type="hidden" name="user_id">
                                @if (auth()->check())
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="fname" type="text" name="fname"
                                                    value="{{ $student->fname }}" class="validate">
                                                <label for="fname" class="">First Name</label>
                                                @error('fname')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="lname" type="text" name="lname"
                                                    value="{{ $student->lname }}" class="validate">
                                                <label for="lname" class="">Last Name (Optional)</label>
                                                @error('lname')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                @elseif(auth()->guard('student')->check())
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="fname" type="text" name="fname"
                                                    value="{{ $student->fname }}" class="validate" disabled readonly>
                                                <label for="fname" class="">First Name</label>
                                                @error('fname')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="lname" type="text" name="lname"
                                                    value="{{ $student->lname }}" class="validate" disabled readonly>
                                                <label for="lname" class="">Last Name (Optional)</label>
                                                @error('lname')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                @endif
                                <div class="row">
                                    @if (auth()->check()) 
                                        <div class="input-field col s6">
                                            <input id="stuId" type="text" name="student_id"
                                                value="{{ $student->student_id }}" class="validate">
                                            <label for="stuId" class="">Student Id</label>
                                            @error('student_id')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @elseif(auth()->guard('student')->check())
                                        <div class="input-field col s6">
                                        <input id="stuId" type="text" name="student_id"
                                            value="{{ $student->student_id }}" class="validate" disabled>
                                        <label for="stuId" class="">Student Id</label>
                                        @error('student_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    @endif
                                    <div class="file-field input-field col s6">
                                        <input id="dob" type="date" name="dob" value="{{ $student->dob }}"
                                            class="validate">
                                        @error('dob')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                @if (auth()->check())
                                    @if(auth()->user()->isAdmin())
                                    <div class="row">
                                    <div class="input-field col s6">
                                        <select class="input-field col s12" name="year_id">
                                            <option value="" disabled selected>Select Academic Year</option>
                                            @foreach ($years as $year)
                                                <option
                                                    {{ $year->id == old('year_id', $student->year->id) ? 'selected' : '' }}
                                                    value="{{ $year->id }}">{{ $year->name }}
                                                </option>
                                                @error('year_id')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-field col s6">
                                        <select class="input-field col s12" name="course_id">
                                            <option value="" disabled selected>Study Program</option>
                                            @foreach ($courses as $course)
                                                <option
                                                    {{ $course->id == old('course_id', $student->course->id) ? 'selected' : '' }}
                                                    value="{{ $course->id }}">{{ $course->title }}
                                                </option>
                                                @error('course_id')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                                @endif
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="phone" type="number" name="phone"
                                            value="{{ $student->phone }}" class="validate" required>
                                        <label for="phone">Phone number</label>
                                        @error('phone')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="input-field col s6">
                                        <input type="email" name="email" id="email" class="validate" required
                                            value="{{ $student->email }}">
                                        <label for="email" class="">Email</label>
                                        @error('email')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="address" type="text" name="address"
                                            value="{{ $student->address }}" class="validate" required>
                                        <label for="address" class="">Address</label>
                                        @error('address')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="input-field col s6">
                                        <input type="text" name="permanent_address" id="address2"
                                            class="validate" value="{{ $student->permanent_address }}">
                                        <label for="address2" class="">Permanent Address (Optional)</label>
                                        @error('permanent_address')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="city" type="text" name="city"
                                            value="{{ $student->city }}" class="validate" required>
                                        <label for="city" class="">City</label>
                                        @error('city')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="input-field col s6">
                                        <input id="country" type="text" name="country"
                                            value="{{ $student->country }}" class="validate" required>
                                        <label for="country" class="">Country</label>
                                        @error('country')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <input id="id" type="text" name="national_id"
                                            value="{{ $student->national_id }}" class="validate">
                                        <label for="id" class="">National No (e.g. MDY(N)123456)</label>
                                        @error('national_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="input-field col s6">
                                        <input id="id" type="text" name="passport_id"
                                            value="{{ $student->passport_id }}" class="validate">
                                        <label for="id" class="">Passport No (Optional)</label>
                                        @error('passport_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <select name="gender_sts" id="">
                                            <option disabled value="">Gender Status</option>
                                            <option value="Male"
                                                {{ $student->gender_sts === 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female"
                                                {{ $student->gender_sts === 'Female' ? 'selected' : '' }}>Female
                                            </option>
                                            <option value="Other"
                                                {{ $student->gender_sts === 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('gender_sts')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="input-field col s6">
                                        <select name="marital_sts" id="">
                                            <option disabled value="">Marital Status</option>
                                            <option value="Single"
                                                {{ $student->marital_sts === 'Single' ? 'selected' : '' }}>Single
                                            </option>
                                            <option value="Married"
                                                {{ $student->marital_sts === 'Married' ? 'selected' : '' }}>Married
                                            </option>
                                            <option value="Divorce"
                                                {{ $student->marital_sts === 'Divorce' ? 'selected' : '' }}>Divorce
                                            </option>
                                            <option value="Other"
                                                {{ $student->marital_sts === 'Other' ? 'selected' : '' }}>Other
                                            </option>
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
                                        <img src="/storage/{{ $student->profile }}" alt="" width="200px"
                                            height="200px">
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
                                                placeholder="Education Certificate (Compulsory)">
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
