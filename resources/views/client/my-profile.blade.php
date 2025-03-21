@extends('client.layout.default')
@section('content')
    
<main class="bg_gray">
    <div class="container margin_30">
    <div class="page_header">
        <div class="breadcrumbs">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Category</a></li>
                <li>Page active</li>
            </ul>
        </div>
        <h1>My Profile page</h1>
    </div>
    <!-- /page_header -->

    <div class="row">
        <div class="col-lg-6">
            <div class="box_profile_details">
                <h3>User Details</h3>
                <div class="data_profile">
                    <p>Name: Jhon<p>
                        <p>Last Name: Doe<p>
                        <p>Telephone: 0948433423</p>
                </div>
                <p><a href="#0">Edit/Change</a></p>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="box_profile_details">
                <h3>Login Details</h3>
                <div class="data_profile">
                    <p>Email Address: user@gmail.com<p>
                    <p>Password: th******er</p>
                    <p></p>
                </div>
                <p><a href="#0">Edit/Change</a></p>
            </div>
        </div>
    </div>
    <!-- /row -->

    <div class="row">
        <div class="col-lg-6">
            <div class="box_profile_details">
                <h3>Billing Address</h3>
                <div class="data_profile">
                    <p>Address: 97845 Baker st. 567<p>
                    <p>City/Country: Los Angeles - US</p>
                    <p>Postal code: 60515</p>
                </div>
                <p><a href="#0">Edit/Change</a></p>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="box_profile_details">
                <h3>Shipping Address</h3>
                <div class="data_profile">
                    <p>Address: 97845 Baker st. 567<p>
                    <p>City/Country: Los Angeles - US</p>
                    <p>Postal code: 60515</p>
                </div>
                <p><a href="#0">Edit/Change</a></p>
            </div>
        </div>
    </div>
    <!-- /row -->

    <div class="row">
        <div class="col-lg-4 col-md-6">
            <a class="box_topic" href="my-orders.html">
                <i class="ti-bag"></i>
                <h3>My Orders</h3>
            </a>
        </div>
        <div class="col-lg-4 col-md-6">
            <a class="box_topic" href="my-wishlist.html">
                <i class="ti-heart"></i>
                <h3>My Wishlist</h3>
            </a>
        </div>
        <div class="col-lg-4 col-md-6">
            <a class="box_topic" href="leave-review.html">
                <i class="ti-comment"></i>
                <h3>Leave a review</h3>
            </a>
        </div>
    </div>
    <!-- /row -->

    </div>
    <!-- /container -->
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
    <link href="client/css/account.css" rel="stylesheet">

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