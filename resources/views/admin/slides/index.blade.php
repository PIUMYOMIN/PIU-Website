<x-admin_layout>
    <div class="sb2-2-2">
        <ul>
            <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li class="active-bre"><a href="#"> Slider</a>
            </li>
            <li class="page-back">
                <a href="{{ route('admin.slides.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Add Slide</a>
            </li>
        </ul>
    </div>
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <h4>Home Page Slider</h4>
                        <p>All about students like name, student id, phone, email, country, city and more</p>
                    </div>
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Slider image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>By</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($slides as $slide)
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <span class="list-img">
                                                    <img src="{{ asset('storage/' . $slide->slide_image) }}"
                                                        alt="">
                                                </span>
                                            </td>
                                            <td>{{ $slide->title }}</td>
                                            <td>{{ Str::limit($slide->description, 20, '...') }}</td>
                                            <td>{{ $slide->user->name }}</td>
                                            <td>
                                                <form method="POST"
                                                    action="{{ route('admin.slide.isActive', ['slide' => $slide->id]) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="is_active"
                                                            id="isActive_{{ $slide->id }}" role="switch"
                                                            {{ $slide->is_active ? 'checked' : '' }}
                                                            onchange="this.form.submit()">
                                                        <label class="form-check-label"
                                                            for="isActive_{{ $slide->id }}">Active/Inactive</label>
                                                    </div>
                                                </form>
                                            </td>

                                            <td>
                                                <a href="slides/{{ $slide->id }}/edit" class="ad-st-view">Edit</a>
                                                <form action="slides/{{ $slide->id }}/delete" method="POST">
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
