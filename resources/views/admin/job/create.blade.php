<x-admin_layout>
    <div class="sb2-2-2">
                    <ul>
                        <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                        </li>
                        <li class="active-bre"><a href="#"> Add New Job</a>
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
                                    <h4>New Job Opening</h4>
                                    <p>Here you can edit your website basic details URL, Phone, Email, Address, User and password and more</p>
                                </div>
                                <div class="tab-inn">
                                    <form action="{{ route('admin.jobs.form.submit') }}" method="POST" enctype="multipart/form-data">
                                      @csrf
                                      @method('POST')
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="text" name="title" value="" class="validate" required>
                                                <label class="">Job Title</label>
                                            @error('title')
                                              <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <textarea name="description"></textarea>
                                                <label class="">Job Descriptions</label>
                                              @error('description')
                                                <p class="text-danger">{{ $message }}</p>
                                              @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input type="number" name="num_of_posts" value="" class="validate" required>
                                                <label class="">No of Post</label>
                                            @error('num_of_posts')
                                              <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            </div>
                                            <div class="input-field col s6">
                                                <input type="text" name="job_campus" value="" class="validate" required>
                                                <label class="">Campus</label>
                                            @error('job_campus')
                                              <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input type="date" name="expire_date" value="" class="validate" required>
                                                <label class="">End Date</label>
                                            @error('expire_date')
                                              <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            </div>
                                            <div class="input-field col s6">
                                                <input type="time" name="expire_time" class="validate" value="" required>
                                                <label class="">Time</label>
                                              @error('expire_time')
                                                <p class="text-danger">{{ $message }}</p>
                                              @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input type="text" name="city" value="" class="validate">
                                                <label class="">City</label>
                                            @error('city')
                                              <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            </div>
                                            <div class="input-field col s6">
                                                <input type="text" name="country" value="" class="validate">
                                                <label class="">Country</label>
                                            @error('country')
                                              <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                            </div>
                                        </div>
                                        <div class="row">
											<div class="file-field input-field col s12">
												<div class="btn admin-upload-btn">
													<span>File</span>
													<input type="file" name="image">
                          @error('image')
                            <p class="text-danger">{{ $message }}</p>
                          @enderror
												</div>
												<div class="file-path-wrapper">
													<input class="file-path validate" type="text" placeholder="Job Thumbnail">
												</div>
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