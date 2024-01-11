<x-admin_layout>
    <div class="sb2-2-2">
        <ul>
            <li>
              <a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li class="active-bre">
              <a href="#"> Slide Edit</a>
            </li>
            <li class="page-back">
              <a href="/admin/slides"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
            </li>
        </ul>
    </div>
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp admin-form">
                    <div class="inn-title">
                        <h4>Edit Slide</h4>
                        <p>Here you can edit your website basic details URL, Phone, Email, Address, User and
                            password and more</p>
                    </div>
                    <div class="tab-inn">
                        <form action="{{ route('admin.slides.update', [$slide->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" name="title" value="{{ $slide->title }}" class="validate"
                                        required>
                                    <label class="">Title</label>
                                </div>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <input type="text" value="{{ $slide->image_tag }}" class="validate"
                                        name="image_tag" required>
                                    <label class="">Image Tag</label>
                                </div>
                                <div class="input-field col s6">
                                    <input type="text" class="validate" value="{{ $slide->text }}"
                                        name="tag_link">
                                    <label class="">Tag Link</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea name="description">{{ $slide->description }}</textarea>
                                    <label class="">Description</label>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="file-field input-field col s12">
                                    <div class="btn admin-upload-btn">
                                        <span>File</span>
                                        <input type="file" name="slide_image">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" placeholder="Slide Image">
                                    </div>
                                    @error('slide_image')
                                        <span class="text-danger">{{ $message }}</span>
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
