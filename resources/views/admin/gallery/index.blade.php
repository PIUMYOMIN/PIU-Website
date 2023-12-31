<x-admin_layout>
    <div class="sb2-2-2">
        <ul>
            <li><a href="/admin"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li class="active-bre"><a href="/admin/events"> Events</a>
            </li>
            <li class="page-back"><a href="/admin/gallery/create"><i class="fa fa-plus" aria-hidden="true"></i> Add
                    Gallery</a>
            </li>
        </ul>
    </div>

    <!--== User Details ==-->
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <h4>All Events</h4>
                        <p>All about students like name, student id, phone, email, country, city and more</p>
                    </div>
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image Tag</th>
                                        <th>Image</th>
                                        <th>Link 1</th>
                                        <th>Link 2</th>
                                        <th>Modified By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($galleries as $gallery)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $gallery->image_tag }}
                                            </td>
                                            <td>
                                                <span class="list-img">
                                                    <img src="{{ asset('storage/' . $gallery->image) }}" alt="">
                                                </span>
                                            </td>
                                            <td>{{ $gallery->date }}</td>
                                            <td>{{ $gallery->location }}</td>
                                            <td>
                                                <span class="label label-success">{{ $gallery->user->name }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.gallery.edit', [$gallery->id]) }}"
                                                    class="ad-st-view">Edit</a>
                                                    @if(auth()->user()->can('Read and Write'))
                                                <form action="{{ route('admin.gallery.delete', [$gallery->id]) }}"
                                                    method="POST">
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
