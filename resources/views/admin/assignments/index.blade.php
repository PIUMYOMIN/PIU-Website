<x-admin_layout>
    <div class="sb2-2-2">
            <ul>
                <li><a href="/admin"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                </li>
                <li class="active-bre"><a href="#"> Events</a>
                </li>
                <li class="page-back"><a href="/admin/assignment/create"><i class="fa fa-plus" aria-hidden="true"></i> Add Assignment</a>
                </li>
            </ul>
        </div>

        <!--== User Details ==-->
        <div class="sb2-2-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-inn-sp">
                        <div class="inn-title">
                            <h4>All Assignment</h4>
                            <p>All about students like name, student id, phone, email, country, city and more</p>
                        </div>
                        <div class="tab-inn">
                            <div class="table-responsive table-desi">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Body</th>
                                            <th>By</th>
                                            <th>Status</th>
                                            <th>Edit</th>
                                            @if(auth()->user()->can('Read and Write'))
                                            <th>Delete</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($assignments as $assignment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="/assignments/{{ $assignment->slug }}">{{ $assignment->name }}</a>
                                                </td>
                                                <td>{{ $assignment->body }}</td>
                                                <td>
                                                    <span class="label label-primary">{{ $assignment->user->name }}</span>
                                                </td>
                                                <td>
                                                    <span class="label label-success">Active</span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.assignment.edit',[$assignment->slug]) }}" class="ad-st-view">Edit</a>
                                                </td>
                                                @if(auth()->user()->can('Read and Write'))
                                                <td>
                                                    <form action="{{ route('admin.assignment.delete',$assignment->slug) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="ad-st-view">Delete</button>
                                                    </form>
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
