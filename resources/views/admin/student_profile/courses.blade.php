<x-layout>
    <!--SECTION START-->
    <section>
        <div class="pro-cover">
        </div>
        <div class="stu-db">
            <div class="container pg-inn">
                <div class="col-md-9">
                    <div class="udb">
                        <div class="udb-sec udb-cour">
                            <h4><img src="images/icon/db2.png" alt="" />Joined Courses at PIU</h4>
                            <div class="sdb-cours">
                                <ul>
                                    @foreach ($courseYears as $course)
                                        <li>
                                            <a href="#">
                                                <div class="list-mig-like-com com-mar-bot-30">
                                                    <div class="list-mig-lc-img">
                                                        <img src="{{ asset('storage/' . $course->course->image) }}"
                                                            alt="" width="200">
                                                        <span class="home-list-pop-rat list-mi-pr">Phaung Daw Oo
                                                            International University</span>
                                                    </div>
                                                    <div class="list-mig-lc-con">
                                                        <h5>{{ $course->course->title }}</h5>
                                                        <p>{{ $course->academicYear->name }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--SECTION END-->
</x-layout>
