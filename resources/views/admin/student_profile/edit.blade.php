<x-layout>
    <!--SECTION START-->
    <section>
        <div class="pro-cover">
        </div>
        <x-profile-menu-tab :student="$student" />
        <div class="stu-db">
            <div class="container pg-inn">
                <x-user-profile />
                <div class="col-md-9">
                    <div class="udb">
                        <div class="udb-sec udb-prof">
                            <h4><img src="images/icon/db1.png" alt="" /> My Profile</h4>
                            <div class="sdb-tabl-com sdb-pro-table">
                                <table class="responsive-table bordered">
                                    <tbody>
                                        <form action="/admin/students/profile/{{ $student->id }}/update" method="POST"
                                            enctype="multipart/form-data">
                                            @method('patch')
                                            @csrf
                                            <tr>
                                                <td>Name</td>
                                                <td>:</td>
                                                <td>{{ $student->fname }} {{ $student->lname }}</td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="input-field col s12">
                                                        <input type="email" name="email" id="email"
                                                            class="validate" value="{{ $student->email }}"
                                                            style="font-size:1.5rem;" autofocus>
                                                        @error('email')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Phone</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="input-field col s12">
                                                        <input type="number" name="phone" id="phone"
                                                            class="validate" value="{{ $student->phone }}"
                                                            style="font-size:1.5rem;">
                                                        @error('phone')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Passport No.(e.g ABCD12)</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="input-field col s12">
                                                        <input type="text" name="passport_no" id="passport_no"
                                                            class="validate" value="{{ $student->passport_no }}"
                                                            style="font-size:1.5rem;">
                                                        @error('passport_no')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Birthday</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="file-field input-field col s12">
                                                        <input id="dob" type="date" name="dob"
                                                            value="{{ $student->dob }}" class="validate"
                                                            style="font-size:1.5rem;">
                                                        @error('dob')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Current Address</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="input-field col s12">
                                                        <input type="text" name="address" id="address"
                                                            class="validate" value="{{ $student->address }}"
                                                            style="font-size:1.5rem;">
                                                        @error('address')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Permanent Address</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="input-field col s12">
                                                        <input type="text" name="permanent_address"
                                                            id="permanent_address" class="validate"
                                                            value="{{ $student->permanent_address }}"
                                                            style="font-size:1.5rem;">
                                                        @error('permanent_address')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Country</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="input-field col s6">
                                                        <input type="text" name="country" id="country"
                                                            class="validate" value="{{ $student->country }}"
                                                            style="font-size:1.5rem;">
                                                        @error('country')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>City</td>
                                                <td>:</td>
                                                <td>
                                                    <div class="input-field col s12">
                                                        <input type="text" name="city" id="city"
                                                            class="validate" value="{{ $student->city }}"
                                                            style="font-size:1.5rem;">
                                                        @error('city')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="input-field col s6">
                                                        <select name="gender_sts" id="" required>
                                                            <option value="" disabled>--Gender Status--</option>
                                                            <option value="Male"
                                                                {{ $student->marital_sts == 'Male' ? 'selected' : '' }}>
                                                                Male</option>
                                                            <option value="Female"
                                                                {{ $student->marital_sts == 'Female' ? 'selected' : '' }}>
                                                                Female</option>
                                                            <option value="Other"
                                                                {{ $student->marital_sts == 'Other' ? 'selected' : '' }}>
                                                                Other</option>
                                                        </select>
                                                        @error('gender_sts')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td colspan="2">
                                                    <div class="input-field col s6">
                                                        <select name="marital_sts" id="" required>
                                                            <option value="" disabled>Marital Status</option>
                                                            <option value="Single"
                                                                {{ $student->gender_sts == 'Single' ? 'selected' : '' }}>
                                                                Single</option>
                                                            <option value="Married"
                                                                {{ $student->gender_sts == 'Married' ? 'selected' : '' }}>
                                                                Married</option>
                                                            <option value="Divorce"
                                                                {{ $student->gender_sts == 'Divorce' ? 'selected' : '' }}>
                                                                Divorce</option>
                                                        </select>
                                                        @error('marital_sts')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </td>
                                            <tr>
                                                <td colspan="2">
                                                    <div class="file-field input-field col s12">
                                                        <div class="btn admin-upload-btn">
                                                            <span>File</span>
                                                            <input type="file" name="education_certificate"
                                                                value="{{ $student->education_certificate }}">
                                                        </div>
                                                        <div class="file-path-wrapper">
                                                            <input class="file-path validate" type="text"
                                                                value="{{ old('education_certificate') }}"
                                                                placeholder="Education Certificate (Optional)"
                                                                style="font-size:1.5rem;">
                                                        </div>
                                                        @error('education_certificate')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <div class="file-field input-field col s12">
                                                        <div class="btn admin-upload-btn">
                                                            <span>File</span>
                                                            <input type="file" name="other_documents">
                                                        </div>
                                                        <div class="file-path-wrapper">
                                                            <input class="file-path validate" type="text"
                                                                value="{{ old('other_documents') }}"
                                                                placeholder="Other Documents (Optional)"
                                                                style="font-size:1.5rem;">
                                                        </div>
                                                        @error('other_document')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <div class="file-field input-field col s8">
                                                        <div class="btn admin-upload-btn">
                                                            <span>File</span>
                                                            <input type="file" name="profile">
                                                        </div>
                                                        <div class="file-path-wrapper">
                                                            <input class="file-path validate" type="text"
                                                                value=""
                                                                placeholder="Student Profile (Optional)"
                                                                style="font-size:1.5rem;">
                                                        </div>
                                                        @error('profile')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="input-field col s12">
                                                        <i class="waves-effect waves-light btn-large waves-input-wrapper"
                                                            style="">
                                                            <input type="submit" class="waves-button-input">
                                                        </i>
                                                    </div>
                                                </td>
                                            </tr>
                                        </form>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--SECTION END-->

</x-layout>
