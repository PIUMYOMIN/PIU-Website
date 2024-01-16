<x-admin_layout>
    <div class="sb2-2-2">
        <ul>
            <li><a href="/admin"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li class="active-bre"><a href="#"> User Password Change</a>
            </li>
            <li class="page-back"><a href="/admin"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
            </li>
        </ul>
    </div>

    <!--== User Details ==-->
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp admin-form">
                    <div class="inn-title">
                        <h4>Add New Department</h4>
                        <p>Here you can edit your website basic details URL, Phone, Email, Address, User and password
                            and more</p>
                    </div>
                    <div class="tab-inn">
                        <form action="{{ route('admin.user.passwordUpdate',[$user->id]) }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="row">
                                @if (!$user->provider_id)
    <div class="input-field col s6">
        <input type="password" value="" name="old_password" class="validate" required>
        <label class="">Old Password</label>
        @error('old_password')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
@endif

                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <input type="password" value="" name="new_password" class="validate" required>
                                    <label class="">New Password</label>
                                    @error('new_password')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <input type="password" value="" name="confirm_password" class="validate" required>
                                    <label class="">Confirm Password</label>
                                    @error('confirm_password')
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
