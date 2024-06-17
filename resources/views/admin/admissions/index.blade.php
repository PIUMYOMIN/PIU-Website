<x-admin_layout>
    <!--== breadcrumbs ==-->
    <div class="sb2-2-2">
        <ul>
            <li><a href="/admin"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li class="active-bre"><a href="#"> All Admission Form</a>
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
                        <select onchange="filterAdmissions(event)">
                            <option disabled selected>Choose Program</option>
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
                                        <th>Applicant Name</th>
                                        <th>Applied Course</th>
                                        <th>Education Certificate</th>
                                        <th>Personal Statement</th>
                                        <th>Other Document</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="admissionsTableBody">
                                    @foreach ($admissions as $admission)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $admission->name }}</td>
                                            <td>
                                                @if ($admission->course)
                                                    {{ $admission->course->title }}
                                                @else
                                                    No course found.
                                                @endif
                                            </td>
                                            <td>
                                                @if ($admission->education_certificate)
                                                    <a href="{{ asset('storage/' . $admission->education_certificate) }}"
                                                        download>Download Education Certificate</a>
                                                @else
                                                    No document found.
                                                @endif
                                            </td>
                                            <td>
                                                @if ($admission->personal_statement)
                                                    <a href="{{ asset('storage/' . $admission->personal_statement) }}"
                                                        download>Download Personal Statement</a>
                                                @else
                                                    No document found.
                                                @endif
                                            </td>
                                            <td>
                                                @if ($admission->other_document)
                                                    <a href="{{ asset('storage/' . $admission->other_document) }}"
                                                        download>Download Other Document</a>
                                                @else
                                                    No document found.
                                                @endif
                                            </td>
                                            <td>
                                                <a href="/admin/admissions/{{ $admission->id }}/details"
                                                    class="ad-st-view">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterAdmissions(event) {
            const selectedCourseId = event.target.value;

            fetch(`/admin/admissions/filter/${selectedCourseId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Course not found or not active');
                    }
                    return response.json();
                })
                .then(data => displayAdmissions(data))
                .catch(error => {
                    console.error(error);
                    // Handle the error, e.g., display a message to the user
                });
        }

        function displayAdmissions(admissions) {
            const tableBody = document.getElementById('admissionsTableBody');
            tableBody.innerHTML = '';
            let iteration = 0;

            admissions.forEach(admission => {
                iteration++;
                const row = document.createElement('tr');
                row.innerHTML = `
            <td>${iteration}</td>
            <td>${admission.name}</td>
            <td>${admission.course.title}</td>
            <td>${admission.personal_statement}</td>
            <td>${admission.education_certificate}</td>
            <td>${admission.other_document}</td>
            <td>
                <a href="/admin/admissions/${admission.id}/details" class="ad-st-view">View</a>
            </td>
        `;
                tableBody.appendChild(row);
            });
        }
    </script>

</x-admin_layout>
