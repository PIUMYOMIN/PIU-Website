<x-admin_layout>
    <div class="sb2-2-2">
        <ul>
            <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li class="active-bre"><a href="#"> MOU Partner</a>
            </li>
            <li class="page-back">
                <a href="{{ route('admin.partner.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> New Partner</a>
            </li>
        </ul>
    </div>
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <h4>Home Page Partner</h4>
                        <p>All about students like name, student id, phone, email, country, city and more</p>
                    </div>
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Web Address</th>
                                        <th>Description</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($partners as $partner)
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <span class="list-img">
                                                    <img src="{{ asset('storage/' . $partner->image) }}"
                                                        alt="">
                                                </span>
                                            </td>
                                            <td>{{ $partner->name }}</td>
                                            <td>{{ $partner->web_address }}</td>
                                            <td>{{ Str::limit($partner->description, 20, '...') }}</td>
                                            <td>
                                                <a href="{{ route('admin.partner.edit',$partner->id) }}" class="ad-st-view">Edit</a>
                                                <form action="{{ route('admin.partner.delete',[$partner->id]) }}" method="POST">
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
