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
        <h1>Cart page</h1>
    </div>
    <!-- /page_header -->
    <table class="table table-striped cart-list">
                        <thead>
                            <tr>
                                <th>
                                    Product
                                </th>
                                <th>
                                    Price
                                </th>
                                <th>
                                    Quantity
                                </th>
                                <th>
                                    Subtotal
                                </th>
                                <th>
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="thumb_cart">
                                        <img src="client/img/products/product_placeholder_square_small.jpg" data-src="client/img/products/shoes/1.jpg" class="lazy" alt="Image">
                                    </div>
                                    <span class="item_cart">Armor Air x Fear</span>
                                </td>
                                <td>
                                    <strong>$140.00</strong>
                                </td>
                                <td>
                                    <div class="numbers-row">
                                        <input type="text" value="1" id="quantity_1" class="qty2" name="quantity_1">
                                    <div class="inc button_inc">+</div><div class="dec button_inc">-</div></div>
                                </td>
                                <td>
                                    <strong>$140.00</strong>
                                </td>
                                <td class="options">
                                    <a href="#"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="thumb_cart">
                                        <img src="client/img/products/product_placeholder_square_small.jpg" data-src="client/img/products/shoes/2.jpg" class="lazy" alt="Image">
                                    </div>
                                    <span class="item_cart">Armor Okwahn II</span>
                                </td>
                                <td>
                                    <strong>$110.00</strong>
                                </td>
                                <td>
                                    <div class="numbers-row">
                                        <input type="text" value="1" id="quantity_2" class="qty2" name="quantity_2">
                                    <div class="inc button_inc">+</div><div class="dec button_inc">-</div></div>
                                </td>
                                <td>
                                    <strong>$110.00</strong>
                                </td>
                                <td class="options">
                                    <a href="#"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="thumb_cart">
                                        <img src="client/img/products/product_placeholder_square_small.jpg" data-src="client/img/products/shoes/3.jpg" class="lazy" alt="Image">
                                    </div>
                                    <span class="item_cart">Armor Air Wildwood ACG</span>
                                </td>
                                <td>
                                    <strong>$90.00</strong>
                                </td>
                                
                                <td>
                                    <div class="numbers-row">
                                        <input type="text" value="1" id="quantity_3" class="qty2" name="quantity_3">
                                    <div class="inc button_inc">+</div><div class="dec button_inc">-</div></div>
                                </td>
                                <td>
                                    <strong>$90.00</strong>
                                </td>
                                <td class="options">
                                    <a href="#"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="row add_top_30 flex-sm-row-reverse cart_actions">
                    <div class="col-sm-4 text-end">
                        <button type="button" class="btn_1 gray">Update Cart</button>
                    </div>
                        <div class="col-sm-8">
                        <div class="apply-coupon">
                            <div class="form-group">
                                <div class="row g-2">
                                    <div class="col-md-6"><input type="text" name="coupon-code" value="" placeholder="Promo code" class="form-control"></div>
                                    <div class="col-md-4"><button type="button" class="btn_1 outline">Apply Coupon</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /cart_actions -->

    </div>
    <!-- /container -->
    
    <div class="box_cart">
        <div class="container">
        <div class="row justify-content-end">
            <div class="col-xl-4 col-lg-4 col-md-6">
        <ul>
            <li>
                <span>Subtotal</span> $240.00
            </li>
            <li>
                <span>Shipping</span> $7.00
            </li>
            <li>
                <span>Total</span> $247.00
            </li>
        </ul>
        <a href="checkout.html" class="btn_1 full-width cart">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /box_cart -->
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
    <link href="client/css/cart.css" rel="stylesheet">

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
</main>
@endsection