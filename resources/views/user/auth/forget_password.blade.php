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
                        <p>Please enter your credentials</p>
                        <form class="s12" action="{{ route('forget-password.form.submit') }}" method="POST">
                          @csrf
                          @method('POST')
                        <div>
                            <div class="input-field s12">
                                <input type="email" name="email" class="validate" required>
                                <label>Enter Your Email</label>
                            </div>
                        </div>
                        <div>
                            <div class="input-field s4">
                                <i class="waves-effect waves-light log-in-btn waves-input-wrapper" style=""><input type="submit" value="Submit" class="waves-button-input"></i> </div>
                        </div>
                        <div>
                            <div class="input-field s12"> <a href="{{ route('login') }}">Login</a> | <a href="{{ route('register') }}">Create a new account</a> </div>
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
