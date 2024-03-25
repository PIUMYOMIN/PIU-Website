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
                        <h4>Grading Point Value Details</h4>
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
                                        <th>Credit</th>
                                        <th>Grade Point</th>
                                        <th>Grade Value</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $totalGpaValue = 0;
                                    $totalCredits = 0;
                                    ?>
                                    @foreach ($gradings as $grading)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $grading->student->fname }} {{ $grading->student->lname }}</td>
                                            <td>{{ $grading->course->title }}</td>
                                            <td>{{ $grading->semester->name }}</td>
                                            <td>{{ $grading->assignment->name }}</td>
                                            <td>{{ $grading->module->module_code }}</td>
                                            <td>{{ $grading->module->credit }}</td>
                                            <td>{{ $grading->grade_point }}</td>
                                            <td>{{ $grading->grade_value }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('admin.student.grading.edit', [
                                                        'student' => $grading->student,
                                                        'grading' => $grading,
                                                        'semester' => $grading->semester,
                                                    ]) }}" class="ad-st-view">Edit</a>
                                            </td>
                                        </tr>
                                        <?php
                                        $totalGpaForOneAssignment = $grading->grade_point * $grading->module->credit;
                                        $totalGpaValue += $totalGpaForOneAssignment;
                                        $totalCredits += $grading->module->credit;
                                        ?>
                                    @endforeach
                                    @if ($gradings->count() > 0)
                                        <tr>
                                            <td colspan="6"></td>
                                            <td>Total Credits: <strong class="text-danger">{{ $totalCredits }}</strong>
                                            </td>
                                            <td>
                                                <?php
                                                $gpa = 0;
                                                if ($totalCredits > 0) {
                                                    $gpa = $totalGpaValue / $totalCredits;
                                                }
                                                ?>
                                                Total Grade Point Average: <strong class="text-info">{{ number_format($gpa, 2) }}</strong>
                                            </td>
                                            <td>
                                                @if (number_format($gpa, 2) >= 4) 
                                                Grade Value: <strong class="text-success">A</strong>
                                                @elseif (number_format($gpa, 2) >= 3) 
                                                Grade Value: <strong class="text-success">B</strong>
                                                @elseif (number_format($gpa, 2) >= 2) 
                                                Grade Value: <strong class="text-success">C</strong>
                                                @elseif (number_format($gpa, 2) >= 1) 
                                                Grade Value: <strong class="text-warning">D</strong>
                                                @elseif (number_format($gpa, 2) >= 0.7)
                                                Grade Value: <strong class="text-danger">E</strong>
                                                @elseif (number_format($gpa, 2) >= 0) 
                                                Grade Value: <strong class="text-danger">F</strong>
                                                @endif
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <td colspan="8"></td>
                                            <td>
                                                Total Grade Points: <strong class="text-success">
                                                    {{ number_format($totalGpaValue, 2) }}</strong>
                                            </td>
                                        </tr> --}}
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin_layout>
