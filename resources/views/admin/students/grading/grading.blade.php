<x-admin_layout>
    <div class="sb2-2-2">
        <ul>
            <li><a href="/"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li class="active-bre"><a href="#"> All Enquiry</a>
            </li>
            <li class="page-back"><a href="/admin/students/create"><i class="fa fa-plus" aria-hidden="true"></i> Add
                    Student</a>
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
                                        <th>First Year</th>
                                        <th>Second Year</th>
                                        <th>Third Year</th>
                                        <th>Fourth Year</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#</td>
                                        <td>{{ $student->fname }} {{ $student->lname }}</td>
                                        <td>{{ $student->course->title }}</td>
                                        <td>
                                            <a href="{{ route('admin.student.grading.byYear', ['studentId' => $student->id, 'yearId' => 1]) }}"
                                                class="ad-st-view">First Year</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.student.grading.byYear', ['studentId' => $student->id, 'yearId' => 2]) }}"
                                                class="ad-st-view">Second Year</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.student.grading.byYear', ['studentId' => $student->id, 'yearId' => 3]) }}"
                                                class="ad-st-view">Third Year</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.student.grading.byYear', ['studentId' => $student->id, 'yearId' => 4]) }}"
                                                class="ad-st-view">Fourth Year</a>
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
