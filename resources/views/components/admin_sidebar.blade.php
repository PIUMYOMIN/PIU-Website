<div class="sb2-1">
    <!--== USER INFO ==-->
    <div class="sb2-12">
        <ul>
            <li>
                <img src="{{ auth()->user()->profile }}" alt="">
            </li>
            <li>
                <h5>{{ auth()->user()->name }} <span> {{ auth()->user()->city }}, {{ auth()->user()->country }}</span>
                </h5>
            </li>
            <li></li>
        </ul>
    </div>
    <!--== LEFT MENU ==-->
    <div class="sb2-13">
        <ul class="collapsible" data-collapsible="accordion">
            <li><a href="admin.html" class="menu-active"><i class="fa fa-bar-chart" aria-hidden="true"></i> Dashboard</a>
            </li>
            <li>
                <a href="{{ route('admin.user.profile.edit', ['user' => auth()->user()->id]) }}"><i class="fa fa-cogs"
                        aria-hidden="true"></i> Profile Setting</a>
            </li>
            <li>
                <a href="{{ route('admin.user.password-change',['user' => auth()->user()->id]) }}"><i class="fa fa-key" aria-hidden="true"></i> Change Password</a>
            </li>
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
                    auth()->user()->can('Write') ||
                    auth()->user()->can('Manager'))
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
                                    <a href="/admin/course/create">Add New Course</a>
                                </li>
                                <li>
                                    <a href="/admin/course-categories">Course Category</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
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
                <li><a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-bars"
                            aria-hidden="true"></i>
                        Menu</a>
                    <div class="collapsible-body left-sub-menu">
                        <ul>
                            <li><a href="admin-main-menu.html">Main menu</a></li>
                            <li><a href="admin-about-menu.html">About menu</a></li>
                            <li><a href="admin-admission-menu.html">Admission menu</a></li>
                            <li><a href="admin-all-menu.html">All page menu</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="/admin/slides"><i class="fa fa-image" aria-hidden="true"></i> Slider</a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-calendar"
                            aria-hidden="true"></i> Events</a>
                    <div class="collapsible-body left-sub-menu">
                        <ul>
                            <li>
                                <a href="/admin/events">All Events</a>
                            </li>
                            <li>
                                <a href="/admin/events/create">Create New Events</a>
                            <li>
                                <a href="/admin/event-enquiry">Event Enquiry</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li><a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-cloud-download"
                            aria-hidden="true"></i> Import & Export</a>
                    <div class="collapsible-body left-sub-menu">
                        <ul>
                            <li><a href="admin-export-data.html">Export all datas</a>
                            </li>
                            <li><a href="admin-import-data.html">Import all datas</a>
                            </li>
                        </ul>
                    </div>
                </li>
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
            auth()->user()->can('Write') ||
            auth()->user()->can('Manager'))
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
                            <li><a href="admin-job-all.html">All Jobs</a>
                            </li>
                            <li><a href="admin-job-add.html">Create New Job</a>
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
                            <li><a href="admin-user-all.html">All Students</a>
                            </li>
                            <li><a href="admin-user-add.html">Add New Students</a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
        </ul>
    </div>
</div>
