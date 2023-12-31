<x-admin_layout>
  <!--== breadcrumbs ==-->
                <div class="sb2-2-2">
                    <ul>
                        <li><a href="/admin"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                        </li>
                        <li class="active-bre"><a href="#!"> Add New Event</a>
                        </li>
                        <li class="page-back"><a href="/admin/events"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
                        </li>
                    </ul>
                </div>

                <!--== User Details ==-->
                <div class="sb2-2-3">
                    <div class="row">
                        <div class="col-md-12">
						<div class="box-inn-sp admin-form">
                                <div class="inn-title">
                                    <h4>Add Gallery</h4>
                                    <p>Here you can edit your website basic details URL, Phone, Email, Address, User and password and more</p>
                                </div>
                                <div class="tab-inn">
                                    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                                      @csrf
                                      @method('POST')
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="text" name="image_tag" value="" class="validate" required>
                                                <label class="">Image Tag</label>
                                                @error('image_tag')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input type="text" name="link1" value="" class="validate">
                                                <label class="">link 2</label>
                                                @error('link1')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="input-field col s6">
                                                <input type="text" name="link2" class="validate" value="">
                                                <label class="">Link 2</label>
                                                @error('link2')
                                                    <span class="text-danger">{{ $message }}</span>
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
													                    <input class="file-path validate" type="text" placeholder="Choose Image">
												                    </div>
                                                @error('image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
											                      </div>
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
</x-admin_layout>