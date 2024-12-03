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
                        @if(auth()->user() || auth()->guard('student')->check())
                        <div class="ed-com-t1-right">
                            @if (auth()->check())
                                <ul>
                                    <li>
                                        <form action="{{ route('admin.auth.logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-secondary">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            @elseif(auth()->guard('student')->check())
                            <ul>
                                <li>
                                    <form action="{{ route('admin.student.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">Logout</button>
                                    </form>
                                </li>
                            </ul>
                            @endif
                        </div>
                        @else
                        <div class="ed-com-t1-right">
                                <ul>
                                    <li><a href="#!" data-toggle="modal" data-target="#modal1">Sign In</a>
                                    </li>
                                    <li><a href="#!" data-toggle="modal" data-target="#modal2">Sign Up</a>
                                    </li>
                                </ul>
                            </div>
                        @endif
                        <div class="ed-com-t1-social">
                            <ul>
                                <li><a href="https://www.facebook.com/PhaungDawOoInternationalUniveristy" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
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
    </section>
    <!--END HEADER SECTION-->
