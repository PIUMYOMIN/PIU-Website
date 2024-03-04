<x-admin_layout>
    <div class="sb2-2-2">
            <ul>
                <li><a href="/"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                </li>
                <li class="active-bre"><a href="#"> All Enquiry</a>
                </li>
                @if (auth()->user() && auth()->user()->can('Read and Write') ||
                    auth()->user()->can('Registrar'))
                <li class="page-back"><a href="/admin/student/create"><i class="fa fa-plus" aria-hidden="true"></i> Add Student</a>
                </li>
                @endif
            </ul>
        </div>

        <!--== User Details ==-->
        <div class="sb2-2-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-inn-sp">
                        <div class="inn-title flex">
                            <h4>Student List</h4>
                            <select onchange="filterstudent(event)">
                                <option disabled selected>Filter</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="tab-inn">
                            <div class="table-responsive table-desi">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Student Id</th>
                                            <th>Study Program</th>
                                            <th>Scademic Year</th>
                                            <th>Registered By</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="studentsTableBody">
                                        @foreach ($students as $student)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $student->fname }} {{ $student->lname }}</td>
                                                <td>{{ $student->student_id }}</td>
                                                <td>{{ $student->course->title }}</td>
                                                <td>{{ $student->year->name }}</td>
                                                <td>{{ $student->user->name }}</td>
                                                <td>
                                                    <a href="{{ route('admin.students.profile.details',$student->id) }}"
                                                        class="ad-st-view">View</a>
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
            fetch(`/admin/students/study-course/${selectedCourseId}`).then(response => {
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
            <td>${student.year.name}</td>
            <td>${student.user.name}</td>
            <td>
                <a href="/admin/students/profile/${student.id}/details" class="ad-st-view">View</a>
            </td>
        `;
        tableBody.appendChild(row);
    });
}
    </script>
</x-admin_layout>
