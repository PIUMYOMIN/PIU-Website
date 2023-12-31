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
                    <h4>Register</h4>
                    <p>Don't have an account? Create your account. It's take less then a minutes</p>
                    <form action="{{ route('user.register.form.submit') }}" method="POST" class="s12">
                        @csrf
                        @method('POST')
                        <div>
                            <div class="input-field s12">
                                <input type="text" name="name" data-ng-model="name1" class="validate">
                                <label>User name</label>
                            </div>
                        </div>
                        <div>
                            <div class="input-field s12">
                                <input type="email" name="email" class="validate">
                                <label>Email id</label>
                            </div>
                        </div>
                        <div>
                            <div class="input-field s12">
                                <input type="password" name="password" class="validate">
                                <label>Password</label>
                            </div>
                        </div>
                        <div>
                            <div class="input-field s12">
                                <input type="password" name="password_confirmation" class="validate">
                                <label>Confirm password</label>
                            </div>
                        </div>
                        <div>
                            <div class="input-field s4">
                                <input type="submit" value="Register" class="waves-effect waves-light log-in-btn"> </div>
                        </div>
                        <div>
                            <div class="input-field s12"> <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#modal1">Are you a already member ? Login</a> </div>
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