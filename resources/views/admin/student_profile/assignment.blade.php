<x-layout>
    <!--SECTION START-->
    {{-- @dd($notificationCount) --}}
    <section>
        <div class="pro-cover">
        </div>
        <x-profile-menu-tab :student="$student" :notificationCount="$notificationCount" :newAssignmentCount="$newAssignmentCount" />
        <div class="stu-db">
            <div class="container pg-inn">
                <x-user-profile />
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
