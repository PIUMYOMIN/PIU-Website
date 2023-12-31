<x-admin_layout>
  <div class="sb2-2-2">
                    <ul>
                        <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                        </li>
                        <li class="active-bre"><a href="#"> Dashboard</a>
                        </li>
                        @if (auth()->user()->can('Read and Write') || 
                        auth()->user()->can('Write Only'))
                            <li class="page-back"><a href="/admin/course-category/create"><i class="fa fa-plus" aria-hidden="true"></i> Add Category</a>
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
                                    <p>All about courses, program structure, fees, best course lists (ranking), syllabus, teaching techniques and other details.</p>
                                </div>
                                <div class="tab-inn">
                                    <div class="table-responsive table-desi">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
													                          <th>Description</th>
													                          <th>By</th>
													                          <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($categories as $category)
                                                  <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $category->name }}</td>
                                                    <td>{{ Str::limit($category->description, 30, '...') }}</td>
                                                    <td>{{ $category->user->name }}</td>
													                          <td><a href="{{ route('admin.course.category.edit',[$category->id]) }}" class="ad-st-view">Edit</a></td>
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