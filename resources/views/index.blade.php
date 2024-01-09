<x-layout>
    <x-slider :slides="$slides" />
    <x-quickLinks />
    <!-- DISCOVER MORE -->
    <section>
        <div class="container com-sp pad-bot-70">
            <div class="row">
                <div class="con-title">
                    <h2>Discover <span>More</span></h2>
                </div>
            </div>
            <div class="row">
                <div class="ed-course">
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <div class="ed-course-in">
                            <a class="course-overlay" href="about.html">
                                <img src="images/h-about.jpg" alt="">
                                <span>Academics</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <div class="ed-course-in">
                            <a class="course-overlay" href="admission.html">
                                <img src="images/h-adm1.jpg" alt="">
                                <span>Admission</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <div class="ed-course-in">
                            <a class="course-overlay" href="dashboard.html">
                                <img src="images/h-cam.jpg" alt="">
                                <span>Students profile</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <div class="ed-course-in">
                            <a class="course-overlay" href="research.html">
                                <img src="images/h-res.jpg" alt="">
                                <span>Research & Education</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <div class="ed-course-in">
                            <a class="course-overlay" href="/courses">
                                <img src="images/h-about1.jpg" alt="">
                                <span>Courses</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <div class="ed-course-in">
                            <a class="course-overlay" href="db-time-line.html">
                                <img src="images/h-adm.jpg" alt="">
                                <span>Exam Time Line</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <div class="ed-course-in">
                            <a class="course-overlay" href="seminar.html">
                                <img src="images/h-cam1.jpg" alt="">
                                <span>Seminar 2018</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <div class="ed-course-in">
                            <a class="course-overlay" href="events.html">
                                <img src="images/h-res1.jpg" alt="">
                                <span>Research & Education</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- UPCOMING EVENTS -->
    <section>
        <div class="container com-sp pad-bot-0">
            <div class="row">
                <div class="col-md-4">
                    <div class="ho-ev-latest ho-ev-latest-bg-1">
                        <div class="ho-lat-ev">
                            <h4 class="text-center">Upcoming Event</h4>
                        </div>
                    </div>
                    <div class="ho-event ho-event-mob-bot-sp">
                        <ul>
                            @foreach ($events as $event) 
                                <li>
                                    <div class="ho-ev-date"><span>07</span><span>jan,2018</span>
                                    </div>
                                    <div class="ho-ev-link">
                                        <a href="events.html">
                                            <h4>{{ Str::limit($event->name, 20, '...') }}</h4>
                                        </a>
                                        <p>{{ Str::limit($event->name, 150, '...') }}</p>
                                        <span>{{ $event->start_time }} – {{ $event->end_time }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="ho-ev-latest ho-ev-latest-bg-2">
                        <div class="ho-lat-ev">
                            <h4 class="text-center">Job Vacants</h4>
                        </div>
                    </div>
                    <div class="ho-event ho-event-mob-bot-sp">
                        <ul>
                            @foreach ($jobs as $job) 
                                <li>
                                    <div class="ho-ev-img">
                                        <img src="{{ asset('storage/'.$job->image) }}" alt="">
                                    </div>
                                    <div class="ho-ev-link">
                                        <a href="#">
                                            <h4>{{ $job->title }}</h4>
                                        </a>
                                        <p>{{ Str::limit($job->description, 80, '...') }}</p>
                                        <span>Location: {{ $job->city }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="ho-ev-latest ho-ev-latest-bg-3">
                        <div class="ho-lat-ev">
                            <h4 class="text-center">Campuses</h4>
                        </div>
                    </div>
                    <div class="ho-event ho-event-mob-bot-sp">
                        <ul>
                            <li>
                                <div class="ho-ev-img"><img src="images/event/1.jpg" alt="">
                                </div>
                                <div class="ho-ev-link">
                                    <a href="#">
                                        <h4>Almost before we knew it, we had left the ground</h4>
                                    </a>
                                    <p>Etiam ornare lacus nec lectus vestibulum aliquam.</p>
                                    <span>Location: New York</span>
                                </div>
                            </li>
                            <li>
                                <div class="ho-ev-img"><img src="images/event/2.jpg" alt="">
                                </div>
                                <div class="ho-ev-link">
                                    <a href="#">
                                        <h4>Then came the night of the first falling star.</h4>
                                    </a>
                                    <p>Vestibulum sollicitudin sem arcu</p>
                                    <span>Location: Los Angeles</span>
                                </div>
                            </li>
                            <li>
                                <div class="ho-ev-img"><img src="images/event/3.jpg" alt="">
                                </div>
                                <div class="ho-ev-link">
                                    <a href="#">
                                        <h4>Educate to Empower NYE Party</h4>
                                    </a>
                                    <p>Vestibulum sollicitudin sem arcu, eget ullamcorper purus hendrerit</p>
                                    <span>Location: Chennai</span>
                                </div>
                            </li>
                            <li>
                                <div class="ho-ev-img"><img src="images/event/4.jpg" alt=""></div>
                                <div class="ho-ev-link">
                                    <a href="#">
                                        <h4>Then came the night of the first falling star.</h4>
                                    </a>
                                    <p>Venenatis lacus lectus.</p>
                                    <span>Location: Chicago</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NEWS AND EVENTS -->
    <section>
        <div class="container com-sp">
            <div class="row">
                <div class="con-title">
                    <h2>News and <span>Events</span></h2>
                    <p>Fusce id sem at ligula laoreet hendrerit venenatis sed purus. Ut pellentesque maximus lacus, nec pharetra augue.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="bot-gal h-gal ho-event-mob-bot-sp">
                        <h4>Photo Gallery</h4>
                        <ul>
                            @foreach ($galleries as $gallery) 
                                <li>
                                    <img class="materialboxed" data-caption="{{ $gallery->image_tag }}" src="{{ asset('storage/'.$gallery->image) }}" alt="{{ $gallery->image_tag }}">
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bot-gal h-vid ho-event-mob-bot-sp">
                        <h4>Video Gallery</h4>
                        <iframe src="https://www.youtube.com/embed/2WqFtiR4-F4?autoplay=0&amp;showinfo=0&amp;controls=0" allowfullscreen></iframe>
                        <h5>Maecenas sollicitudin lacinia</h5>
                        <p>Maecenas finibus neque a tellus auctor mattis. Aliquam tempor varius ornare. Maecenas dignissim leo leo, nec posuere purus finibus vitae.</p>
                        <p>Quisque vitae neque at tellus malesuada convallis. Phasellus in lectus vitae ex euismod interdum non a lorem. Nulla bibendum. Curabitur mi odio, tempus quis risus cursus.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bot-gal h-blog ho-event">
                        <h4>News & Event</h4>
                        <div class="ho-event">
                            <ul>
                                @foreach ($events as $event) 
                                    <li>
                                        <div class="ho-ev-date"><span>07</span><span>jan,2018</span>
                                        </div>
                                        <div class="ho-ev-link">
                                            <a href="events.html">
                                                <h4>{{ Str::limit($event->name, 20, '...') }}</h4>
                                            </a>
                                            <p>{{ Str::limit($event->description, 150, '...') }}</p>
                                            <span>{{ $event->start_time }} – {{ $event->end_time }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layout>
