<head>
    {{-- <title>{{ $title }}</title> --}}
    <title name="title">Forgot Password</title>
    <!-- META TAGS -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:url" content="https://piueducation.org">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Phaung Daw Oo International University">
    <meta property="og:description"
        content="Phaung Daw Oo University is providing the best education for all students in Myanmar and students from oversea.">
    <meta property="og:image" content="{{ asset('images/h-about.jpg') }}">
    <meta name="keyword"
        content="Phaung Daw Oo International University, PIU Myanmar, Phaung Daw Oo, PIU Buddhist Studies, Education for all">
    <!-- FAV ICON(BROWSER TAB ICON) -->
    <link rel="shortcut icon" href="{{ asset('images/fav.ico') }}" type="image/x-icon">
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700%7CJosefin+Sans:600,700"
        rel="stylesheet">
    <!-- FONTAWESOME ICONS -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <!-- ALL CSS FILES -->
    <link href="{{ asset('css/materialize.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style1.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style-mob.css') }}" rel="stylesheet" />

    <!-- OG TAGS -->
    <meta property="og:image" content="{{ asset('images/h-about.jpg') }}">
</head>


<body>

    <section>
        <div class="ad-log-main">
            <div class="ad-log-in">
                <div class="ad-log-in-logo">
                    <a href="/"><img src="{{ asset('images/fav.ico') }}" width="100" alt=""></a>
                </div>
                <div class="reset-link-sent-card">
                    <div class="reset-link-sent">
                        <h4>Your reset password link has been sent successfully to your email. Please check your email
                            and change new password.</h4>
                        <div>
                            <div class="input-field s4">
                                <i class="waves-effect waves-light log-in-btn waves-input-wrapper" style="">
                                    <a href="/" class="">Back</a>
                                </i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Import jQuery before materialize.js-->
    <script src="{{ asset('/js/main.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/materialize.min.js') }}"></script>
    <script src="{{ asset('/js/custom.js') }}"></script>
    <script src="{{ asset('/js/ckeditor.js') }}"></script>
</body>


</html>
