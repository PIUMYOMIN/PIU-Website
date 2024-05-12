<x-admin_layout>
    <div class="sb2-2-2">
                    <ul>
                        <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                        </li>
                        <li class="active-bre"><a href="#"> Add New Event</a>
                        </li>
                        <li class="page-back"><a href="index-2.html"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
                        </li>
                    </ul>
                </div>

                <!--== User Details ==-->
                <div class="sb2-2-3">
                    <div class="row">
                        <div class="col-md-12">
						<div class="box-inn-sp admin-form">
                                <div class="inn-title">
                                    <h4>Add News</h4>
                                    <p>Here you can edit your website basic details URL, Phone, Email, Address, User and password and more</p>
                                </div>
                                <div class="tab-inn">
                                    <form action="{{ route('admin.news.form.update',$new->id) }}" method="POST" enctype="multipart/form-data">
                                      @csrf
                                      @method('PATCH')
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="text" value="{{ $new->title }}" name="title" class="validate" required>
                                            </div>
                                            @error('title')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <textarea name="body" id="editor">{{ $new->body }}</textarea>
                                            </div>
                                            @error('body')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        </div>
                                        <div class="row">
											<div class="file-field input-field col s12">
												<div class="btn admin-upload-btn">
													<span>File</span>
													<input type="file" name="image">
												</div>
												<div class="file-path-wrapper">
													<input class="file-path validate" type="text" placeholder="News Thumbnail">
												</div>
                                                <img src="/storage/{{ $new->image }}"
                                                            alt="{{ $new->image }}" width="200">
											</div>
                      @error('image')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        </div>
										<div class="row">
                                            <div class="input-field col s12">
                                                <i class="waves-effect waves-light btn-large waves-input-wrapper" style=""><input type="submit" class="waves-button-input"></i>
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