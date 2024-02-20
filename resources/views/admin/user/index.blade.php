<x-admin_layout>
    <div class="sb2-2-2">
                    <ul>
                        <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                        </li>
                        <li class="active-bre"><a href="#"> Users(Students)</a>
                        </li>
                        <li class="page-back"><a href="index-2.html"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
                        </li>
                    </ul>
                </div>

                <!--== User Details ==-->
                <div class="sb2-2-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-inn-sp">
                                <div class="inn-title">
                                    <h4>Student Details</h4>
                                    <p>All about students like name, student id, phone, email, country, city and more</p>
                                </div>
                                <div class="tab-inn">
                                    <div class="table-responsive table-desi">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>User</th>
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Email</th>
                                                    <th>Date of birth</th>
													<th>Status</th>
													<th>View</th>
													<th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                    <tr>
                                                    <td>
                                                        <span class="list-img">
                                                            <img src="{{ $user->picture }}" alt=""></span>
                                                    </td>
                                                    <td>
                                                        <a href="#"><span class="list-enq-name">{{ $user->name }}</span><span class="list-enq-city">{{ $user->city }}, {{ $user->country }}</span>
                                                        </a>
                                                    </td>
                                                    <td>{{ $user->phone }}</td>
                                                    <td>{{ $user->email }}</td>
													<td>{{ $user->created_at }}</td>
                                                    <td>
                                                        <span class="label label-success">Active</span>
                                                    </td>
													<td>
                                                        <a href="/admin/users/{{ $user->id }}/details" class="ad-st-view">Details</a>
                                                    </td>
													<td>
                                                        @if (auth()->user()->email == $user->email)
                                                            <a href="{{ route('admin.users.profile.edit', ['user' => $user->id]) }}" class="ad-st-view">Edit</a>
                                                        @endif
                                                        @can('Read and Write')
                                                            <form action="{{ route('admin.users.destroy',$user->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                        <button type="submit" class="ad-st-view">Delete</button>
                                                    </form>
                                                        @endcan
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