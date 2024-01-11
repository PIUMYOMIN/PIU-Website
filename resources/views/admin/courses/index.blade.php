<x-admin_layout>
    <div class="sb2-2-2">
        <ul>
            <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li class="active-bre"><a href="#"> Dashboard</a>
            </li>
            @if (auth()->user()->can('Read and Write') ||
                    auth()->user()->can('Write Only'))
                <li class="page-back"><a href="/admin/course/create"><i class="fa fa-plus" aria-hidden="true"></i> Add
                        Course</a>
                </li>
            @endif
        </ul>
    </div>

    <!--== User Details ==-->
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <h4>Course Details</h4>
                        <p>All about courses, program structure, fees, best course lists (ranking), syllabus, teaching
                            techniques and other details.</p>
                    </div>
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Course Name</th>
                                        <th>Category</th>
                                        <th>Durations</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Total Seats</th>
                                        <th>Created By</th>
                                        <th>Active</th>
                                        <th>Application on/off</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courses as $course)
                                        <tr>
                                            <td>
                                                <span class="list-img">
                                                    <img src="{{ asset('storage/' . $course->image) }}" alt="">
                                                </span>
                                            </td>
                                            <td>
                                                <a href="/courses/{{ $course->slug }}">
                                                    <span class="list-enq-name">{{ $course->title }}</span>
                                                    <span class="list-enq-city">Mandalay, Myanmar</span>
                                                </a>
                                            </td>
                                            <td>{{ $course->category->name }}</td>
                                            <td>{{ $course->duration }}</td>
                                            <td>{{ $course->start_date }}</td>
                                            <td>{{ $course->end_date }}</td>
                                            <td>{{ $course->total_seat }}</td>
                                            <td>{{ $course->user->name }}</td>
                                            <td>
                                                <form method="POST"
                                                    action="/admin/course/{{ $course->id }}/isActive">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="is_active"
                                                            id="isActive_{{ $course->id }}" role="switch"
                                                            {{ $course->is_active ? 'checked' : '' }}
                                                            onchange="this.form.submit()">
                                                        <label
                                                            class="form-check-label"for="isActive_{{ $course->id }}"></label>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>
                                                <form method="POST"
                                                    action="/admin/course/{{ $course->id }}/application">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="application_sts"
                                                            id="application_sts_{{ $course->id }}" role="switch"
                                                            {{ $course->application_sts ? 'checked' : '' }}
                                                            onchange="this.form.submit()">
                                                        <label
                                                            class="form-check-label"for="application_sts_{{ $course->id }}"></label>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.course.edit', [$course->id]) }}"
                                                    class="ad-st-view">Edit</a>
                                                <form action="{{ route('admin.course.delete', [$course->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="ad-st-view">Delete</button>
                                                </form>
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
