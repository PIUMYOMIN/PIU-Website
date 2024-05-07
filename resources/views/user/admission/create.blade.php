<x-layout>
    <!--SECTION START-->
    <section class="c-all h-quote">
        <div class="container">
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="all-title quote-title qu-new">
                    <h2>Requirements</h2>
                    <p style="text-align: left; color:white;">Application for any diploma or bachelor's degree programs must:</p>
                    <ul style="text-align: left">
                        <li style="color: white">
                            - Show a strong interest in the respective area of study.
                        </li>
                        <li style="color: white">
                            - Fill out an application from, and
                        </li>
                        <li style="color: white">
                            - Provide all the requirement documents such as academic records, personal statement and
                            letters of recommedations, etc.
                        </li>
                    </ul>
                    <p class="help-line">Help Line <span>+09-793200074</span> </p> <span class="help-arrow pulse"><i
                            class="fa fa-angle-right" aria-hidden="true"></i></span>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12" id="">
                <div class="n-form-com admiss-form">
                    <div class="col s12">
                        <form class="form-horizontal" action="{{ route('piu.application.first-form') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="control-label col-sm-3">Full Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control" placeholder="Name" required>
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Email:</label>
                                <div class="col-sm-9">
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control" placeholder="Email" required>
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Phone:</label>
                                <div class="col-sm-9">
                                    <input type="number" name="phone" value="{{ old('phone') }}"
                                        class="form-control" placeholder="Phone" required>
                                    @error('phone')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Country:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="country" value="{{ old('country') }}"
                                        class="form-control" placeholder="Country" required>
                                    @error('country')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Your City:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="city" value="{{ old('city') }}"
                                        class="form-control" placeholder="City" required>
                                    @error('city')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Zip Code:</label>
                                <div class="col-sm-9">
                                    <input type="number" name="zipcode" value="{{ old('zipcode') }}"
                                        class="form-control" placeholder="Zip Code" required>
                                    @error('zipcode')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Address:</label>
                                <div class="col-sm-9">
                                    <textarea name="address" class="form-control" value="{{ old('address') }}" required>
                                    </textarea>
                                    @error('address')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Apply Program:</label>
                                <div class="col-sm-9">
                                    <select name="course_id" class="browser-default" required>
                                        <option disabled selected>-- Select course --</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mar-bot-0">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <i class="waves-effect waves-light light-btn waves-input-wrapper" style="">
                                        <input type="submit" onclick="validateForm()" value="Next"
                                            class="waves-button-input"></i>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--SECTION END-->

</x-layout>
