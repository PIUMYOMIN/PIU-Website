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
