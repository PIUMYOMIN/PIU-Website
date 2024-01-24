<x-layout>
    <!--SECTION START-->
    {{-- @dd($firstTermGpa) --}}
    <section>
        <div class="pro-cover">
        </div>
        <x-profile-menu-tab :student="$student" :notificationCount="$notificationCount" :newAssignmentCount="$newAssignmentCount" />
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
                                        <form action="update" method="POST" enctype="multipart/form-data">
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
                                                <td>{{ $student->email }}</td>
                                            </tr>
                                            <tr>
                                                <td>Phone</td>
                                                <td>:</td>
                                                <td>{{ $student->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>Current Address</td>
                                                <td>:</td>
                                                <td>{{ $student->address }}</td>
                                            </tr>
                                            <tr>
                                                <td>Birthday</td>
                                                <td>:</td>
                                                <td>{{ $student->dob }}</td>
                                            </tr>
                                            <tr>
                                                <td>Permanent Address</td>
                                                <td>:</td>
                                                <td>{{ $student->permanent_address }}</td>
                                            </tr>
                                            <tr>
                                                <td>National No</td>
                                                <td>:</td>
                                                <td class="text-uppercase">{{ $student->national_no }}</td>
                                            </tr>
                                            <tr>
                                                <td>Passport No</td>
                                                <td>:</td>
                                                <td class="text-uppercase">{{ $student->passport_no }}</td>
                                            </tr>
                                            <tr>
                                                <td>Country</td>
                                                <td>:</td>
                                                <td>{{ $student->country }}</td>
                                            </tr>
                                            <tr>
                                                <td>City</td>
                                                <td>:</td>
                                                <td>{{ $student->city }}</td>
                                            </tr>
                                            <tr>
                                                <td>Marital Status</td>
                                                <td>:</td>
                                                <td>{{ $student->marital_sts }}</td>
                                            </tr>
                                            <tr>
                                                <td>Gender Status</td>
                                                <td>:</td>
                                                <td>{{ $student->gender_sts }}</td>
                                            </tr>
                                            <tr>
                                                <td>Current Course</td>
                                                <td>:</td>
                                                <td>{{ $student->course->title }}</td>
                                            </tr>
                                            <tr>
                                                <td>First Term</td>
                                                <td>:</td>
                                                <td>{{ $firstTermGpa }}</td>
                                            </tr>
                                            <tr>
                                                <td>Second Term</td>
                                                <td>:</td>
                                                <td>{{ $secondTermGpa }}</td>
                                            </tr>
                                            <tr>
                                                <td>Third Term</td>
                                                <td>:</td>
                                                <td>{{ $thirdTermGpa }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="/admin/students/profile/{{ $student->student_id }}/edit"
                                                        class="waves-effect waves-light btn-large sdb-btn"><i
                                                            class="fa fa-pencil"></i> Edit my profile</a>
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
