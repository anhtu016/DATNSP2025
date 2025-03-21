@extends('client.layout.default')
@section('content')
    
<main class="bg_gray">
    <div class="top_banner general">
        <div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.1)">
            <div class="container">
                <div class="row justify-content-end">
                    <div class="col-lg-5 col-md-6 text-end">
                        <h1>Dolor docendi fuisset ad movet mucius diceret et</h1>
                    </div>
                </div>
            </div>
        </div>
        <img src="client/img/top_about.jpg" class="img-fluid" alt="">
    </div>
    <!--/top_banner-->
    
    <div class="bg_white">
    <div class="container margin_90_0">
        <div class="row justify-content-between align-items-center flex-lg-row-reverse content_general_row">
            <div class="col-lg-5 text-center">
                <figure><img src="client/img/about_placeholder.jpg" data-src="client/img/about_1.svg" alt="" class="img-fluid lazy" width="350" height="268"></figure>
            </div>
            <div class="col-lg-6">
                <h2>Per quot choro cetero eu</h2>
                <p class="lead">Eu qui mundi lucilius petentium, mea amet libris prodesset in.</p>
                <p>His dolor docendi fuisset ad, movet mucius diceret et qui. Esse ferri integre sit id. Nec iusto eleifend definitionem ne, persius argumentum sed ut. Ut mel dicta latine. Ut dicta tempor omittantur pro, ne mea magna idque. Nulla ancillae et his, ei vim lorem accusam.</p>
            </div>
        </div>
        <!--/row-->
        <div class="row justify-content-between align-items-center content_general_row">
            <div class="col-lg-5 text-start">
                <figure><img src="client/img/about_placeholder.jpg" data-src="client/img/about_3.svg" alt="" class="img-fluid lazy" width="350" height="268"></figure>
            </div>
            <div class="col-lg-6">
                <h2>Per quot choro cetero eu</h2>
                <p class="lead">Eu qui mundi lucilius petentium, mea amet libris prodesset in.</p>
                <p>His dolor docendi fuisset ad, movet mucius diceret et qui. Esse ferri integre sit id. Nec iusto eleifend definitionem ne, persius argumentum sed ut. Ut mel dicta latine. Ut dicta tempor omittantur pro, ne mea magna idque. Nulla ancillae et his, ei vim lorem accusam.</p>
            </div>
        </div>
        <!--/row-->
        <div class="row justify-content-between align-items-center flex-lg-row-reverse content_general_row">
            <div class="col-lg-5 text-center">
                <figure><img src="client/img/about_placeholder.jpg" data-src="client/img/about_2.svg" alt="" class="img-fluid lazy" width="350" height="316"></figure>
            </div>
            <div class="col-lg-6">
                <h2>Per quot choro cetero eu</h2>
                <p class="lead">Eu qui mundi lucilius petentium, mea amet libris prodesset in.</p>
                <p>His dolor docendi fuisset ad, movet mucius diceret et qui. Esse ferri integre sit id. Nec iusto eleifend definitionem ne, persius argumentum sed ut. Ut mel dicta latine.</p>
                <ul class="list_ok">
                    <li>At pro tale omnes iuvaret</li>
                    <li>Persius argumentum sed ut tempor omittantur pro</li>
                    <li>His dolor docendi fuisset ad, movet mucius</li>
                </ul>
            </div>
        </div>
        <!--/row-->
    </div>
    <!--/container-->
        
    </div>
    <!--/bg_white-->
    <div id="carousel-home">
        <div class="owl-carousel owl-theme">
            <div class="owl-slide cover" style="background-image: url(client/img/testimonial_1.jpg);">
                <div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                    <div class="container">
                        <div class="row justify-content-center justify-content-md-start">
                            <div class="col-lg-6 static">
                                <div class="slide-text white">
                                    <h2 class="owl-slide-animated owl-slide-title">"Awesome Experience"</h2>
                                    <p class="owl-slide-animated owl-slide-subtitle">
                                        <em>His dolor docendi fuisset ad, movet mucius diceret et qui. Esse ferri integre sit id. Nec iusto eleifend definitionem ne, persius argumentum sed ut.</em>
                                    </p>
                                    <div class="owl-slide-animated owl-slide-cta"><small>Susan - Photographer</small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/owl-slide-->
            <div class="owl-slide cover" style="background-image: url(client/img/testimonial_2.jpg);">
                <div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                    <div class="container">
                        <div class="row justify-content-center justify-content-md-start">
                            <div class="col-lg-6 static">
                                <div class="slide-text white">
                                    <h2 class="owl-slide-animated owl-slide-title">"Great Support"</h2>
                                    <p class="owl-slide-animated owl-slide-subtitle">
                                        <em>His dolor docendi fuisset ad, movet mucius diceret et qui. Esse ferri integre sit id. Nec iusto eleifend definitionem ne.</em>
                                    </p>
                                    <div class="owl-slide-animated owl-slide-cta">Mary - Doctor</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/owl-slide-->
            <div class="owl-slide cover" style="background-image: url(client/img/testimonial_3.jpg);">
                <div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(255, 255, 255, 0.5)">
                    <div class="container">
                        <div class="row justify-content-center justify-content-md-start">
                            <div class="col-lg-12 static">
                                <div class="slide-text text-center black">
                                    <h2 class="owl-slide-animated owl-slide-title">"Satisfied"</h2>
                                    <p class="owl-slide-animated owl-slide-subtitle">
                                        <em>His dolor docendi fuisset ad, movet mucius diceret et qui. Esse ferri integre sit id.</em>
                                    </p>
                                    <div class="owl-slide-animated owl-slide-cta">Katrin - Student</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/owl-slide-->
            </div>
        </div>
        <div id="icon_drag_mobile"></div>
    </div>
    <!--/carousel-->
</main>
 <!--Css-->
    
    @push('css')
        <!-- Favicons-->
        <link rel="shortcut icon" href="client/img/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon" type="image/x-icon" href="client/img/apple-touch-icon-57x57-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="client/img/apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="client/img/apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="client/img/apple-touch-icon-144x144-precomposed.png">
        
        <!-- GOOGLE WEB FONT -->
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&amp;display=swap" rel="stylesheet">

        <!-- BASE CSS -->
        <link rel="preload" href="client/css/bootstrap.min.css" as="style">
        <link rel="stylesheet" href="client/css/bootstrap.min.css">
        <link href="client/css/style.css" rel="stylesheet">

        <!-- SPECIFIC CSS -->
        <link href="client/css/about.css" rel="stylesheet">

        <!-- YOUR CUSTOM CSS -->
        <link href="client/css/custom.css" rel="stylesheet">
    @endpush
 <!--ENd Css-->

 <!--JS-->
    @push('js')
        <script src="client/js/common_scripts.min.js"></script>
        <script src="client/js/main.js"></script>

        <!-- SPECIFIC SCRIPTS -->
        <script src="client/js/carousel-home.js"></script>
    @endpush
 <!--ENd JS-->
@endsection