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
        <h1>My Orders page</h1>
    </div>
    <!-- /page_header -->
    <table class="table table-striped product-list mb-5">
        <thead>
            <tr>
                <th>
                    Product
                </th>
                <th>
                    Price
                </th>
                <th>
                    Order id
                </th>
                <th>
                    Status
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="thumb_product">
                        <img src="client/img/products/product_placeholder_square_small.jpg" data-src="client/img/products/shoes/1.jpg"
                            class="lazy" alt="Image">
                    </div>
                    <span class="item_product"><a href="#">Armor Air x Fear</a></span>
                </td>
                <td>
                    <strong>$140.00</strong>
                </td>
                <td>
                    <strong>#ew33r4</strong>
                </td>
                <td>
                    <span class="badge rounded-pill bg-success">Shipped</span>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="thumb_product">
                        <img src="client/img/products/product_placeholder_square_small.jpg" data-src="client/img/products/shoes/1.jpg"
                            class="lazy" alt="Image">
                    </div>
                    <span class="item_product"><a href="#">Armor Air x Fear</a></span>
                </td>
                <td>
                    <strong>$140.00</strong>
                </td>
                <td>
                    <strong>#ew33r4</strong>
                </td>
                <td>
                    <span class="badge rounded-pill bg-secondary">Cancelled</span>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="thumb_product">
                        <img src="client/img/products/product_placeholder_square_small.jpg" data-src="client/img/products/shoes/1.jpg"
                            class="lazy" alt="Image">
                    </div>
                    <span class="item_product"><a href="#">Armor Air x Fear</a></span>
                </td>
                <td>
                    <strong>$140.00</strong>
                </td>
                <td>
                    <strong>#ew33r4</strong>
                </td>
                <td>
                    <span class="badge rounded-pill bg-danger">Pending</span>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="thumb_product">
                        <img src="client/img/products/product_placeholder_square_small.jpg" data-src="client/img/products/shoes/1.jpg"
                            class="lazy" alt="Image">
                    </div>
                    <span class="item_product"><a href="#">Armor Air x Fear</a></span>
                </td>
                <td>
                    <strong>$140.00</strong>
                </td>
                <td>
                    <strong>#ew33r4</strong>
                </td>
                <td>
                    <span class="badge rounded-pill bg-danger">Pending</span>
                </td>
            </tr>
        </tbody>
    </table>
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