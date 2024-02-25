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
                            <h4>All News</h4>
                            <p>All about students like name, student id, phone, email, country, city and more</p>
                        </div>
                        <div class="tab-inn">
                            <div class="table-responsive table-desi">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Body</th>
                                            <th>By</th>
                                            <th>Status</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($news as $new)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <span class="list-img">
                                                        <img src="{{ asset('storage/' . $new->image) }}" alt="">
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="/news/{{ $new->slug }}">{{ $new->title }}</a>
                                                </td>
                                                <td>{{ Str::limit($new->body, 30, '...') }}</td>
                                                <td>
                                                    <span class="label label-primary">{{ $new->user->name }}</span>
                                                </td>
                                                <td>
                                                    <span class="label label-success">Active</span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.news.edit',[$new->id]) }}" class="ad-st-view">Edit</a>
                                                </td>
                                                @if(auth()->user()->can('Read and Write'))
                                                <td>
                                                    <form action="{{ route('admin.news.delete',$new->id) }}" method="POST">
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
