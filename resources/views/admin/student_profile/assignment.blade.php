<x-layout>
    <!--SECTION START-->
    {{-- @dd($notificationCount) --}}
    <section>
        <div class="pro-cover">
        </div>
        <div class="stu-db">
            <div class="container pg-inn">
                <div class="col-md-9">
                    <div class="udb">
                        @foreach ($assignments as $assignment)
                            <div class="udb-sec udb-prof">
                                <a
                                    href="{{ route('admin.students.profile.assignment_details', ['student_id' => $student->id, 'assignment_id' => $assignment->id]) }}">
                                    <h4>
                                        <i class="fa fa-book"></i>
                                        {{ $assignment->name }} <span><i>Deadline {{ $assignment->date }}</i></span>
                                    </h4>
                                    <p>{!! $assignment->description !!}</p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--SECTION END-->

</x-layout>
