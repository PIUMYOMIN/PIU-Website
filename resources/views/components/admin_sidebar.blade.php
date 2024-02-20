<div class="sb2-1">
    <!--== USER INFO ==-->
    <div class="sb2-12">
        <ul>
            @if (auth()->check()) 
                <li>
                    <img src="{{ auth()->user()->profile }}" alt="">
                </li>
                <li>
                    <h5>{{ auth()->user()->name }} <span> {{ auth()->user()->city }}, {{ auth()->user()->country }}</span>
                    </h5>
                </li>
            @elseif(auth()->guard('student')->check())
            <li>
                <img src="{{ auth()->guard('student')->user()->profile }}" alt="">
            </li>
            <li>
                <h5>{{ auth()->guard('student')->user()->fname }} {{ auth()->guard('student')->user()->lname }} <span> {{ auth()->guard('student')->user()->city }}, {{ auth()->guard('student')->user()->country }}</span>
                </h5>
            </li>
            @endif
        </ul>
    </div>
    <!--== LEFT MENU ==-->
    <div class="sb2-13">
        <ul class="collapsible" data-collapsible="accordion">
            @if (auth()->check()) 
                <li>
                    <a href="/admin" class="menu-active"><i class="fa fa-bar-chart" aria-hidden="true"></i> Dashboard</a>
                </li>
            @endif
            @if (auth()->check()) 
                <li>
                    <a href="{{ route('admin.users.profile.edit', ['user' => auth()->user()->id]) }}"><i class="fa fa-cogs"
                            aria-hidden="true"></i> Profile Setting</a>
                </li>
                <li>
                <a href="{{ route('admin.users.password-change', ['user' => auth()->user()->id]) }}"><i class="fa fa-key"
                        aria-hidden="true"></i> Change Password</a>
            </li>
            @elseif(auth()->guard('student')->check())
            {{-- <li>
                <a href="{{ route('admin.student.profile.edit', ['student' => auth()->guard('student')->user()->id]) }}"><i class="fa fa-cogs"
                        aria-hidden="true"></i> Profile Setting</a>
            </li>
            <li>
                <a href="{{ route('admin.student.profile.password-change', ['student' => auth()->guard('student')->user()->id]) }}"><i class="fa fa-key"
                        aria-hidden="true"></i> Change Password</a>
            </li> --}}
            @endif
            @if (auth()->check())
                @if (auth()->user()->can('Read and Write'))
                <li>
                    <a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-users"
                            aria-hidden="true"></i>
                        Users</a>
                    <div class="collapsible-body left-sub-menu">
                        <ul>
                            <li>
                                <a href="/admin/users">All Users</a>
                            </li>
                            @can('Read and Write')
                                <li>
                                    <a href="/admin/roles">User Roles</a>
                                </li>
                                <li>
                                    <a href="/admin/permissions">User Permissions</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endif
            @if (auth()->user()->can('Read and Write') ||
                    auth()->user()->can('Read') ||
                    auth()->user()->can('Registrar'))
                <li>
                    <a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-book"
                            aria-hidden="true"></i>
                        Admission</a>
                    <div class="collapsible-body left-sub-menu">
                        <ul>
                            <li>
                                <a href="/admin/admission/application-forms">Application Forms</a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if (auth()->user()->can('Read and Write') ||
                    auth()->user()->can('Read') ||
                    auth()->user()->can('Write'))
                <li>
                    <a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-book"
                            aria-hidden="true"></i>
                        All Courses</a>
                    <div class="collapsible-body left-sub-menu">
                        <ul>
                            <li>
                                <a href="/admin/courses">All Course</a>
                            </li>
                            @if (auth()->user()->can('Read and Write') ||
                                    auth()->user()->can('Write') ||
                                    auth()->user()->can('Manager'))
                                <li>
                                    <a href="/admin/courses/create">Add New Course</a>
                                </li>
                                <li>
                                    <a href="/admin/course-categories">Course Category</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @if (auth()->user()->can('Read and Write') ||
                        auth()->user()->can('Write') ||
                        auth()->user()->can('Read') ||
                        auth()->user()->can('Manager'))
                    <li>
                        <a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-bookmark-o"
                                aria-hidden="true"></i>All News</a>
                        <div class="collapsible-body left-sub-menu">
                            <ul>
                                <li>
                                    <a href="/admin/news">News</a>
                                </li>
                                @if (auth()->user()->can('Read and Write') ||
                                        auth()->user()->can('Write') ||
                                        auth()->user()->can('Manager'))
                                    <li>
                                        <a href="/admin/news/create">Create News</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                @if (auth()->user()->can('Read and Write') ||
                        auth()->user()->can('Write') ||
                        auth()->user()->can('Read') ||
                        auth()->user()->can('Manager'))
                    <li>
                        <a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-bookmark-o"
                                aria-hidden="true"></i>Course Modules</a>
                        <div class="collapsible-body left-sub-menu">
                            <ul>
                                <li>
                                    <a href="/admin/modules">Modules</a>
                                </li>
                                @if (auth()->user()->can('Read and Write') ||
                                        auth()->user()->can('Write') ||
                                        auth()->user()->can('Manager'))
                                    <li>
                                        <a href="/admin/module/create">Add New Module</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                @if (auth()->user()->can('Read and Write') ||
                        auth()->user()->can('Write') ||
                        auth()->user()->can('Read') ||
                        auth()->user()->can('Manager'))
                    <li>
                        <a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-bookmark-o"
                                aria-hidden="true"></i>Curriculums</a>
                        <div class="collapsible-body left-sub-menu">
                            <ul>
                                <li>
                                    <a href="/admin/curriculums">Modules</a>
                                </li>
                                @if (auth()->user()->can('Read and Write') ||
                                        auth()->user()->can('Write') ||
                                        auth()->user()->can('Manager'))
                                    <li>
                                        <a href="/admin/curriculum/create">Add New Curriculum</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                @if (auth()->user()->can('Read and Write') ||
                        auth()->user()->can('Manager'))
                <li><a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-users"
                            aria-hidden="true"></i>
                        Teams</a>
                    <div class="collapsible-body left-sub-menu">
                        <ul>
                            <li><a href="/admin/teams">All Teams</a></li>
                            <li><a href="/admin/team/create">New Team Member</a></li>
                        </ul>
                    </div>
                </li>
                @endif
                <li>
                    <a href="/admin/slides"><i class="fa fa-image" aria-hidden="true"></i> Slider</a>
                </li>
                @if (auth()->user()->can('Read and Write') ||
                    auth()->user()->can('Read') ||
                    auth()->user()->can('Write'))
                <li>
                    <a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-calendar"
                            aria-hidden="true"></i> Events</a>
                    <div class="collapsible-body left-sub-menu">
                        <ul>
                            <li>
                                <a href="/admin/events">All Events</a>
                            </li>
                            <li>
                                <a href="/admin/event/create">Create New Events</a>
                            <li>
                                <a href="/admin/event-enquiry">Event Enquiry</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
            @endif
            @if (auth()->user()->can('Read and Write') ||
                    auth()->user()->can('Read') ||
                    auth()->user()->can('Write') ||
                    auth()->user()->can('Manager'))
                <li>
                    <a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-building"
                            aria-hidden="true"></i>
                        Departments</a>
                    <div class="collapsible-body left-sub-menu">
                        <ul>
                            <li>
                                <a href="/admin/departments">All Departments</a>
                            </li>
                            @if (auth()->user()->can('Read and Write') ||
                                    auth()->user()->can('Write') ||
                                    auth()->user()->can('Manager'))
                                <li>
                                    <a href="/admin/department/create">Add New Department</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif
            @if (auth()->user()->can('Read and Write') ||
                    auth()->user()->can('Read') ||
                    auth()->user()->can('Write') ||
                    auth()->user()->can('Manager'))
                <li>
                    <a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-user"
                            aria-hidden="true"></i>
                        Positions</a>
                    <div class="collapsible-body left-sub-menu">
                        <ul>
                            <li>
                                <a href="/admin/positions">All Positions</a>
                            </li>
                            @if (auth()->user()->can('Read and Write') ||
                                    auth()->user()->can('Write') ||
                                    auth()->user()->can('Manager'))
                                <li>
                                    <a href="/admin/position/create">Add New Position</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif
            @if (auth()->user()->can('Read and Write') ||
                    auth()->user()->can('Read') ||
                    auth()->user()->can('Write'))
                <li><a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-bullhorn"
                            aria-hidden="true"></i> Seminar</a>
                    <div class="collapsible-body left-sub-menu">
                        <ul>
                            <li>
                                <a href="/admin/seminars">All Seminar</a>
                            </li>
                            <li>
                                <a href="/admin/seminar/create">Create New Seminar</a>
                            </li>
                            <li>
                                <a href="/admin/seminar-enquiry">Seminar Enquiry</a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if (auth()->user()->can('Read and Write') ||
                    auth()->user()->can('Manager'))
                <li><a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-pencil"
                            aria-hidden="true"></i>
                        Exam time table</a>
                    <div class="collapsible-body left-sub-menu">
                        <ul>
                            <li><a href="admin-exam-all.html">All Exams</a></li>
                            <li><a href="admin-exam-add.html">Add New Exam</a></li>
                            <li><a href="admin-exam-group-all.html">All Groups</a></li>
                            <li><a href="admin-exam-group-add.html">Create New Groups</a></li>
                        </ul>
                    </div>
                </li>
            @endif
            @if (auth()->user()->can('Read and Write') ||
                    auth()->user()->can('Read') ||
                    auth()->user()->can('Write'))
                <li><a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-image"
                            aria-hidden="true"></i>
                        Gallery</a>
                    <div class="collapsible-body left-sub-menu">
                        <ul>
                            <li>
                                <a href="/admin/galleries">All Gallery Images</a>
                            </li>
                            <li>
                                <a href="/admin/gallery/create">Add New Gallery</a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if (auth()->user()->can('Read and Write') ||
                    auth()->user()->can('Read') ||
                    auth()->user()->can('Write'))
                <li><a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-graduation-cap"
                            aria-hidden="true"></i> Job Vacants</a>
                    <div class="collapsible-body left-sub-menu">
                        <ul>
                            <li><a href="#!">All Jobs</a>
                            </li>
                            <li><a href="#!">Create New Job</a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if (auth()->user()->can('Read and Write') ||
                    auth()->user()->can('Registrar'))
                <li>
                    <a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-users"
                            aria-hidden="true"></i>
                        Students</a>
                    <div class="collapsible-body left-sub-menu">
                        <ul>
                            <li>
                                <a href="/admin/students">All Students</a>
                            </li>
                            <li>
                                <a href="/admin/student/create">Add New Students</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.students.grading.create') }}">Add Student Grading</a>
                            </li>
                            <li>
                                <a href="/admin/students/grading/check">Student Grading</a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if (auth()->user()->can('Read and Write'))
                <li>
                    <a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-commenting-o"
                            aria-hidden="true"></i> Mail Box</a>
                    <div class="collapsible-body left-sub-menu">
                        <ul>
                            <li><a href="/admin/contact-mails">All Contacts</a></li>
                        </ul>
                    </div>
                </li>
            @endif
            @endif
            {{-- @if(auth()->check() && auth()->user()->can('Read and Write') || auth()->guard('student')->check()) --}}
            <li>
                <a href="javascript:void(0)" class="collapsible-header">
                    <i class="fa fa-graduation-cap" aria-hidden="true"></i> Assignments
                </a>
                <div class="collapsible-body left-sub-menu">
                    <ul>
                        <li>
                            <a href="/admin/assignments">All Assignments</a>
                        </li>
                        @if (auth()->guard('student')->user()) 
                            <li>
                                <a href="/admin/student/assignments">Your Assignments</a>
                            </li>
                        @endif
                        @if (auth()->check() && auth()->user()->can('Read and Write'))
                        <li>
                            <a href="/admin/assignment/create">New Assignment</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            {{-- @endif --}}
        </ul>
    </div>
</div>
