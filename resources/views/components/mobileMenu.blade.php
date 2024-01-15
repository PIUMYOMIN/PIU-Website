<!-- MOBILE MENU -->
    <section>
        <div class="ed-mob-menu">
            <div class="ed-mob-menu-con">
                <div class="ed-mm-left">
                    <div class="wed-logo">
                        <a href="index-2.html"><img src="images/logo.png" alt="" />
						</a>
                    </div>
                </div>
                <div class="ed-mm-right">
                    <div class="ed-mm-menu">
                        <a href="#!" class="ed-micon"><i class="fa fa-bars"></i></a>
                        <div class="ed-mm-inn">
                            <a href="#!" class="ed-mi-close"><i class="fa fa-times"></i></a>
                            <h4>All Courses</h4>
                            @foreach ($courses as $course) 
                                <ul>
                                    <li><a href="/courses/{{ $course->slug }}">{{ $course->title }}</a></li>
                                </ul>
                            @endforeach

                            <h4>About us</h4>
                            <ul>
                                <li><a href="/about-us">About us</a></li>
                                <li><a href="/news">News</a></li>
                                <li><a href="/evebts">Events</a></li>
                                <li><a href="/seminars">Seminars</a></li>
                                <li><a href="/contact-us">Contact</a></li>
                            </ul>

                            @auth
                            <h4>User Profile</h4>
                                <ul>
                                    <li>
                                        <a href="{{ route('admin.user.profile.edit', ['user' => auth()->user()->id]) }}">User profile</a>
                                    </li>
                                    <li>
                                    <form action="{{ route('admin.auth.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">Logout</button>
                                    </form>
                                </li>
                                </ul>
                            @else
                                <h4>User Account</h4>
                                <ul>
                                    <li><a href="#!" data-toggle="modal" data-target="#modal1">Sign In</a></li>
                                    <li><a href="#!" data-toggle="modal" data-target="#modal2">Register</a></li>
                                </ul>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>