<x-admin_layout>
  <div class="sb2-2-2">
                    <ul>
                        <li><a href="/admin"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                        </li>
                        <li class="active-bre"><a href="/admin/seminars"> Seminars</a>
                        </li>
                        <li class="page-back"><a href="/admin/seminar/create"><i class="fa fa-plus" aria-hidden="true"></i> Add Seminar</a>
                        </li>
                    </ul>
                </div>

                <!--== User Details ==-->
                <div class="sb2-2-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-inn-sp">
                                <div class="inn-title">
									<h4>All Seminars</h4>
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
                                                    <th>Start Date</th>
													                          <th>Location</th>
													                          <th>Modified By</th>
													                          <th>Edit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($seminars as $seminar) 
                                                  <tr>
                                                      <td>{{ $loop->iteration }}</td>
                                                      <td>
                                                        <span class="list-img">
                                                          <img src="{{ asset('storage/'.$seminar->image) }}" alt="">
                                                        </span>
                                                      </td>
  													                          <td>
                                                        <a href="/seminars/{{ $seminar->slug }}">
                                                          {{ $seminar->name }}
                                                        </a>
                                                      </td>
                                                      <td>{{ $seminar->date }}</td>
  													                          <td>{{ $seminar->location }}</td>
                                                      <td>
                                                          <span class="label label-success">{{ $seminar->user->name }}</span>
                                                      </td>
  													                          <td>
                                                        <a href="{{ route('admin.seminar.edit',[$seminar->id]) }}" class="ad-st-view">Edit</a>
                                                        @if (auth()->user()->can('Read and Write'))
                                                        <form action="{{ route('admin.seminar.delete',[$seminar->id]) }}" method="POST">
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