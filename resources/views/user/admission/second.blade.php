<x-layout>
    <!--SECTION START-->
    <section class="c-all h-quote">
        <div class="container">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="all-title quote-title qu-new">
                    <h2>Requirements</h2>
                    <ul>
                        <li>
                            - Have any document or certificate that shows successfully complete of the Myanmar
                            Matriculation Examination or IGCSE or GED.
                        </li>
                        <li>
                            - Have at least qan IELTS band score of 5.5 or an equivalent score on other standardized
                            English Language Proficiency tests, or if not, sit the extrance exam for English Language
                            Proficiency.
                        </li>
                    </ul>
                    <p class="help-line">Help Line <span>+09-793200074</span> </p> <span class="help-arrow pulse"><i
                            class="fa fa-angle-right" aria-hidden="true"></i></span>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="n-form-com admiss-form">
                    <div class="col s12">
                        <form class="form-horizontal" action="{{ route('piu.application.second-form') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="name" value="{{ $validatedData['name'] }}">
                            <input type="hidden" name="email" value="{{ $validatedData['email'] }}">
                            <input type="hidden" name="phone" value="{{ $validatedData['phone'] }}">
                            <input type="hidden" name="address" value="{{ $validatedData['address'] }}">
                            <input type="hidden" name="country" value="{{ $validatedData['country'] }}">
                            <input type="hidden" name="city" value="{{ $validatedData['city'] }}">
                            <input type="hidden" name="zipcode" value="{{ $validatedData['zipcode'] }}">
                            <input type="hidden" name="course_id" value="{{ $validatedData['course_id'] }}">
                            <div class="form-group">
                                <label class="control-label col-sm-3">Alumni Status:</label>
                                <div class="col-sm-9">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Old_Student"
                                            name="alumni_sts" id="yes" required>
                                        <label class="form-check-label" for="yes">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="New_Student"
                                            name="alumni_sts" id="no" required>
                                        <label class="form-check-label" for="no">No</label>
                                    </div>
                                    <input type="text" name="student_id" id="student_id" style="display: none;"
                                        placeholder="Enter your student ID" required>
                                    @error('alumni_sts')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Sex:</label>
                                <div class="col-sm-9">
                                    <select name="gender" class="" required>
                                        <option value="" selected disabled>Select Your Sex</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    @error('gender')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Date Of Birth:</label>
                                <div class="col-sm-9">
                                    <input type="date" name="dob" value="{{ old('dob') }}"
                                        class="form-control" placeholder="Date of Birth" required>
                                    @error('dob')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Marital Status:</label>
                                <div class="col-sm-9">
                                    <select name="marital_sts" class="" required>
                                        <option value="" selected disabled>Select Marital Status</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                    </select>
                                    @error('marital_sts')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">National ID:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="national_id" value="{{ old('national_id') }}"
                                        class="form-control" placeholder="National (OR) Passport No" required>
                                    @error('national_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Do you have IELTS, TOEFL, or other English
                                    Language Proficiency test scores?</label>
                                <div class="col-sm-9">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="Yes"
                                            id="has_language_proficiency" required>
                                        <label class="form-check-label" for="has_language_proficiency">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="No"
                                            id="no_language_proficiency" required>
                                        <label class="form-check-label" for="no_language_proficiency">No</label>
                                    </div>

                                    <input type="file" name="language_proficiency"
                                        id="language_proficiency_file_input" accept=".pdf,.doc,.docx"
                                        style="display: none;">
                                    @error('language_proficiency')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-3">Profile Image
                                    (Compulsory)
                                    (PNG,JPG,JPEG)</label>
                                <div class="col-sm-9">
                                    <input type="file" name="profile" accept="png,jpg,jpeg" required>
                                    @error('profile')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Personal Statement Mini:300-500
                                    words (pdf,doc,docx):</label>
                                <div class="col-sm-9">
                                    <input type="file" name="personal_statement" accept=".pdf,.doc,.docx"
                                        required>
                                    @error('personal_statement')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Education Certificate (GED or IGCSE or High
                                    School Certificate):</label>
                                <div class="col-sm-9">
                                    <input type="file" name="education_certificate" accept=".pdf,.doc,.docx"
                                        required>
                                    @error('education_certificate')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Other Documents (pdf,doc,docx):</label>
                                <div class="col-sm-9">
                                    <input type="file" name="other_document" accept=".pdf,.doc,.docx">
                                    @error('other_document')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mar-bot-0">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <i class="waves-effect waves-light light-btn waves-input-wrapper"
                                        style=""><input type="submit" value="CONFIRM"
                                            class="waves-button-input"></i>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--SECTION END-->


    <!--SECTION START-->

    <!--SECTION END-->
    <script>
        const yesRadio = document.getElementById("yes");
        const noRadio = document.getElementById("no");
        const noneRadio = document.getElementById("none");
        const studentIdInput = document.getElementById("student_id");
        const hasLanguageProficiencyRadio = document.getElementById("has_language_proficiency");
        const languageProficiencyFileInput = document.getElementById("language_proficiency_file_input");

        studentIdInput.style.display = "none";
        languageProficiencyFileInput.style.display = "none";

        yesRadio.addEventListener("change", toggleStudentIdField);
        noRadio.addEventListener("change", toggleStudentIdField);
        hasLanguageProficiencyRadio.addEventListener("change", toggleLanguageProficiencyField);

        function toggleStudentIdField() {
            if (yesRadio.checked) {
                studentIdInput.style.display = "block";
                studentIdInput.setAttribute("required", "required");
            } else {
                studentIdInput.style.display = "none";
                studentIdInput.removeAttribute("required");
                studentIdInput.value = "";
            }
        }

        function toggleLanguageProficiencyField() {
            if (hasLanguageProficiencyRadio.checked) {
                // Display the file input field when "Yes" is selected
                languageProficiencyFileInput.style.display = "block";
                languageProficiencyFileInput.setAttribute("required", "required");
            } else {
                // Hide the file input field when "No" is selected
                languageProficiencyFileInput.style.display = "none";
                languageProficiencyFileInput.removeAttribute("required");
                languageProficiencyFileInput.value = "";
            }
        }
    </script>
</x-layout>
