    <!--HEADER SECTION-->
    <section>
        <!-- TOP BAR -->
        <div class="ed-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ed-com-t1-left">
                            <ul>
                                <li>
                                    <a href="/contact">Address: No.1, Dawnabwar Block, Aungmyaythazan Tsp, Mandalay,
                                Myanmar</a>
                                </li>
                                <li>
                                    <a href="mailto:piu.edu2014@gmail.com">Email: piu.edu2014@gmail.com</a>
                                </li>
                                <li>
                                    <a href="tel:+09-793200074">Phone: +09-793200074</a>
                                </li>
                            </ul>
                        </div>
                        @guest
                        <div class="ed-com-t1-right">
                            <ul>
                                <li><a href="#!" data-toggle="modal" data-target="#modal1">Sign In</a>
                                </li>
                                <li><a href="#!" data-toggle="modal" data-target="#modal2">Sign Up</a>
                                </li>
                            </ul>
                        </div>
                        @endguest
                        @auth
                        <div class="ed-com-t1-right">
                            <ul>
                                <li><a href="{{ route('admin.user.profile.edit', ['user' => auth()->user()->id]) }}">Profile</a>
                                </li>
                                <li>
                                    <form action="{{ route('admin.auth.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @endauth
                        <div class="ed-com-t1-social">
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                </li>
                                <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                                </li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- LOGO AND MENU SECTION -->
        <div class="top-logo" data-spy="affix" data-offset-top="250">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="wed-logo">
                            <a href="/"><img src="images/PIU-logo.png" alt="" />
                            </a>
                        </div>
                        <div class="main-menu">
                            <ul>
                                <li><a href="/">Home</a>
                                </li>
                                <li class="about-menu">
                                    <a href="/about-us" class="mm-arr">About us</a>
                                    <!-- MEGA MENU 1 -->
                                    <div class="mm-pos">
                                        <div class="about-mm m-menu">
                                            <div class="m-menu-inn">
                                                <div class="mm1-com mm1-s1">
                                                    <div class="ed-course-in">
                                                        <a class="course-overlay menu-about" href="/piu/admission/application-form">
                                                            <img src="images/h-about.jpg" alt="">
                                                            <span>Academics</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="mm1-com mm1-s2">
                                                    <p>25th years ago Phaung Daw Oo monastic education school was established by the two brothers, Ven Nayaka and Ven Jotika. During eight years times the school has been developed from primary to high school level: In 1993 Primary, In 1998 Secondary, In 2000 High School. </p>
                                                    <a href="/about-us" class="mm-r-m-btn">Read more</a>
                                                </div>
                                                <div class="mm1-com mm1-s3">
                                                    <ul>
                                                        <li><a href="/courses">Faculties</a></li>
                                                        <li><a href="/about-us">About</a></li>
                                                        <li><a href="/news">News</a></li>
                                                        <li><a href="/seminars">Seminars</a></li>
                                                        <li><a href="/events">Events</a></li>
                                                    </ul>
                                                </div>
                                                <div class="mm1-com mm1-s4">
                                                    <ul>
                                                        <li><a href="#!">Student Reviews</a></li>
                                                        <li><a href="#!">Blogs</a></li>
                                                        <li><a href="#!">Supports</a></li>
                                                        <li><a href="/teams">Teams</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="admi-menu">
                                    <a href="/piu/admission/application-form" class="mm-arr">Admission</a>
                                    <!-- MEGA MENU 1 -->
                                    <div class="mm-pos">
                                        <div class="admi-mm m-menu">
                                            <div class="m-menu-inn">
                                                <div class="mm2-com mm1-com mm1-s1">
                                                    <div class="ed-course-in">
                                                        <a class="course-overlay" href="about.html">
                                                            <img src="images/h-about1.jpg" alt="">
                                                            <span>Academics</span>
                                                        </a>
                                                    </div>
                                                    <p>Donec lacus libero, rutrum ac sollicitudin sed, mattis non eros. Vestibulum congue nec eros quis lacinia. Mauris non tincidunt lectus. Nulla mollis, orci vitae accumsan rhoncus.</p>
                                                    <a href="about.html" class="mm-r-m-btn">Read more</a>
                                                </div>
                                                <div class="mm2-com mm1-com mm1-s1">
                                                    <div class="ed-course-in">
                                                        <a class="course-overlay" href="/piu/admission/application-form">
                                                            <img src="images/h-adm1.jpg" alt="">
                                                            <span>Admission</span>
                                                        </a>
                                                    </div>
                                                    <p>Donec lacus libero, rutrum ac sollicitudin sed, mattis non eros. Vestibulum congue nec eros quis lacinia. Mauris non tincidunt lectus. Nulla mollis, orci vitae accumsan rhoncus.</p>
                                                    <a href="/piu/admission/application-form" class="mm-r-m-btn">Read more</a>
                                                </div>
                                                <div class="mm2-com mm1-com mm1-s1">
                                                    <div class="ed-course-in">
                                                        <a class="course-overlay" href="awards.html">
                                                            <img src="images/h-cam1.jpg" alt="">
                                                            <span>History & awards</span>
                                                        </a>
                                                    </div>
                                                    <p>Donec lacus libero, rutrum ac sollicitudin sed, mattis non eros. Vestibulum congue nec eros quis lacinia. Mauris non tincidunt lectus. Nulla mollis, orci vitae accumsan rhoncus.</p>
                                                    <a href="awards.html" class="mm-r-m-btn">Read more</a>
                                                </div>
                                                <div class="mm2-com mm1-com mm1-s4">
                                                    <div class="ed-course-in">
                                                        <a class="course-overlay" href="seminar.html">
                                                            <img src="images/h-res1.jpg" alt="">
                                                            <span>Seminar 2018</span>
                                                        </a>
                                                    </div>
                                                    <p>Donec lacus libero, rutrum ac sollicitudin sed, mattis non eros. Vestibulum congue nec eros quis lacinia. Mauris non tincidunt lectus. Nulla mollis, orci vitae accumsan rhoncus.</p>
                                                    <a href="seminar.html" class="mm-r-m-btn">Read more</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </li>
                                </li>
                                <li><a href="/contact">Contact us</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="all-drop-down-menu">

                    </div>

                </div>
            </div>
        </div>
    </section>
    <!--END HEADER SECTION-->