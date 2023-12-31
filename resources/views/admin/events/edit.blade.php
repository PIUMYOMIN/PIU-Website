<x-admin_layout>
  <!--== breadcrumbs ==-->
                <div class="sb2-2-2">
                    <ul>
                        <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                        </li>
                        <li class="active-bre"><a href="#"> Edit New Event</a>
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
                                    <h4>Add Event</h4>
                                    <p>Here you can edit your website basic details URL, Phone, Email, Address, User and password and more</p>
                                </div>
                                <div class="tab-inn">
                                    <form action="{{ route('admin.event.update',[$event->id]) }}" method="POST" enctype="multipart/form-data">
                                      @csrf
                                      @method('PATCH')
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="text" name="name" value="{{ $event->name }}" class="validate" required>
                                                <label class="">event name</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <textarea name="description">{{ $event->description }}</textarea>
                                                <label class="">event Descriptions</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input type="date" name="date" value="{{ $event->date }}" class="validate" required>
                                                <label class="" style="margin-left: 20%">Date</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input type="text" name="time" class="validate" value="{{ $event->time }}" required>
                                                <label class="">Time</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input type="text" name="location" value="{{ $event->location }}" class="validate" required>
                                                <label class="">Location</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input type="number" name="seat" class="validate" value="{{ $event->seat }}" required>
                                                <label class="">Seat</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input type="text" name="city" value="{{ $event->city }}" class="validate">
                                                <label class="">City</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input type="text" name="country" value="{{ $event->country }}" class="validate">
                                                <label class="">Country</label>
                                            </div>
                                        </div>
                                        <div class="row">
											<div class="file-field input-field col s12">
												<div class="btn admin-upload-btn">
													<span>File</span>
													<input type="file" name="image">
												</div>
												<div class="file-path-wrapper">
													<input class="file-path validate" type="text" placeholder="event image">
												</div>
                        <img
                          src="{{ asset('storage/'.$event->image) }}"
                          class="img-fluid rounded-top"
                          alt="" width="200"
                        />
                        
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