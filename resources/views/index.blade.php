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
                            <a class="course-overlay" href="/piu/admission/application-form">
                                <img src="images/h-adm1.jpg" alt="">
                                <span>Admission</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <div class="ed-course-in">
                            <a class="course-overlay" href="/our-alumni">
                                <img src="images/h-cam.jpg" alt="">
                                <span>Our Alumni</span>
                            </a>
                        </div>
                    </div>
                    <!-- <div class="col-md-3 col-sm-4 col-xs-12">
                        <div class="ed-course-in">
                            <a class="course-overlay" href="/courses/postgraduate-diploma-in-education">
                                <img src="images/h-res.jpg" alt="">
                                <span>Research & Education</span>
                            </a>
                        </div>
                    </div> -->
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
                            <a class="course-overlay" href="/president-of-piu">
                                <img src="images/h-adm.jpg" alt="">
                                <span>University President</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <div class="ed-course-in">
                            <a class="course-overlay" href="/events">
                                <img src="images/h-cam1.jpg" alt="">
                                <span>Events 2024</span>
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
                            @forelse ($events as $event) 
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
                            @empty
                            <p class="text-center">No event found.</p>
                            @endforelse
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
                            @forelse ($jobs as $job) 
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
                            @empty
                                <p class="text-center">No job vacant found.</p>
                            @endforelse
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
                            @forelse ($campuses as $campus) 
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
                            @empty 
                                <p class="text-center">No campus found.</p>
                            @endforelse
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
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/6fHnGiyImAA"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen></iframe>
                        <h5>Bachelor of Arts in Social Studies</h5>
                        <p>
                            Phaung Daw Oo International University (PIU) provides a Bachelor of Arts degree program in
                            Pāli and Sanskrit Language and Literature in collaboration with the International Buddhist
                            College (IBC), Thailand. Under this program, students from Myanmar will attend the first two
                            years at PIU in Myanmar and another two years at IBC in Thailand.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bot-gal h-blog ho-event">
                        <h4>News & Event</h4>
                        <div class="ho-event">
                            <ul>
                                @foreach ($news as $new) 
                                    <li>
                                        <div class="ho-ev-date"><span>{{ $new->created_at->format('d') }}</span><span>{{ $new->created_at->format('M') }},{{ $new->created_at->format('Y') }}</span>
                                        </div>
                                        <div class="ho-ev-link">
                                            <a href="/news/{{ $new->slug }}">
                                                <h4>{{ Str::limit($new->title, 20, '...') }}</h4>
                                            </a>
                                            <p>{{ Str::limit($new->body, 150, '...') }}</p>
                                            <span>{{ $new->created_at }} – {{ $new->updated_at }}</span>
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
