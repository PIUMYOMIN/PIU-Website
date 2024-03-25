<x-admin_layout>
    <div class="sb2-2-2">
        <ul>
            <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li class="active-bre"><a href="#"> Dashboard</a>
            </li>
            @if (auth()->user()->can('Read and Write') ||
                    auth()->user()->can('Write Only')||
                    auth()->user()->can('Registrar'))
                <li class="page-back"><a href="/admin/subjects/create"><i class="fa fa-plus" aria-hidden="true"></i> New
                        subject</a>
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
                        <h4>subject Details</h4>
                        <p>All about subjects, program structure, fees, best subject lists (ranking), syllabus, teaching
                            techniques and other details.</p>
                    </div>
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Course</th>
                                        <th>Module</th>
                                        <th>By</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subjects as $subject)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $subject->name }}</td>
                                            <td>{{ Str::limit($subject->description, 20, '...') }}</td>
                                            <td>{{ $subject->course->title }}</td>
                                            <td>{{ $subject->module->module_code }}</td>
                                            <td>{{ $subject->user->name }}</td>
                                            @if (auth()->user() ||
                                                    auth()->user()->can('Read and Write') &&
                                                    auth()->user()->can('Write') &&
                                                    auth()->user()->can('Manager') &&
                                                    auth()->user()->can('Registrar'))
                                            <td>
                                                <a href="{{ route('admin.subjects.edit', [$subject->id]) }}"
                                                    class="ad-st-view">
                                                    Edit
                                                </a>
                                            </td>
                                            @endif
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
