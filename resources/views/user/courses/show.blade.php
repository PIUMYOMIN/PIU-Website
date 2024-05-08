<x-layout>
    <section>
        <div class="container com-sp pad-bot-70 pg-inn">
            <div class="row">
                <div class="cor">
                    <div class="col-md-3">
                        <div class="cor-side-com">
                            <div class="">
                                <div class="de-left-tit">
                                    <h4>Upcoming Event</h4>
                                </div>
                            </div>
                            <div class="ho-event">
                                <ul>
                                    @foreach ($events as $event)
                                        <li>
                                            <div class="ho-ev-link ho-ev-link-full">
                                                <a href="#">
                                                    <h4>{{ $event->name }}</h4>
                                                </a>
                                                <p>{{ Str::limit($event->description, 25, '...') }}</p>
                                                <span>{{ $event->date }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="cor-mid-img">
                            <img src="images/course.jpg" alt="">
                        </div>
                        <div class="cor-con-mid">
                            <div class="cor-p1">
                                <h2>{{ $course->title }}</h2>
                                <span>Category: {{ optional($course->category)->name }}</span>
                                <div class="share-btn">
                                    <ul>
                                        <li>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                                                onclick="window.open(this.href, '_blank', 'height=500,width=800'); return false;">
                                                <i class="fa fa-facebook fb1"></i> Share On Facebook
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $course->title }}&via=YourTwitterHandle"
                                                onclick="window.open(this.href, '_blank', 'height=500,width=800'); return false;">
                                                <i class="fa fa-twitter tw1"></i> Share On Twitter
                                            </a>
                                        </li>
                                        <li>
                                            <a href="https://plus.google.com/share?url={{ url()->current() }}"
                                                onclick="window.open(this.href, '_blank', 'height=500,width=800'); return false;">
                                                <i class="fa fa-google-plus gp1"></i> Share On Google Plus
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="cor-p4" style="word-break: break-word;">
                                <h3>Course Details:</h3>
                                <p>{!! $course->description !!}</p>
                            </div>
                            <div class="cor-p5">
                                <h3>Course Syllabus</h3>
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#home">
                                            <img src="images/icon/cor4.png" alt=""> <span>Eligibility</span></a>
                                    </li>
                                    <li><a data-toggle="tab" href="#menu1"><img src="images/icon/cor3.png"
                                                alt=""><span>Requirements</span></a></li>
                                    <li><a data-toggle="tab" href="#menu2"><img src="images/icon/cor3.png"
                                                alt=""><span>Fees</span></a></li>
                                    <li><a data-toggle="tab" href="#menu3"><img src="images/icon/cor1.png"
                                                alt=""><span>Apply</span></a></li>
                                </ul>

                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <p>{!! $course->eligibility !!}</p>
                                    </div>
                                    <div id="menu1" class="tab-pane fade in active">
                                        <p>{!! $course->requirement !!}</p>
                                    </div>
                                    <div id="menu2" class="tab-pane fade">
                                        <p>{!! $course->fees !!}</p>
                                    </div>
                                    <div id="menu3" class="tab-pane fade">
                                        <p>{!! $course->apply !!}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="cor-p4">
                                <h3>A typical weekly timetable:</h3>
                                <p> It was popularised in the 1960s with the release of Letraset sheets containing Lorem
                                    Ipsum passages, and more recently with desktop publishing software like Aldus
                                    PageMaker including versions of Lorem Ipsum.</p>
                                <ul class="collapsible" data-collapsible="accordion">
                                    <li>
                                        <div class="collapsible-header active">1st year</div>
                                        <div class="collapsible-body cor-tim-tab">
                                            <h4>First Year Curriculum</h4>
                                            <ul>
                                                @foreach ($curriculums as $curriculum)
                                                    @if ($curriculum->year_id == 1)
                                                        <li>{{ $curriculum->title }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            <h4>Assessment</h4>
                                            <ul>
                                                <li>Three written papers form the First University Examination, together
                                                    with a submitted portfolio of two exam essays of 2,000 words for
                                                    Introduction to English Language and Literature.</li>
                                                <li>All exams must be passed, but marks do not count towards the final
                                                    degree.</li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="collapsible-header">2st year</div>
                                        <div class="collapsible-body cor-tim-tab">
                                            <h4>Second Year Curriculum</h4>
                                            <ul>
                                                @foreach ($curriculums as $curriculum)
                                                    @if ($curriculum->year_id == 2)
                                                        <li>{{ $curriculum->title }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            <h4>Assessment</h4>
                                            <ul>
                                                {{-- <li>Combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem</li> --}}
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="collapsible-header">3st year</div>
                                        <div class="collapsible-body cor-tim-tab">
                                            <h4>Third Year Curriculum</h4>
                                            <ul>
                                                @foreach ($curriculums as $curriculum)
                                                    @if ($curriculum->year_id == 3)
                                                        <li>{{ $curriculum->title }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            <h4>Assessment</h4>
                                            <ul>
                                                {{-- <li>Three written papers form the First University Examination, together with a submitted portfolio of two exam essays of 2,000 words for Introduction to English Language and Literature.</li> --}}
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="cor-p6">
                                <h3>Student Reviews</h3>
                                @foreach ($comments as $comment)
                                    <div class="cor-p6-revi">
                                        <div class="cor-p6-revi-left">
                                            <img src="images/4.jpg" alt="">
                                        </div>
                                        <div class="cor-p6-revi-right">
                                            <h4>{{ $comment->user->name }}</h4>
                                            <span>Date: {{ $comment->created_at->format('Y-m-d') }}</span>
                                            <p>{{ $comment->message }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="cor-p6">
                                <h3>Write Reviews</h3>
                                <div class="cor-p7-revi">
                                    @auth
                                        <form class="col s12" action="{{ route('admin.course.comment.create') }}"
                                            method="POST">
                                            @csrf
                                            @method('POST')
                                            <div class="row">
                                                <div class="input-field col s6">
                                                    <input type="text" name="name" class="validate" required>
                                                    <label>Name</label>
                                                </div>
                                                <div class="input-field col s6">
                                                    <input type="text" name="email" class="validate" required>
                                                    <label>Email</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <textarea class="materialize-textarea" name="message" required></textarea>
                                                    <label>Message</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                    {!! NoCaptcha::display() !!}
                                                    @error('g-recaptcha-response')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <input type="hidden" name="course_link" class="validate"
                                                        value="{{ url()->current() }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <input type="submit" value="Submit"
                                                        class="waves-effect waves-light btn-book">
                                                </div>
                                            </div>
                                        </form>
                                    @else
                                        <p>Please <a class="text-danger" href="#!" data-toggle="modal"
                                                data-target="#modal1">(login here)</a> to leave the comment.</p>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
