<x-layout>
  <section>
        <div class="container com-sp">
            <div class="row">
                <div class="cor about-sp">
                    <div class="ed-about-tit">
                        <div class="con-title">
                            <h2>College <span> Events</span></h2>
                            <p>Fusce id sem at ligula laoreet hendrerit venenatis sed purus. Ut pellentesque maximus lacus, nec pharetra augue.</p>
                        </div>
                        <div>
                            <div class="ho-event pg-eve-main">
                                <ul>
                                    @foreach ($events as $event) 
                                      <li>
                                          <div class="ho-ev-date pg-eve-date">
                                            <span>{{ explode('-', $event->date)[2] }}</span>
                                            <span>{{ date('M', strtotime($event->date)) }},{{ explode('-', $event->date)[0] }}</span>
                                          </div>
                                          <div class="ho-ev-link pg-eve-desc">
                                              <a href="event-register.html">
                                                  <h4>{{ $event->name }}</h4>
                                              </a>
                                              <p>{{ Str::limit($event->description, 130, '...') }}</p>
                                              <span>{{ $event->time }}</span>
                                          </div>
                                          <div class="pg-eve-reg">
                                              <a href="{{ route('events.register', ['slug' => $event->slug]) }}">Register</a>
                                              <a href="/events/{{ $event->slug }}">Read more</a>
                                          </div>
                                      </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="pg-pagina">
                            <ul class="pagination">
                                <li class="disabled"><a href="#!"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                                <li class="active"><a href="#!">1</a></li>
                                <li class="waves-effect"><a href="#!">2</a></li>
                                <li class="waves-effect"><a href="#!">3</a></li>
                                <li class="waves-effect"><a href="#!">4</a></li>
                                <li class="waves-effect"><a href="#!">5</a></li>
                                <li class="waves-effect"><a href="#!"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>