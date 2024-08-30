<x-head />

<body>

    <section>
        <div class="ad-log-main">
            <div class="ad-log-in">
                <div class="ad-log-in-logo">
                    <a href="index-2.html"><img src="images/logo.png" alt=""></a>
                </div>
                <div class="ad-log-in-con">
                    <div class="log-in-pop-right" style="width:100% !important;">
                        <h4>Reset Your New Password</h4>
                        <p>Don't share your password with anyone!</p>
                        <form action="{{ route('forget-password.update') }}" method="POST" class="s12">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div>
                                <div class="input-field s12">
                                    <input type="password" name="password" class="validate">
                                    <label>Password</label>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <div class="input-field s12">
                                    <input type="password" name="password_confirmation" class="validate">
                                    <label>Confirm password</label>
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <div class="input-field s4">
                                    <input type="submit" value="Update" class="waves-effect waves-light log-in-btn">
                                </div>
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
