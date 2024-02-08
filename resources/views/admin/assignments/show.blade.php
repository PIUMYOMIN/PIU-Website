<x-admin_layout>
    <div class="sb2-2-2">
        <ul>
            <li>
              <a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li class="active-bre">
              <a href="#"> {{ $assignment->slug }}</a>
            </li>
            <li class="page-back">
              <a href="/admin"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
            </li>
        </ul>
    </div>

    <!--== User Details ==-->
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <h4>{{ $assignment->name }}</h4>
                        <p>All about students like name, student id, phone, email, country, city and more</p>
                    </div>
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                          <p>
                            {{ $assignment->description }}
                            @if ($assignment->attach_file)
                              <div>
                                <a href="{{ asset('storage/'.$assignment->attach_file) }}" class="" download>
                                  Download Attach File
                                </a>
                              </div>
                              @endif
                          </p>
                          <div class="text-center">
                            <a href="{{ route('admin.student.assignment.submit',['slug' => $assignment->slug]) }}" class="btn">
                                Turn Your Assignment In
                              </a>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin_layout>
