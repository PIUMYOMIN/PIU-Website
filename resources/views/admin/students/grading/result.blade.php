<x-admin_layout>
    <div class="sb2-2-2">
            <ul>
                <li><a href="/"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                </li>
                <li class="active-bre"><a href="#"> All Enquiry</a>
                </li>
                <li class="page-back"><a href="/admin/students/create"><i class="fa fa-plus" aria-hidden="true"></i> Add Student</a>
                </li>
            </ul>
        </div>

        <!--== User Details ==-->
        <div class="sb2-2-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-inn-sp">
                        <div class="inn-title">
                            <h4>Student Grading List</h4>
                            <p>All about students like name, student id, phone, email, country, city and more</p>
                        </div>
                        <div class="tab-inn">
                            <div class="table-responsive table-desi">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Studied Course</th>
                                            <th>Academic Year</th>
                                            <th>First Semester</th>
                                            <th>Second Semester</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $student->fname }} {{ $student->lname }}</td>
                                                <td>{{ $student->course->title }}</td>
                                                <td>{{ $student->year->name }}</td>
                                                <td>
                                                  <a href="{{ route('admin.students.first_semester.grading.view',['student' => $student->id, 'semester' => 1]) }}" class="ad-st-view">First Semester</a>
                                                </td>
                                                <td>
                                                  <a href="{{ route('admin.students.second_semester.grading.view',['student' => $student->id, 'semester' => 2]) }}" class="ad-st-view">Second Semester</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-admin_layout>
