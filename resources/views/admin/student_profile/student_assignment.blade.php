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
                                            <th>Assignment</th>
                                            <th>Description</th>
                                            <th>Module</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($assignments as $assignment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    {{ $assignment->assignment->name }}</a>
                                                </td>
                                                <td>
                                                    {{ Str::limit($assignment->body, 30, '...') }}
                                                </td>
                                                <td>{{ $assignment->module->module_code }}</td>
                                                @if ($assignment->is_submitted == 0) 
                                                    <td>
                                                        <span class="label label-success">Submitted</span>
                                                    </td>
                                                @else
                                                    <td>
                                                        <span class="label label-danger">Need Action</span>
                                                    </td>
                                                @endif
                                                <td>
                                                    <a href="#!" class="ad-st-view" >View</a>
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
