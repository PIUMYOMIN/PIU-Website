    <x-admin_layout>
       <!--== breadcrumbs ==-->
                <div class="sb2-2-2">
                    <ul>
                        <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                        </li>
                        <li class="active-bre"><a href="#"> Dashboard</a>
                        </li>
                        <li class="page-back"><a href="/admin"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
                        </li>
                    </ul>
                </div>
                <!--== DASHBOARD INFO ==-->
                <div class="sb2-2-1">
                    <h2>Admin Dashboard</h2>
                    <p>The .table class adds basic styling (light padding and only horizontal dividers) to a table:</p>
                    <div class="db-2">
                        <ul>
                            <li>
                                <div class="dash-book dash-b-1">
                                    <h5>All Courses</h5>
                                    <h4>{{ $course->count() }}</h4>
                                    <a href="/admin/courses">View more</a>
                                </div>
                            </li>
                            <li>
                                <div class="dash-book dash-b-2">
                                    <h5>Admission</h5>
                                    <h4>{{ $admissions->count() }}</h4>
                                    <a href="/admin/admission/application-forms">View more</a>
                                </div>
                            </li>
                            <li>
                                <div class="dash-book dash-b-3">
                                    <h5>Students</h5>
                                    <h4>{{ $student->count() }}</h4>
                                    <a href="/admin/students">View more</a>
                                </div>
                            </li>
                            <li>
                                <div class="dash-book dash-b-4">
                                    <h5>Contact Enquiry</h5>
                                    <h4>{{ $contacts->count() }}</h4>
                                    <a href="/admin/contact-mails">View more</a>
                                </div>
                            </li>
                            {{-- <li>
                                <div class="dash-book dash-b-4">
                                    <h5>Popular Page</h5>
                                    @foreach ($mostVisitedPages as $page)
                                        <h4>{{ $page['url'] }} ({{ $page['pageViews'] }} page views)</h4>
                                    @endforeach

                                </div>
                            </li>
                            <li>
                                <div class="dash-book dash-b-4">
                                    <h5>Most Visited Pages</h5>
                                    @foreach ($visitorPages as $visit)
                                        <h4>{{ $visit['url'] }} ({{ $visit['pageViews'] }} page views)</h4>
                                    @endforeach
                                </div>
                            </li> --}}
                        </ul>
                    </div>
                </div>

                <!--== User Details ==-->
                <div class="sb2-2-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-inn-sp">
                                <div class="inn-title">
                                    <h4>Student Details</h4>
                                    <p>All about students like name, student id, phone, email, country, city and more</p>
                                </div>
                                <div class="tab-inn">
                                    <div class="table-responsive table-desi">
                                        @if (auth()->user()->can('Read and Write'))
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>User</th>
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Email</th>
                                                    <th>Registered By</th>
                                                    <th>Id</th>
                                                    <th>Date of birth</th>
													<th>Status</th>
													<th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($students as $student) 
                                                <tr>
                                                        <td>
                                                            <span class="list-img"><img src="{{ asset('storage/'.$student->profile) }}" alt="">
                                                            </span>
                                                        </td>
                                                        <td><a href="#">
                                                            <span class="list-enq-name">{{ $student->fname }} {{ $student->lname }}</span>
                                                            <span class="list-enq-city">{{ $student->city }}, {{ $student->country }}</span></a>
                                                        </td>
                                                        <td>{{ $student->phone }}</td>
                                                        <td>{{ $student->email }}</td>
                                                        <td>{{ $student->user->name }}</td>
                                                        <td>{{ $student->student_id }}</td>
    													<td>{{$student->dob}}</td>
                                                        <td>
                                                            <span class="label label-success">Active</span>
                                                        </td>
    													<td>
                                                            <a href="{{ route('admin.students.profile.details',$student->id) }}"
                                                        class="ad-st-view">View</a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--== User Details ==-->
                <div class="sb2-2-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-inn-sp">
                                <div class="inn-title">
                                    <h4>Course Details</h4>
                                    <p>All about courses, program structure, fees, best course lists (ranking), syllabus, teaching techniques and other details.</p>
                                </div>
                                <div class="tab-inn">
                                    <div class="table-responsive table-desi">
                                        @if (auth()->user()->can('Read and Write'))
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Course Name</th>
													<th>Category</th>
                                                    <th>Durations</th>
													<th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Total Seats</th>
													<th>Status</th>
													<th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($courses as $course) 
                                                    <tr>
                                                        <td>
                                                            <span class="list-img">
                                                                <img src="{{ asset('storage/'.$course->image) }}" alt="">
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a href="/courses/{{ $course->slug }}"><span class="list-enq-name">{{ $course->title }}</span><span class="list-enq-city">Mandalay, Myanmar</span>
                                                            </a>
                                                        </td>
                                                        <td>{{ optional($course->category)->name }}  </td>
                                                        <td>{{ $course->duration }}</td>
                                                        <td>{{ $course->start_date }}</td>
                                                        <td>{{ $course->end_date }}</td>
    													<td>{{ $course->total_seat }}</td>
                                                        <td>
                                                            <span class="label label-success">Active</span>
                                                        </td>
    													<td><a href="/courses/{{ $course->slug }}" class="ad-st-view">View</a></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sb2-2-3">
                    <div class="row">
                        <!--== Country Campaigns ==-->
                        <div class="col-md-6">
                            <div class="box-inn-sp">
                                <div class="inn-title">
                                    <h4>Job Openings</h4>
                                    <p>Randomised words which don't look even slightly believable. If you are going to use a passage</p>
                                </div>
                                <div class="tab-inn">
                                    <div class="table-responsive table-desi">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Company</th>
                                                    <th>Openings</th>
                                                    <th>Date</th>
                                                    <th>Location</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><span class="txt-dark weight-500">Samsing</span>
                                                    </td>
                                                    <td>50</td>
                                                    <td>15 April 2018</td>
                                                    <td>New york, United States</td>
                                                    <td>
                                                        <span class="label label-success">Active</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="txt-dark weight-500">Microsofts</span>
                                                    </td>
                                                    <td>75</td>
                                                    <td>21 Jun 2018</td>
                                                    <td>New york, United States</td>
                                                    <td>
                                                        <span class="label label-success">Active</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="txt-dark weight-500">Samsing</span>
                                                    </td>
                                                    <td>50</td>
                                                    <td>15 April 2018</td>
                                                    <td>United States</td>
                                                    <td>
                                                        <span class="label label-success">Active</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="txt-dark weight-500">Microsofts</span>
                                                    </td>
                                                    <td>75</td>
                                                    <td>21 Jun 2018</td>
                                                    <td>United States</td>
                                                    <td>
                                                        <span class="label label-success">Active</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--== Country Campaigns ==-->
                        <div class="col-md-6">
                            <div class="box-inn-sp">
                                <div class="inn-title">
                                    <h4>Event Details</h4>
                                    <p>Education is about teaching, learning skills and knowledge.</p>
                                </div>
                                <div class="tab-inn">
                                    <div class="table-responsive table-desi">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>State</th>
                                                    <th>Client</th>
                                                    <th>Changes</th>
                                                    <th>Budget</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><span class="txt-dark weight-500">California</span>
                                                    </td>
                                                    <td>Beavis</td>
                                                    <td><span class="txt-success"><i class="fa fa-angle-up" aria-hidden="true"></i><span>2.43%</span></span>
                                                    </td>
                                                    <td>
                                                        <span class="txt-dark weight-500">$1478</span>
                                                    </td>
                                                    <td>
                                                        <span class="label label-success">Active</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="txt-dark weight-500">Florida</span>
                                                    </td>
                                                    <td>Felix</td>
                                                    <td><span class="txt-success"><i class="fa fa-angle-up" aria-hidden="true"></i><span>1.43%</span></span>
                                                    </td>
                                                    <td>
                                                        <span class="txt-dark weight-500">$951</span>
                                                    </td>
                                                    <td>
                                                        <span class="label label-danger">Closed</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="txt-dark weight-500">Hawaii</span>
                                                    </td>
                                                    <td>Cannibus</td>
                                                    <td><span class="txt-danger"><i class="fa fa-angle-up" aria-hidden="true"></i><span>-8.43%</span></span>
                                                    </td>
                                                    <td>
                                                        <span class="txt-dark weight-500">$632</span>
                                                    </td>
                                                    <td>
                                                        <span class="label label-default">Hold</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="txt-dark weight-500">Alaska</span>
                                                    </td>
                                                    <td>Neosoft</td>
                                                    <td><span class="txt-success"><i class="fa fa-angle-up" aria-hidden="true"></i><span>7.43%</span></span>
                                                    </td>
                                                    <td>
                                                        <span class="txt-dark weight-500">$325</span>
                                                    </td>
                                                    <td>
                                                        <span class="label label-default">Hold</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="txt-dark weight-500">New Jersey</span>
                                                    </td>
                                                    <td>Hencework</td>
                                                    <td><span class="txt-success"><i class="fa fa-angle-up" aria-hidden="true"></i><span>9.43%</span></span>
                                                    </td>
                                                    <td>
                                                        <span>$258</span>
                                                    </td>
                                                    <td>
                                                        <span class="label label-success">Active</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
                <div class="sb2-2-3">
                    <div class="row">
                        <!--== Listing Enquiry ==-->
                        <div class="col-md-12">
                            <div class="box-inn-sp">
                                <div class="inn-title">
                                    <h4>Exam Time Tables</h4>
                                    <p>Education is about teaching, learning skills and knowledge.</p>
                                </div>
                                <div class="tab-inn">
                                    <div class="table-responsive table-desi">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Select</th>
													<th>Degree</th>
                                                    <th>Exam Name</th>
                                                    <th>Start Date</th>
													<th>End Date</th>
                                                    <th>Timing</th>
                                                    <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="filled-in" id="filled-in-box-1" checked="checked" />
                                                        <label for="filled-in-box-1"></label>
                                                    </td>
													<td>MBA</td>
                                                    <td><span class="list-enq-name">Civil engineering</span><span class="list-enq-city">Illunois, United States</span>
                                                    </td>
                                                    <td>10:00am</td>
													<td>01:00pm</td>
                                                    <td>03:00Hrs</td>
                                                    <td>
                                                        <a href="admin-exam.html" class="ad-st-view">View</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="filled-in" id="filled-in-box-2" />
                                                        <label for="filled-in-box-2"></label>
                                                    </td>
													<td>MBA</td>
                                                    <td><span class="list-enq-name">Google Business</span><span class="list-enq-city">Illunois, United States</span>
                                                    </td>
                                                    <td>10:00am</td>
													<td>01:00pm</td>
                                                    <td>03:00Hrs</td>
                                                    <td>
                                                        <a href="admin-exam.html" class="ad-st-view">View</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="filled-in" id="filled-in-box-3"/>
                                                        <label for="filled-in-box-3"></label>
                                                    </td>
													<td>MBA</td>
                                                    <td><span class="list-enq-name">Statistics</span><span class="list-enq-city">Illunois, United States</span>
                                                    </td>
                                                    <td>10:00am</td>
													<td>01:00pm</td>
                                                    <td>03:00Hrs</td>
                                                    <td>
                                                        <a href="admin-exam.html" class="ad-st-view">View</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="filled-in" id="filled-in-box-4"/>
                                                        <label for="filled-in-box-4"></label>
                                                    </td>
													<td>MBA</td>
                                                    <td><span class="list-enq-name">Business Management</span><span class="list-enq-city">Illunois, United States</span>
                                                    </td>
                                                    <td>10:00am</td>
													<td>01:00pm</td>
                                                    <td>03:00Hrs</td>
                                                    <td>
                                                        <a href="admin-exam.html" class="ad-st-view">View</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="filled-in" id="filled-in-box-5"/>
                                                        <label for="filled-in-box-5"></label>
                                                    </td>
													<td>MBA</td>
                                                    <td><span class="list-enq-name">Art/Design</span><span class="list-enq-city">Illunois, United States</span>
                                                    </td>
                                                    <td>10:00am</td>
													<td>01:00pm</td>
                                                    <td>03:00Hrs</td>
                                                    <td>
                                                        <a href="admin-exam.html" class="ad-st-view">View</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--== Latest Activity ==-->
                <div class="sb2-2-3">
                    <div class="row">
                        <!--== Latest Activity ==-->
                        <div class="col-md-6">
                            <div class="box-inn-sp">
                                <div class="inn-title">
                                    <h4>Latest Activity</h4>
                                    <p>Education is about teaching, learning skills and knowledge.</p>
                                </div>
                                <div class="tab-inn list-act-hom">
                                    <ul>
                                        <li class="list-act-hom-con">
                                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                                            <h4><span>12 may, 2017</span> Welcome to Academy</h4>
                                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.</p>
                                        </li>
                                        <li class="list-act-hom-con">
                                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                                            <h4><span>08 Jun, 2017</span> Academy Leadership</h4>
                                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.</p>
                                        </li>
                                        <li class="list-act-hom-con">
                                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                                            <h4><span>27 July, 2017</span> Awards and Achievement</h4>
                                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.</p>
                                        </li>
                                        <li class="list-act-hom-con">
                                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                                            <h4><span>14 Aug, 2017</span> Facilities and Management</h4>
                                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.</p>
                                        </li>
                                        <li class="list-act-hom-con">
                                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                                            <h4><span>24 Sep, 2017</span> Nation award winning 2017</h4>
                                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!--== Social Media ==-->
                        <div class="col-md-6">
                            <div class="box-inn-sp">
                                <div class="inn-title">
                                    <h4>Social Media</h4>
                                    <p>Education is about teaching, learning skills and knowledge.</p>
                                </div>
                                <div class="tab-inn">
                                    <div class="table-responsive table-desi">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Media</th>
                                                    <th>Name</th>
                                                    <th>Share</th>
                                                    <th>Like</th>
                                                    <th>Members</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><span class="list-img"><img src="images/sm/1.png" alt=""></span>
                                                    </td>
                                                    <td><span class="list-enq-name">Linked In</span><span class="list-enq-city">Illunois, United States</span>
                                                    </td>
                                                    <td>15K</td>
                                                    <td>18K</td>
                                                    <td>
                                                        <span class="label label-success">263</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="list-img"><img src="images/sm/2.png" alt=""></span>
                                                    </td>
                                                    <td><span class="list-enq-name">Twitter</span><span class="list-enq-city">Illunois, United States</span>
                                                    </td>
                                                    <td>15K</td>
                                                    <td>18K</td>
                                                    <td>
                                                        <span class="label label-success">263</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="list-img"><img src="images/sm/3.png" alt=""></span>
                                                    </td>
                                                    <td><span class="list-enq-name">Facebook</span><span class="list-enq-city">Illunois, United States</span>
                                                    </td>
                                                    <td>15K</td>
                                                    <td>18K</td>
                                                    <td>
                                                        <span class="label label-success">263</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="list-img"><img src="images/sm/4.png" alt=""></span>
                                                    </td>
                                                    <td><span class="list-enq-name">Google Plus</span><span class="list-enq-city">Illunois, United States</span>
                                                    </td>
                                                    <td>15K</td>
                                                    <td>18K</td>
                                                    <td>
                                                        <span class="label label-success">263</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="list-img"><img src="images/sm/5.png" alt=""></span>
                                                    </td>
                                                    <td><span class="list-enq-name">YouTube</span><span class="list-enq-city">Illunois, United States</span>
                                                    </td>
                                                    <td>15K</td>
                                                    <td>18K</td>
                                                    <td>
                                                        <span class="label label-success">263</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="list-img"><img src="images/sm/6.png" alt=""></span>
                                                    </td>
                                                    <td><span class="list-enq-name">WhatsApp</span><span class="list-enq-city">Illunois, United States</span>
                                                    </td>
                                                    <td>15K</td>
                                                    <td>18K</td>
                                                    <td>
                                                        <span class="label label-success">263</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="list-img"><img src="images/sm/7.png" alt=""></span>
                                                    </td>
                                                    <td><span class="list-enq-name">VK</span><span class="list-enq-city">Illunois, United States</span>
                                                    </td>
                                                    <td>15K</td>
                                                    <td>18K</td>
                                                    <td>
                                                        <span class="label label-success">263</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="list-img"><img src="images/sm/2.png" alt=""></span>
                                                    </td>
                                                    <td><span class="list-enq-name">Twitter</span><span class="list-enq-city">Illunois, United States</span>
                                                    </td>
                                                    <td>15K</td>
                                                    <td>18K</td>
                                                    <td>
                                                        <span class="label label-success">263</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--== User Details ==-->
                <div class="sb2-2-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-inn-sp">
                                <div class="inn-title">
                                    <h4>Google Map</h4>
                                    <p>Education is about teaching, learning skills and knowledge.</p>
                                </div>
                                <div class="tab-inn">
                                    <div class="table-responsive table-desi tab-map">
                                        <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d6172.830896809112!2d96.2747935276627!3d22.088415612497066!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30cb6f89b745f459%3A0x55a960cb1a2c6872!2sPhaung%20Daw%20Oo%20International%20University%20(PIU)!5e0!3m2!1sen!2smm!4v1682138429586!5m2!1sen!2smm"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </x-admin_layout>