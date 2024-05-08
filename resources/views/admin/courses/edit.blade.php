<x-admin_layout>
    <div class="sb2-2-2">
        <ul>
            <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li class="active-bre"><a href="#"> Add New Course</a>
            </li>
            <li class="page-back"><a href="/admin/courses"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
            </li>
        </ul>
    </div>

    <!--== User Details ==-->
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp admin-form">
                    <div class="inn-title">
                        <h4>Edit Course</h4>
                        <p>Here you can edit your website basic details URL, Phone, Email, Address, User and password
                            and more</p>
                    </div>
                    <div class="tab-inn">
                        <form action="{{ route('admin.courses.update',[$course->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" name="title" value="{{$course->title}}" class="validate" required>
                                    <label class="">Course Title</label>
                                    @error('title')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea name="description" id="editor">{{ $course->description }}</textarea>
                                    <label class="">Course Descriptions</label>
                                    @error('description')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea name="requirement" value="{{ $course->requirement }}">{{ $course->requirement }}</textarea>
                                    <label class="">Course Requirements</label>
                                    @error('requirement')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea name="eligibility" value="{{ $course->eligibility }}">{{ $course->eligibility }}</textarea>
                                    <label class="">Eligibility</label>
                                    @error('eligibility')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea name="fees">{{ $course->fees }}</textarea>
                                    <label class="">Course Fees</label>
                                    @error('fees')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea name="apply">{{ $course->apply }}</textarea>
                                    <label class="">Application Process</label>
                                    @error('apply')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <input type="date" name="start_date" value="{{ $course->start_date }}" />
                                    <label class="" style="margin-left:18%;">Start Date</label>
                                    @error('start_date')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="input-field col s6">
                                    <input type="date" name="end_date" value="{{$course->end_date}}" />
                                    <label class="" style="margin-left:18%;">End Date</label>
                                    @error('end_date')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <input type="text" name="duration" value="{{ $course->duration }}" />
                                    <label class="">Duration</label>
                                    @error('duration')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="input-field col s6">
                                    <input type="text" name="total_seat" value="{{ $course->total_seat }}" />
                                    <label class="">Total Seat</label>
                                    @error('total_seat')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <input type="text" name="ic_name" value="{{ $course->ic_name }}" class="validate">
                                    <label class="">Program Incharge Person</label>
                                    @error('ic_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="input-field col s6">
                                    <input type="number" name="ic_phone" value="{{ $course->ic_phone }}" class="validate">
                                    <label class="">Incharge Person Contact</label>
                                    @error('ic_phone')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <select name="course_category_id">
                                        <option disabled selected>Course Category</option>
                                        @foreach ($categories as $category)
                                            <option {{ $category->id == $course->category->id ? 'selected' : '' }}
                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('course_category_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="file-field input-field col s12">
                                    <div class="btn admin-upload-btn">
                                        <span>File</span>
                                        <input type="file" name="image">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" placeholder="Course Thumbnail">
                                    </div>
                                    @error('image')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <img
                                      src="{{ asset('storage/'. $course->image ) }}"
                                      class="img-fluid rounded-top"
                                      alt="" width="200"
                                    />
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="waves-effect waves-light btn-large waves-input-wrapper"
                                        style=""><input type="submit" class="waves-button-input"></i>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        CKEDITOR.replace('editor', {
            filebrowserUploadUrl: "{{ route('admin.courses.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form',
        });
    </script>
</x-admin_layout>
