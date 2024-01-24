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
                        <div class="udb-sec udb-cour">
                            <h4>
                                Change Your Password
                            </h4>
                            <p>Please keep in mind your update password. If you're forgotten your password, please
                                contact to PIU Management Team.</p>

                            <div class="sdb-cours">
                                <form class="s12"
                                    action="{{ route('student.profile.update_password', ['student_id' => $student->id]) }}"
                                    method="POST">
                                    @method('patch')
                                    @csrf
                                    <div>
                                        <div class="input-field s12">
                                            <input id="current_password" type="password" name="current_password"
                                                class="validate" required>
                                            <label class="">Current Password</label>
                                            @error('current_password')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <div class="input-field s12">
                                            <input id="new_password" type="password" name="new_password"
                                                class="validate" required>
                                            <label class="">New Password</label>
                                            @error('new_password')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <div class="input-field s12">
                                            <input id="password_confirmation" type="password"
                                                name="new_password_confirmation" class="validate" required>
                                            <label class="">Re-type Password</label>
                                            @error('password_confirmation')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <div class="input-field s4">
                                            <button type="submit"
                                                class="waves-effect waves-light log-in-btn waves-input-wrapper">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--SECTION END-->
</x-layout>
