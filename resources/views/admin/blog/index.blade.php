<x-admin_layout>
    <div class="sb2-2-2">
        <ul>
            <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li class="active-bre"><a href="#"> Dashboard</a>
            </li>
            @if (auth()->user()->can('Read and Write') ||
                    auth()->user()->can('Write Only'))
                <li class="page-back"><a href="/admin/blogs/create"><i class="fa fa-plus" aria-hidden="true"></i> New
                        Blog</a>
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
                        <h4>blog Details</h4>
                        <p>All about blogs, program structure, fees, best blog lists (ranking), syllabus, teaching
                            techniques and other details.</p>
                    </div>
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Blog Title</th>
                                        <th>By</th>
                                        @if (auth()->user()->can('Read and Write') ||
                                            auth()->user()->can('Write') ||
                                            auth()->user()->can('Manager'))
                                        <th>Active</th>
                                        <th>View</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($blogs as $blog)
                                        <tr>
                                            <td>
                                                <span class="list-img">
                                                    <img src="{{ asset('storage/' . $blog->image) }}" alt="">
                                                </span>
                                            </td>
                                            <td>
                                              <span class="list-enq-name">{{ $blog->title }}</span>
                                            </td>
                                            <td>
                                                {{ optional($blog->user)->name }}
                                            </td>
                                            @if (auth()->user()->can('Read and Write') ||
                                            auth()->user()->can('Write') ||
                                            auth()->user()->can('Manager'))
                                            <td>
                                                <form method="POST"
                                                    action="/admin/blogs/{{ $blog->id }}/isActive">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="is_active"
                                                            id="isActive_{{ $blog->id }}" role="switch"
                                                            {{ $blog->is_active ? 'checked' : '' }}
                                                            onchange="this.form.submit()">
                                                        <label
                                                            class="form-check-label"for="isActive_{{ $blog->id }}"></label>
                                                    </div>
                                                </form>
                                            </td>
                                            @endif
                                            <td>
                                                @if (auth()->user()->can('Read and Write') ||
                                                    auth()->user()->can('Write') ||
                                                    auth()->user()->can('Manager'))
                                                <a href="{{ route('admin.blog.edit', [$blog->id]) }}"
                                                    class="ad-st-view">Edit</a>
                                                    @endif
                                                @if (auth()->user()->can('Read and Write'))
                                                    <form action="{{ route('admin.blog.delete', [$blog->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="ad-st-view">Delete</button>
                                                    </form>
                                                @endif
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
