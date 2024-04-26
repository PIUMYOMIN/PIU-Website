<x-layout>
    <!--SECTION START-->
    {{-- @dd($student) --}}
    <section>
        <div class="pro-cover">
        </div>
        <div class="stu-db">
            <div class="container pg-inn">
                <div class="col-md-9">
                    <div class="udb">
                        <div class="udb-sec udb-prof">
                            <h4>
                                <i class="fa fa-book"></i>
                                {{ $assignment->name }} 
                                <span>
                                    <i>Deadline
                                        {{ $assignment->date }}
                                    </i>
                                </span>
                            </h4>
                            <p>{!! $assignment->description !!}</p>
                            <span>
                                <i>
                                <a href="{{ asset('storage/'. $assignment->file ) }}"><i class="fa fa-paperclip"></i> Download Attach File</a>
                                </i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--SECTION END-->

</x-layout>
