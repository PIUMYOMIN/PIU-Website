    <!-- FOOTER -->
    <section class="wed-hom-footer">
        <div class="container">
            <div class="row wed-foot-link">
                <div class="col-md-4 foot-tc-mar-t-o">
                    <h4>New Courses</h4>
                    <ul>
                        @foreach ($courses as $course) 
                            <li><a href="/courses/{{ $course->slug }}">{{ $course->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-4">
                    <h4>About us</h4>
                    <ul>
                        <li><a href="/about-us">About us</a></li>
                        <li><a href="/news">News</a></li>
                        <li><a href="/events">Events</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h4>HELP & SUPPORT</h4>
                    <ul>
                        <li><a href="/contact">Contact us</a>
                        </li>
                        <li><a href="/pravicy-policy">Pravicy Policy</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row wed-foot-link-1">
                <div class="col-md-4 foot-tc-mar-t-o">
                    <h4>Get In Touch</h4>
                    <p>Address: Nanshae, 19 Street, Bet 58/59, Aungmyaytharzan Tsp, Mandalay, Myanmar</p>
                    <p>Phone: <a href="tel:+09-793200074">+09-793200074</a></p>
                    <p>Email: <a href="mailto:piu.edu2014@gmail.com">piu.edu2014@gmail.com</a></p>
                </div>
                <div class="col-md-4">
                    <h4>Follow us</h4>
                    <ul>
                        <li>
                            <a href="https://www.facebook.com/PhaungDawOoInternationalUniveristy" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i>
                        </a>
                        </li>
                        <li><a href="https://twitter.com/piumyanmar" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>