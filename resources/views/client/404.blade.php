@extends('client.layout.default')
@section('content')
    
<main class="bg_gray">
    <div id="error_page">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-xl-7 col-lg-9">
                    <img src="client/img/404.svg" alt="" class="img-fluid" width="400" height="212">
                    <p>The page you're looking is not founded!</p>
                    <form>
                        <div class="search_bar">
                            <input type="text" class="form-control" placeholder="What are you looking for?">
                            <input type="submit" value="Search">
                        </div>
                    </form>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /error_page -->
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
    <link href="client/css/error_track.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="client/css/custom.css" rel="stylesheet">
@endpush
     <!--ENd Css-->

     <!--JS-->
@push('js')
     <!-- COMMON SCRIPTS -->
     <script src="client/js/common_scripts.min.js"></script>
     <script src="client/js/main.js"></script>
@endpush
     <!--ENd JS-->
@endsection