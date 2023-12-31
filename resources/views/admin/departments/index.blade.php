  <x-admin_layout>
    <div class="sb2-2-2">
                    <ul>
                        <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                        </li>
                        <li class="active-bre"><a href="#"> Departments</a>
                        </li>
                        <li class="page-back"><a href="{{ route('admin.department.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Add Department</a>
                        </li>
                    </ul>
                </div>

                <!--== User Details ==-->
                <div class="sb2-2-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-inn-sp">
                                <div class="inn-title">
									<h4>All Departments</h4>
                                    <p>All about students like name, student id, phone, email, country, city and more</p>
                                </div>
                                <div class="tab-inn">
                                    <div class="table-responsive table-desi">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
													                          <th>Name</th>
													                          <th>Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($departments as $department)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $department->name }}</td>
													                          <td><a href="/admin/department/{{ $department->id }}/edit" class="ad-st-view">Edit</a></td>
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