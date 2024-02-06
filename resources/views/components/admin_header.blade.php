<!--== MAIN CONTRAINER ==-->
    <div class="container-fluid sb1">
        <div class="row">
            <!--== LOGO ==-->
            <div class="col-md-2 col-sm-3 col-xs-6 sb1-1">
                <a href="#" class="btn-close-menu"><i class="fa fa-times" aria-hidden="true"></i></a>
                <a href="#" class="atab-menu"><i class="fa fa-bars tab-menu" aria-hidden="true"></i></a>
                <a href="/" class="logo"><img src="{{ asset('images/logo1.png') }}" alt="" />
                </a>
            </div>
            <!--== SEARCH ==-->
            <div class="col-md-6 col-sm-6 mob-hide">
                <form class="app-search">
                    <input type="text" placeholder="Search..." class="form-control">
                    <a href="#"><i class="fa fa-search"></i></a>
                </form>
            </div>
            <!--== NOTIFICATION ==-->
            <div class="col-md-2 tab-hide">
                <div class="top-not-cen">
                    <a class='waves-effect btn-noti' href="admin-all-enquiry.html" title="all enquiry messages"><i class="fa fa-commenting-o" aria-hidden="true"></i><span>5</span></a>
                    <a class='waves-effect btn-noti' href="admin-course-enquiry.html" title="course booking messages"><i class="fa fa-envelope-o" aria-hidden="true"></i><span>5</span></a>
                    <a class='waves-effect btn-noti' href="admin-admission-enquiry.html" title="admission enquiry"><i class="fa fa-tag" aria-hidden="true"></i><span>5</span></a>
                </div>
            </div>
            <!--== MY ACCCOUNT ==-->
            <div class="col-md-2 col-sm-3 col-xs-6">
                <!-- Dropdown Trigger -->
                @if (auth()->check()) 
                    <a class='waves-effect dropdown-button top-user-pro' href='#' data-activates='top-menu'><img src="{{ auth()->user()->profile }}" alt="" />My Account <i class="fa fa-angle-down" aria-hidden="true"></i>
                    </a>
                @elseif(auth()->guard('student')->check())
                <a class='waves-effect dropdown-button top-user-pro' href='#' data-activates='top-menu'><img src="{{ auth()->guard('student')->user()->profile }}" alt="" />My Account <i class="fa fa-angle-down" aria-hidden="true"></i>
                </a>
                @endif

                <!-- Dropdown Structure -->
                <ul id='top-menu' class='dropdown-content top-menu-sty'>
                    <li>
                        @if (auth()->check()) 
                            <a href="{{ route('admin.user.profile.edit', ['user' => auth()->user()->id]) }}" class="waves-effect">
                        @elseif(auth()->guard('student')->check())
                            <a href="{{ route('admin.student.profile.edit', ['student' => auth()->guard('student')->user()->id]) }}" class="waves-effect">
                        @endif
                        <i class="fa fa-cogs" aria-hidden="true"></i> Profile Setting
                        </a>
                    </li>
                    <li class="divider"></li>
                    @if (auth()->check())
                        <li>
                            <form action="{{ route('admin.auth.logout') }}" method="POST">
                                @csrf
                                <button class="ho-dr-con-last waves-effect btn-link"><i class="fa fa-sign-in" aria-hidden="true"></i> Logout</button>
                            </form>
                        </li>
                    @elseif(auth()->guard('student')->check())
                        <li>
                            <form action="{{ route('admin.student.logout') }}" method="POST">
                                @csrf
                                <button class="ho-dr-con-last waves-effect btn-link"><i class="fa fa-sign-in" aria-hidden="true"></i> Logout</button>
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>