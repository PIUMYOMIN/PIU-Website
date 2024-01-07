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
                                    <h4>Add Event</h4>
                                    <p>Here you can edit your website basic details URL, Phone, Email, Address, User and password and more</p>
                                </div>
                                <div class="tab-inn">
                                    <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data">
                                      @csrf
                                      @method('POST')
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="text" name="name" value="{{ old('name') }}" class="validate" required>
                                                <label class="">Event name</label>
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <textarea name="description">{{ old('description') }}</textarea>
                                                <label class="">Event Descriptions</label>
                                                @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input type="date" name="date" value="{{ old('date') }}" class="validate" required>
                                                <label class="" style="margin-left: 20%">Date</label>
                                                @error('date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="input-field col s6">
                                                <div class="col s6">
                                                    <input type="time" name="start_time" class="validate" value="{{ old('start_time') }}" required placeholder="Start Time">
                                                {{-- <label class="">Start Time</label> --}}
                                                @error('start_time')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                </div>
                                                <div class="col s6">
                                                    <input type="time" name="end_time" class="validate" value="{{ old('end_time') }}" required placeholder="End Time">
                                                {{-- <label class="">End Time</label> --}}
                                                @error('end_time')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input type="text" name="location" value="{{ old('location') }}" class="validate" required>
                                                <label class="">Location</label>
                                                @error('location')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="input-field col s6">
                                                <input type="number" name="seat" class="validate" value="{{ old('seat') }}" required>
                                                <label class="">Seat</label>
                                                @error('seat')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input type="text" name="city" value="{{ old('city') }}" class="validate">
                                                <label class="">City</label>
                                                @error('city')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="input-field col s6">
                                                <input type="text" name="country" value="{{ old('country') }}" class="validate">
                                                <label class="">Country</label>
                                                @error('country')
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
													<input class="file-path validate" type="text" placeholder="Event image">
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