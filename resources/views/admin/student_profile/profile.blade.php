<x-admin_layout>
    <div class="sb2-2-2">
        <ul>
            <li><a href="/"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li class="active-bre"><a href="#"> Student Profile</a>
            </li>
            <li class="page-back"><a href="{{ route('admin.student.profile.edit', $identifier) }}"><i class="fa fa-edit" aria-hidden="true"></i> Update Your Profile</a>
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
                                        <td>Student Profile</td>
                                        <td>:</td>
                                        <td>
                                            @if ($student->profile)
                                                <img src="/storage/{{ $student->profile }}"
                                                    alt="{{ $student->profile }}" width="80">
                                            @else
                                                No Profile found.
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Student Name</td>
                                        <td>:</td>
                                        <td>{{ $student->fname }} {{ $student->lname }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <td>Study Course</td>
                                        <td>:</td>
                                        <td>
                                            @foreach ($courses as $course)
                                                @if ($course->id == $student->course_id)
                                                    {{ $course->title }}
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <td>Joined Courses</td>
                                        <td>:</td>
                                        <td>
                                            @if ($joinedCourses->isNotEmpty())
                                                <ul>
                                                    @foreach ($joinedCourses as $joinedCourse)
                                                        <li>
                                                            <div class="row">
                                                                <div class="col s4">
                                                                    {{ $joinedCourse->title }} -
                                                                    <form
                                                                            action="{{ route('admin.students.course.year.delete', ['student' => $student->id, 'year' => $joinedCourse->years[0]->id]) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-danger">Delete</button>
                                                                        </form>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p>No joined courses found.</p>
                                            @endif
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <td>Add Joined Program</td>
                                        <td>:</td>
                                        <td>
                                            <form
                                                action="{{ route('admin.students.addCourse', ['student' => $student->id]) }}"
                                                method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col s6">
                                                        <select class="input-field" name="course_id" required>
                                                            <option value="" disabled selected>Select Course
                                                            </option>
                                                            @foreach ($courses as $course)
                                                                <option
                                                                    {{ $course->id == old('course_id') ? 'selected' : '' }}
                                                                    value="{{ $course->id }}">{{ $course->title }}
                                                                </option>
                                                                @error('course_id')
                                                                    <p class="text-danger">{{ $message }}</p>
                                                                @enderror
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col s6">
                                                        <select class="input-field" name="year_id" required>
                                                            <option value="" disabled selected>Academic Year
                                                            </option>
                                                            @foreach ($years as $year)
                                                                <option
                                                                    {{ $year->id == old('year_id') ? 'selected' : '' }}
                                                                    value="{{ $year->id }}">{{ $year->name }}
                                                                </option>
                                                                @error('year_id')
                                                                    <p class="text-danger">{{ $message }}</p>
                                                                @enderror
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit">Add Course</button>
                                            </form>
                                        </td>
                                    </tr> --}}

                                    <tr>
                                        <td>Student Id</td>
                                        <td>:</td>
                                        <td>{{ $student->student_id }}</td>
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
                                        <td>Date of Birth</td>
                                        <td>:</td>
                                        <td>{{ $student->dob }}</td>
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
                                        <td>Address</td>
                                        <td>:</td>
                                        <td>{{ $student->address }}</td>
                                    </tr>
                                    <tr>
                                        <td>National Id</td>
                                        <td>:</td>
                                        <td>{{ $student->national_id }}</td>
                                    </tr>
                                    <tr>
                                        <td>Passport No</td>
                                        <td>:</td>
                                        <td>{{ $student->passport_id }}</td>
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
                                        <td>Education Background</td>
                                        <td>:</td>
                                        <td>
                                            <span class="db-done">
                                                @if ($student->education_certificate)
                                                    <a href="{{ asset('storage/'.$student->education_certificate) }}" download>Download
                                                </a>
                                                @else
                                                No Document Found.
                                                @endif
                                            </span></td>
                                    </tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="{{ route('admin.student.profile.edit', $identifier) }}"
                                                    class="btn btn-primary">Edit</a>
                                                <a href="{{ route('admin.student.profile.password-change', $identifier) }}"
                                                    class="btn btn-primary">Change Password</a>
                                            </div>
                                        </div>
                                    </td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin_layout>
