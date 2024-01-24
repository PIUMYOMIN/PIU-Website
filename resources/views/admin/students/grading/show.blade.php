<x-admin_layout>
    <div class="sb2-2-2">
            <ul>
                <li><a href="/"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                </li>
                <li class="active-bre"><a href="#"> Student GPA Dashboard</a>
                </li>
                <li class="page-back"><a href="/admin"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
                </li>
            </ul>
        </div>

        <!--== User Details ==-->
        <div class="sb2-2-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-inn-sp">
                        <div class="inn-title">
                            <h4>Enquiry</h4>
                            <p>All about students like name, student id, phone, email, country, city and more</p>
                        </div>
                        <div class="tab-inn">
                            <div class="table-responsive table-desi">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Study Program</th>
                                            <th>Semester</th>
                                            <th>Assignment</th>
                                            <th>Module Code</th>
                                            <th>Grade Point</th>
                                            <th>Grade Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($gradings as $grading)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $grading->student->fname }} {{ $grading->student->lname }}</td>
                                                <td>{{ $grading->course->title }}</td>
                                                <td>{{ $grading->semester->name }}</td>
                                                <td>{{ $grading->assignment->name }}</td>
                                                <td>{{ $grading->module->module_code }}</td>
                                                <td>{{ $grading->grade_point }}</td>
                                                <td>{{ $grading->grade_value }}</td>
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
