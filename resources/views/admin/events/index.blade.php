<x-admin_layout>
  <div class="sb2-2-2">
                    <ul>
                        <li><a href="/admin"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                        </li>
                        <li class="active-bre"><a href="/admin/events"> Events</a>
                        </li>
                        @if (auth()->user()->can('Read and Write') || 
                        auth()->user()->can('Write Only'))
                            <li class="page-back"><a href="/admin/event/create"><i class="fa fa-plus" aria-hidden="true"></i> Add Event</a>
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
									<h4>All Events</h4>
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
                                                @foreach ($events as $event) 
                                                  <tr>
                                                      <td>{{ $loop->iteration }}</td>
                                                      <td>
                                                        <span class="list-img">
                                                          <img src="{{ asset('storage/'.$event->image) }}" alt="">
                                                        </span>
                                                      </td>
  													                          <td>
                                                        <a href="/events/{{ $event->slug }}">
                                                          {{ $event->name }}
                                                        </a>
                                                      </td>
                                                      <td>{{ $event->date }}</td>
  													                          <td>{{ $event->location }}</td>
                                                      <td>
                                                          <span class="label label-success">{{ $event->user->name }}</span>
                                                      </td>
  													                          <td>
                                                        <a href="{{ route('admin.event.edit',[$event->id]) }}" class="ad-st-view">Edit</a>
                                                        <form action="{{ route('admin.event.delete',[$event->id]) }}" method="POST">
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