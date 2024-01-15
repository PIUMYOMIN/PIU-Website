<x-admin_layout>
    <div class="sb2-2-2">
        <ul>
            <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li class="active-bre"><a href="#"> Curriculums</a>
            </li>
            <li class="page-back">
                <a href="/admin/curriculum/create"><i class="fa fa-plus" aria-hidden="true"></i> Add Curriculums</a>
            </li>
        </ul>
    </div>
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <h4>Curriculums</h4>
                        <p>All about students like name, student id, phone, email, country, city and more</p>
                    </div>
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Course</th>
                                        <th>Year</th>
                                        <th>Module Code</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($curriculums as $curriculum)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $curriculum->title }}</td>
                                            <td>{{ Str::limit($curriculum->description, 35, '...') }}</td>
                                            <td>{{ $curriculum->course->title }}</td>
                                            <td>{{ $curriculum->year->name }}</td>
                                            <td>{{ $curriculum->module->module_code }}</td>
                                            <td>
                                                <a href="curriculums/{{ $curriculum->id }}/edit" class="ad-st-view">Edit</a>
                                                <form action="curriculums/{{ $curriculum->id }}/delete" method="POST">
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
