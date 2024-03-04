<x-admin_layout>
    <div class="sb2-2-2">
            <ul>
                <li><a href="/admin"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                </li>
                <li class="active-bre"><a href="#"> Events</a>
                </li>
                @if(auth()->check() || auth()->user()->can('Read and Write') && auth()->user()->can('Registrar') && auth()->user()->can('Faculty'))
                <li class="page-back"><a href="/admin/assignment/create"><i class="fa fa-plus" aria-hidden="true"></i> Add Assignment</a>
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
                                            <th>Module Code</th>
                                            @if(auth()->check() && auth()->user()->can('Read and Write') && auth()->user()->can('Registrar'))
                                            <th>By</th>
                                            @endif
                                            <th>Status</th>
                                            @if(auth()->check() && auth()->user()->can('Read and Write'))
                                            <th>Edit</th>
                                            @endif
                                            {{-- @if(auth()->user()->can('Read and Write'))
                                            <th>Delete</th>
                                            @endif --}}
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($assignments as $assignment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="/assignments/{{ $assignment->slug }}">{{ $assignment->name }}</a>
                                                </td>
                                                <td>{{ Str::limit($assignment->description, 30, '...') }}</td>
                                                <td>{{ $assignment->module->module_code }}</td>
                                                @if(auth()->check() && auth()->user()->can('Read and Write') && auth()->user()->can('Registrar'))
                                                <td>
                                                    <span class="label label-primary">{{ $assignment->user->name }}</span>
                                                </td>
                                                @endif
                                                <td>
                                                    @php
                                                        $isSubmitted = false;
                                                    @endphp

                                                    @foreach ($student_assignments as $student_assignment)
                                                        @if ($assignment->id == $student_assignment->assignment_id)
                                                            @php
                                                                $isSubmitted = true;
                                                                break;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                    @if ($isSubmitted) 
                                                        <span class="label label-success">Submitded</span>
                                                    @else
                                                        <span class="label label-danger">Not Submitded</span>
                                                    @endif
                                                </td>
                                                @if(auth()->check() && auth()->user()->can('Read and Write'))
                                                <td>
                                                    <a href="{{ route('admin.assignment.edit',[$assignment->slug]) }}" class="ad-st-view">Edit</a>
                                                </td>
                                                @endif
                                                {{-- @if(auth()->user()->can('Read and Write'))
                                                <td>
                                                    <form action="{{ route('admin.assignment.delete',$assignment->slug) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="ad-st-view">Delete</button>
                                                    </form>
                                                </td>
                                                @endif --}}
                                                <td>
                                                    <a href="{{ route('admin.student.assignment.details',['slug' => $assignment->slug]) }}" class="ad-st-view" >View</a>
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
