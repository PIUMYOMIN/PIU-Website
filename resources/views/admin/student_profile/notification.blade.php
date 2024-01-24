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
                                <h4>
                                    <i class="fa fa-pencil"></i>
                                    {{ $assignment->name }} <span><i>Deadline
                                            {{ $assignment->date }}&nbsp;&nbsp;<i
                                                class="fa fa-clock-o"></i>{{ $assignment->time }}</i></span>
                                </h4>
                                <p>{!! $assignment->description !!}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--SECTION END-->

</x-layout>
