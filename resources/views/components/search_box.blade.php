<div class="search-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="search-form">
                            <form action="{{ route('search-course') }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="sf-type">
                                    <div class="sf-input">
                                        <input type="text" name="search" id="sf-box" placeholder="Search Course">
                                    </div>
                                    <div class="sf-list">
                                        <ul>
                                            @foreach ($courses as $course) 
                                                <li>
                                                    <a href="/courses/{{ $course->slug }}">{{ $course->title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="sf-submit">
                                    <input type="submit" value="Search Course">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>