<x-head />

<body>

   <section>
		<div class="ad-log-main">
			<div class="ad-log-in">
				<div class="ad-log-in-logo">
					<a href="index-2.html"><img src="images/logo.png" alt=""></a>
				</div>
				<div class="ad-log-in-con">
			<div class="log-in-pop-right">
                    <h4>Login</h4>
                    <p>Don't have an account? Create your account. It's take less then a minutes</p>
                    <form action="{{ route('admin.auth.login.submit') }}" method="POST" class="s12">
                        @csrf
                        @method('POST')
                        <div>
                            <div class="input-field s12">
                                <input type="email" name="email" data-ng-model="name" class="validate">
                                <label class="">User name</label>
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
                                <i class="waves-effect waves-light log-in-btn waves-input-wrapper" style=""><input type="submit" value="Login" class="waves-button-input"></i> </div>
                        </div>
                        <div>
                            <div class="input-field s12"> <a href="admin-forgot.html">Forgot password</a> | <a href="/register">Create a new account</a> </div>
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