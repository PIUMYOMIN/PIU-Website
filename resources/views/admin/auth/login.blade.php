<x-head />

<body>

    <section>
        <div class="ad-log-main">
            <div class="ad-log-in">
                <div class="ad-log-in-logo">
                    <a href="/"><img src="{{ asset('images/PIU-logo.png') }}" alt=""></a>
                </div>
                <div class="ad-log-in-con">
                    <div class="log-in-pop-right" style="width:100% !important">
                        <h4>Login</h4>
                        <p>Don't have an account? Create your account. It's take less then a minutes</p>
                        <form action="{{ route('users.login.form.submit') }}" method="POST" class="s12">
                            @csrf
                            @method('POST')
                            <div>
                                <div class="input-field s12">
                                    <input type="text" name="identifier" data-ng-model="name" class="validate">
                                    <label class="">Email or Student ID</label>
                                </div>
                            </div>
                            <div>
                                <div class="input-field s12">
                                    <input type="password" name="password" class="validate">
                                    <label>Password</label>
                                </div>
                            </div>
                            <div>
                                <div class="s12 log-ch-bx">
                                    <p>
                                        <input type="checkbox" name="remember" id="test5">
                                        <label for="test5">Remember me</label>
                                    </p>
                                </div>
                            </div>
                            <div>
                                <div class="input-field s4">
                                    <i class="waves-effect waves-light log-in-btn waves-input-wrapper"
                                        style=""><input type="submit" value="Login"
                                            class="waves-button-input"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-center">(OR)</p>
                            </div>
                            <div class="col s4" style="margin: 0px 0px !important;">
                                    <a href="{{ route('auth.facebook.user.redirect') }}" class="btn btn-light btn-outline-light" style="color: white !important; margin: 3px 0px !important;"><i class="fa fa-facebook"></i> Login with Facebook</a>
                                    <a href="{{ route('auth.google.user.redirect') }}" class="btn btn-danger btn-outline-danger" style="color: white !important; margin: 3px 0px !important;"><i class="fa fa-google"></i> Login with Google</a>
                                    <a href="{{ route('auth.twitter.user.redirect') }}" class="btn btn-info btn-outline-info" style="color: white !important; margin: 3px 0px !important;"><i class="fa fa-twitter"></i> Login with Twitter</a>
                                </div>
                            <div>
                                <div class="input-field s12"> <a href="admin-forgot.html">Forgot password</a> | <a
                                        href="/register">Create a new account</a> </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-scriptLinks />
</body>

</html>
