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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Country</th>
                                        <th>City</th>
                                        <th>Address</th>
                                        <th>Department</th>
                                        <th>Position</th>
                                        <th>Status</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teams as $team)
                                        <tr>
                                            <td>
                                                <span class="list-img">
                                                    <img src="{{ asset('storage/' . $team->profile) }}" alt="">
                                                </span>
                                            </td>
                                            <td>{{ $team->name }}</td>
                                            <td>{{ $team->email }}</td>
                                            <td>{{ $team->phone }}</td>
                                            <td>{{ $team->country }}</td>
                                            <td>{{ $team->city }}</td>
                                            <td>{{ $team->address }}</td>
                                            <td>{{ $team->department->name }}</td>
                                            <td>{{ $team->position->name }}</td>
                                            <td>
                                                <span class="label label-success">Active</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.team.edit', [$team->id]) }}"
                                                    class="ad-st-view">Edit</a>
                                                <form action="{{ route('admin.team.delete', [$team->id]) }}"
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
