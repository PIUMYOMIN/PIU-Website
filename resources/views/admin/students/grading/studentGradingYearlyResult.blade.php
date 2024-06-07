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
                                            <th>Year</th>
                                            <th>First Semester</th>
                                            <th>Second Semester</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                                <td>#</td>
                                                <td>{{ $student->fname }} {{ $student->lname }}</td>
                                                <td>{{ $student->course->title }}</td>
                                                <td>{{ $year->name }}</td>
                                                <td>
                                                  <a href="{{ route('admin.student.semester.grading.view',['student' => $student->id, 'semester' => 1, 'year' => $year->id]) }}" class="ad-st-view">First Semester</a>
                                                </td>
                                                <td>
                                                  <a href="{{ route('admin.student.semester.grading.view',['student' => $student->id, 'semester' => 2, 'year' => $year->id]) }}" class="ad-st-view">Second Semester</a>
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
