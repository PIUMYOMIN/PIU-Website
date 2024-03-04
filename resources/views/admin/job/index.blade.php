<x-admin_layout>
    <div class="sb2-2-2">
            <ul>
                <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                </li>
                <li class="active-bre"><a href="#"> Events</a>
                </li>
                <li class="page-back"><a href="{{ route('admin.news.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Add News</a>
                </li>
            </ul>
        </div>

        <!--== User Details ==-->
        <div class="sb2-2-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-inn-sp">
                                <div class="inn-title">
									<h4>All Jobs</h4>
                                    <p>All about students like name, student id, phone, email, country, city and more</p>
                                </div>
                                <div class="tab-inn">
                                    <div class="table-responsive table-desi">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Position</th>
													<th>Description</th>
													<th>No of Vacants</th>
													<th>Job Campus</th>
                                                    <th>Deadline</th>
													<th>Location</th>
													<th>Status</th>
													<th>Edit</th>
													<th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($jobs as $job) 
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
    													<td>{{ $job->title }}</td>
                                                        <td>{{ Str::limit($job->description, 20, '...') }}</td>
    													<td>{{ $job->num_of_posts }}</td>
    													<td>{{ $job->job_campus }}</td>
    													<td>{{ $job->expire_date }}</td>
    													<td>{{ $job->country }},{{ $job->city }}</td>
                                                        <td>
                                                            <span class="label label-success">Active</span>
                                                        </td>
    													<td>
                                                            <a href="{{ route('admin.jobs.edit', $job->id) }}" class="ad-st-view">Edit</a>
                                                        </td>
                                                        <form action="{{ route('admin.jobs.delete',$job->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
    													<td>
                                                            <button type="submit" class="ad-st-view">Delete</button>
                                                        </td>
                                                        </form>
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
