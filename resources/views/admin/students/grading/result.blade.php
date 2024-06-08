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
                            <div>
                                <select onchange="filterstudent(event)">
                                <option disabled selected>Filter</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="tab-inn">
                            <div class="table-responsive table-desi">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Studied Program</th>
                                            <th>Student ID</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody id="studentsTableBody">
                                        @foreach ($students as $student)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $student->fname }} {{ $student->lname }}</td>
                                                <td>{{ $student->course->title }}</td>
                                                <td>{{ $student->student_id }}</td>
                                                <td>
                                                  <a href="{{ route('admin.student.grading',['id' => $student->id]) }}" class="ad-st-view">View</a>
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
        <script>
        function filterstudent(event) {
            const selectedCourseId = event.target.value;
            fetch(`/admin/students/grading/study-course/${selectedCourseId}`).then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch students');
            }
            return response.json();
        })
        .then(data => displayStudent(data))
        .catch(error => {
            console.error(error);
            // Handle the error, e.g., display a message to the user
        });
}

function displayStudent(students) {
    const tableBody = document.getElementById('studentsTableBody');
    tableBody.innerHTML = '';
    let iteration = 0;

    students.forEach(student => {
        iteration++;
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${iteration}</td>
            <td>${student.fname} ${student.lname}</td>
            <td>${student.student_id}</td>
            <td>${student.course.title}</td>
            <td>
                <a href="/admin/student/grading/${student.id}" class="ad-st-view">View</a>
            </td>
        `;
        tableBody.appendChild(row);
    });
}
    </script>
</x-admin_layout>
