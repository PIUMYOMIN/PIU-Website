<x-layout>
    <section>
        <div class="head-2">
            <div class="container">
                <div class="head-2-inn head-2-inn-padd-top">
                    <h1>List of College Courses</h1>
                </div>
            </div>
        </div>
    </section>

    <!--SECTION START-->
    <section>
        <div class="ed-res-bg">
            <div class="container com-sp pad-bot-70 ed-res-bg">
                <div class="row">
                    <div class="cor about-sp">
                        <div class="ed-rsear">
                            <div class="ed-rsear-in">
                                <ul>
                                    @foreach ($courses as $course) 
                                      <li>
                                          <div class="ed-rese-grid">
                                              <div class="ed-rsear-img ed-faci-full-top">
                                                  <img src="{{ asset('storage/'.$course->image) }}" alt="">
                                              </div>
                                              <div class="ed-rsear-dec ed-faci-full-bot">
                                                  <h4><a href="/courses/{{ $course->slug }}">{{ $course->title }}</a>
                                                  </h4>
                                                  <p>{{ Str::limit($course->description, 300, '...') }}</p>
                                                  <a href="/courses/{{ $course->slug }}" class="read-line-btn">Read more</a>
                                              </div>
                                          </div>
                                      </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="ed-about-sec1">
                            <div class="col-md-6"></div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--SECTION END-->
</x-layout>
