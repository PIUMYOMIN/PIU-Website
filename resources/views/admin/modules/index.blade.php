<x-admin_layout>
    <div class="sb2-2-2">
        <ul>
            <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li class="active-bre"><a href="#"> Modules</a>
            </li>
            @if (auth()->user()->can('Read and Write')||
                auth()->user()->can('Write') ||
                auth()->user()->can('Manager')||
                auth()->user()->can('Registrar'))
            <li class="page-back">
                <a href="/admin/module/create"><i class="fa fa-plus" aria-hidden="true"></i> Add module</a>
            </li>
            @endif
        </ul>
    </div>
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <h4>Modules</h4>
                        <p>All about students like name, student id, phone, email, country, city and more</p>
                    </div>
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Module Code</th>
                                        <th>Credit</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($modules as $module)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $module->name }}</td>
                                            <td>{{ $module->module_code }}</td>
                                            <td>{{ $module->credit }}</td>
                                            <td>
                                                <a href="/admin/module/{{ $module->id }}/edit" class="ad-st-view">Edit</a>
                                                @if (auth()->user()->can('Read and Write'))
                                                <form action="/admin/module/{{ $module->id }}/delete" method="POST">
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
