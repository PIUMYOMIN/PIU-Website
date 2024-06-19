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
                            <h4>Student Details</h4>
                            <p>You're strongly recommended to use the desktop computer to view the student details.</p>
                        </div>
                        <div class="udb-sec udb-prof">
                            <div class="sdb-tabl-com sdb-pro-table">
                                <table class="responsive-table bordered">
                                    <tbody>
                                        <tr>
                                            <td>Applicant Name</td>
                                            <td>:</td>
                                            <td>{{ $admission->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Profile</td>
                                            <td>:</td>
                                            <td>
                                                <a href="/storage/{{ $admission->profile }}" download>
                                                    <img src="{{ asset('storage/' . $admission->profile) }}"
                                                        alt="{{ $admission->profile }}" width="80">
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Applied Course</td>
                                            <td>:</td>
                                            <td>
                                                {{ $admission->course->title }}</td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>:</td>
                                            <td>{{ $admission->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td>:</td>
                                            <td>{{ $admission->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td>:</td>
                                            <td>{{ $admission->address }}</td>
                                        </tr>
                                        <tr>
                                            <td>Country</td>
                                            <td>:</td>
                                            <td>{{ $admission->country }}</td>
                                        </tr>
                                        <tr>
                                            <td>City</td>
                                            <td>:</td>
                                            <td>{{ $admission->city }}</td>
                                        </tr>
                                        <tr>
                                            <td>Zip Code</td>
                                            <td>:</td>
                                            <td>{{ $admission->zipcode }}</td>
                                        </tr>
                                        <tr>
                                            <td>Birthday</td>
                                            <td>:</td>
                                            <td>{{ $admission->dob }}</td>
                                        </tr>
                                        <tr>
                                            <td>National Id</td>
                                            <td>:</td>
                                            <td>{{ $admission->national_id }}</td>
                                        </tr>
                                        <tr>
                                            <td>Marital Status</td>
                                            <td>:</td>
                                            <td>{{ $admission->marital_sts }}</td>
                                        </tr>
                                        <tr>
                                            <td>Gender Status</td>
                                            <td>:</td>
                                            <td>{{ $admission->gender }}</td>
                                        </tr>
                                        <tr>
                                            <td>Student Sts</td>
                                            <td>:</td>
                                            <td>
                                                @if ($admission->student_id)
                                                    Old student with this student ID:{{ $admission->student_id }}
                                                @else
                                                    New Student
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Personal Statement</td>
                                            <td>:</td>
                                            <td>
                                                @if ($admission->personal_statement)
                                                    <a href="{{ asset('storage/' . $admission->personal_statement) }}"
                                                        download>Personal Statement</a>
                                                        <p>{{ $admission->personal_statement }}</p>
                                                @else
                                                    No document found.
                                                @endif 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Education Certificate</td>
                                            <td>:</td>
                                            <td>
                                                @if ($admission->education_certificate)
                                                    <a href="{{ asset('storage/' . $admission->education_certificate) }}"
                                                        download>Education Certificate</a>
                                                        <p>{{ $admission->education_certificate }}</p>
                                                @else
                                                    No document found.
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Language Proficiency</td>
                                            <td>:</td>
                                            <td>
                                                @if ($admission->language_proficiency)
                                                    <a href="{{ asset('storage/' . $admission->language_proficiency) }}"
                                                        download>Language Proficiency Document</a>
                                                        <p>{{ $admission->language_proficiency }}</p>
                                                @else
                                                    No document found.
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Other Document</td>
                                            <td>:</td>
                                            <td>
                                                @if ($admission->other_document)
                                                    <a href="{{ asset('storage/' . $admission->other_document) }}"
                                                        download>Other Document</a>
                                                        <p>{{ $admission->other_document }}</p>
                                                @else
                                                    No document found.
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-admin_layout>
