<x-admin_layout>
  <div class="sb2-2-2">
                    <ul>
                        <li><a href="/admin"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                        </li>
                        <li class="active-bre"><a href="#"> User Profile</a>
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
                                    <h4>Website Setting</h4>
                                    <p>Here you can edit your website basic details URL, Phone, Email, Address, User and password and more</p>
                                </div>
                                <div class="tab-inn">
                                    <form  action="" method="POST">
                                      @csrf
                                      @method('POST')
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="first_name" type="text" name="name" class="validate" required>
                                                <label for="first_name" class="">Name</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="last_name" type="text" name="email" class="validate" required>
                                                <label for="last_name" class="">Email</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="phone" type="number" name="phone" class="validate" required>
                                                <label for="phone">Phone number</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input type="text" name="address" class="validate" required>
                                                <label for="cphone" class="">Address</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="city" type="text" name="city" class="validate">
                                                <label for="city" class="">City</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="country" type="text" name="country" class="validate">
                                                <label for="country" class="">Country</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s6">
                                                <input id="password" type="password" class="validate">
                                                <label for="password" class="">Password</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="password1" type="password" class="validate">
                                                <label for="password1" class="">Confirm Password</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="text" class="validate">
                                                <label>Website</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <input type="text" class="validate">
                                                <label>Website blog</label>
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