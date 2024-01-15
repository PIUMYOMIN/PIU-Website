<x-admin_layout>
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp admin-form">
                    <div class="inn-title">
                        <h4>Edit Curriculum</h4>
                        <p>Here you can edit your website basic details URL, Phone, Email, Address, User and
                            password and more</p>
                    </div>
                    <div class="tab-inn">
                        <form action="{{ route('admin.curriculum.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" name="title" value="{{ $curriculum->title }}" class="validate"
                                        required>
                                    <label class="">Title</label>
                                </div>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea value="" class="validate"
                                        name="description" required>{{ $curriculum->description }}</textarea>
                                    <label class="">Description</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <select name="course_id">
                                        <option value="" disabled selected>Choose Course Code</option>
                                        @foreach ($courses as $course)
                                            <option {{ $course->id == old('course_id') ? 'selected' : '' }}
                                                value="{{ $course->id }}">{{ $course->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('course_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="input-field col s6">
                                    <select name="module_id">
                                        <option value="" disabled selected>Choose Module Code</option>
                                        @foreach ($modules as $module)
                                            <option {{ $module->id == old('module_id') ? 'selected' : '' }}
                                                value="{{ $module->id }}">{{ $module->module_code }}</option>
                                        @endforeach
                                    </select>
                                    @error('module_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
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
</x-admin_layout>
