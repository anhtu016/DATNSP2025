@extends('client.layout.default')
@section('content')
    <main>
        <div class="container mt-5">
            <div class="row g-4">
                <!-- Ảnh sản phẩm -->
                <div class="col-md-6 d-flex align-items-center justify-content-center">
                    <div class="border rounded shadow-sm p-3 bg-white">
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                            class="img-fluid rounded" style="max-height: 400px; object-fit: contain;">
                    </div>
                </div>

                <!-- Thông tin sản phẩm -->
                <div class="col-md-6">
                    <div class="card shadow-sm p-4">
                        <h2 class="mb-3">{{ $product->name }}</h2>
                        <p class="h5 text-danger fw-bold mb-3">{{ number_format($product->price) }} VND</p>
                        <p><strong>Mô tả ngắn:</strong> {{ $product->short_description }}</p>
                        <p><strong>Chi tiết:</strong> {!! $product->description !!}</p>
                        @if (Auth::check())
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                                @csrf

                                @foreach ($attributes as $attrName => $values)
                                    <div class="mb-3">
                                        <label class="form-label">{{ ucfirst($attrName) }}:</label>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($values as $value)
                                                @php
                                                    $colorName = strtolower(trim($value->value));
                                                    $colorMap = [
                                                        'red' => '#FF0000',
                                                        'blue' => '#0000FF',
                                                        'green' => '#00FF00',
                                                        'black' => '#000000',
                                                        'white' => '#FFFFFF',
                                                        'yellow' => '#FFFF00',
                                                        'gray' => '#808080',
                                                        'xanh' => '#0000FF',
                                                        'đỏ' => '#FF0000',
                                                        'đen' => '#000000',
                                                        'trắng' => '#FFFFFF',
                                                        'vàng' => '#FFFF00',
                                                    ];
                                                    $colorCode = $colorMap[$colorName] ?? '#ccc';
                                                    $isColor = strtolower($attrName) === 'color';
                                                @endphp

                                                <input type="radio" class="btn-check"
                                                    name="attributes[{{ $attrName }}]"
                                                    id="{{ $attrName }}_{{ $value->id }}"
                                                    value="{{ $value->id }}" required>

                                                <label class="btn {{ $isColor ? 'color-swatch' : 'btn-outline-dark' }}"
                                                    for="{{ $attrName }}_{{ $value->id }}"
                                                    @if ($isColor) style="background-color: {{ $colorCode }}" @endif>
                                                    @unless ($isColor)
                                                        {{ $value->value }}
                                                    @endunless
                                                </label>
                                            @endforeach
                                        </div>
=======
<main>
    <div class="container margin_30">
        {{-- <div class="countdown_inner">-20% This offer ends in <div data-countdown="2019/05/15" class="countdown">
            </div>
        </div> --}}
        <div class="row">
          
            <div class="col-md-6">
                <div class="all">
                    <div class="slider">
                        <div class="owl-carousel owl-theme main">
                            <div></div>
                        </div>
                        <div class="left nonl"><i class="ti-angle-left"></i></div>
                        <div class="right"><i class="ti-angle-right"></i></div>
                    </div>
                    <div class="slider-two">
                        <div class="owl-carousel owl-theme thumbs">
                            <div style="background-image:url(client/img/products/shoes/1.jpg);" class="item active">
                            </div>
                            <div style="background-image:url(client/img/products/shoes/2.jpg);" class="item"></div>
                            <div style="background-image:url(client/img/products/shoes/3.jpg);" class="item"></div>
                            <div style="background-image:url(client/img/products/shoes/4.jpg);" class="item"></div>
                            <div style="background-image:url(client/img/products/shoes/5.jpg);" class="item"></div>
                            <div style="background-image:url(client/img/products/shoes/6.jpg);" class="item"></div>
                        </div>
                        <div class="left-t nonl-t"></div>
                        <div class="right-t"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Category</a></li>
                        <li>Page active</li>
                    </ul>
                </div>
                <!-- /page_header -->
                <div class="prod_info">
                    
                        <h1>{{$detailProduct->name}}</h1>
                    <span class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i
                            class="icon-star voted"></i><i class="icon-star voted"></i><i
                            class="icon-star"></i><em>4 reviews</em>
                    </span>
                    <p><small>MÃ: {{$detailProduct->sku}}</small><br>{{$detailProduct->description}}</p>
                    <div class="prod_options">
                        <div class="row">
                            <label class="col-xl-5 col-lg-5  col-md-6 col-6 pt-0"><strong>Color</strong></label>
                            <div class="col-xl-4 col-lg-5 col-md-6 col-6 colors">
                                <ul>
                                    <select name="color" id="" class="col-xl-4 col-lg-5 col-md-6 col-6 colors">
                                                                            
                                    </select>
                                    
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-xl-5 col-lg-5 col-md-6 col-6"><strong>Size</strong> - Size Guide
                                <a href="#0" data-bs-toggle="modal" data-bs-target="#size-modal"><i
                                        class="ti-help-alt"></i></a></label>
                            <div class="col-xl-4 col-lg-5 col-md-6 col-6">
                                <div class="custom-select-form">
                                    <select class="wide">
                                        <option value="" selected>Small (S)</option>
                                        <option value="">M</option>
                                        <option value=" ">L</option>
                                        <option value=" ">XL</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-xl-5 col-lg-5  col-md-6 col-6"><strong>Số lượng: {{$detailProduct->quantity}}</strong></label>
                            <div class="col-xl-4 col-lg-5 col-md-6 col-6">
                                <div class="numbers-row">
                                    <input type="text" value="1" id="quantity_1" class="qty2" name="quantity_1">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-lg-5 col-md-6">
                            <div class="price_main"><span class="new_price">{{$detailProduct->price}}</span><span
                                    class="percentage"></span> <span class="old_price">{{$detailProduct->sell_price}}</span></div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="btn_add_to_cart"><a href="#0" class="btn_1">Add to Cart</a></div>
                        </div>
                    </div>
                </div>
                <!-- /prod_info -->
                <div class="product_actions">
                    <ul>
                        <li>
                            <a href="#"><i class="ti-heart"></i><span>Add to Wishlist</span></a>
                        </li>
                        <li>
                            <a href="#"><i class="ti-control-shuffle"></i><span>Add to Compare</span></a>
                        </li>
                    </ul>
                </div>
                <!-- /product_actions -->
            </div>
           
            
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->

    <div class="tabs_product">
        <div class="container">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a id="tab-A" href="#pane-A" class="nav-link active" data-bs-toggle="tab"
                        role="tab">Description</a>
                </li>
                <li class="nav-item">
                    <a id="tab-B" href="#pane-B" class="nav-link" data-bs-toggle="tab" role="tab">Reviews</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- /tabs_product -->
    <div class="tab_content_wrapper">
        <div class="container">
            <div class="tab-content" role="tablist">
                <div id="pane-A" class="card tab-pane fade active show" role="tabpanel" aria-labelledby="tab-A">
                    <div class="card-header" role="tab" id="heading-A">
                        <h5 class="mb-0">
                            <a class="collapsed" data-bs-toggle="collapse" href="#collapse-A"
                                aria-expanded="false" aria-controls="collapse-A">
                                Description
                            </a>
                        </h5>
                    </div>
                    <div id="collapse-A" class="collapse" role="tabpanel" aria-labelledby="heading-A">
                        <div class="card-body">
                            <div class="row justify-content-between">
                                <div class="col-lg-6">
                                    <h3>Details</h3>
                                    <p>Lorem ipsum dolor sit amet, in eleifend <strong>inimicus
                                            elaboraret</strong> his, harum efficiendi mel ne. Sale percipit
                                        vituperata ex mel, sea ne essent aeterno sanctus, nam ea laoreet civibus
                                        electram. Ea vis eius explicari. Quot iuvaret ad has.</p>
                                    
                                </div>
                                <div class="col-lg-5">
                                    <h3>Specifications</h3>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Color</strong></td>
                                                    <td>Blue, Purple</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Size</strong></td>
                                                    <td>150x100x100</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Weight</strong></td>
                                                    <td>0.6kg</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Manifacturer</strong></td>
                                                    <td>Manifacturer</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach

                                <div class="mb-3">
                                    <label for="quantity">Số lượng:</label>
                                    <input type="number" name="quantity" class="form-control" value="1" min="1"
                                        max="{{ $product->quantity }}">
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ hàng
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">Đăng nhập để mua hàng</a>
                        @endif
                    </div>
                </div>
                <!-- /TAB A -->
                <div id="pane-B" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
                    <div class="card-header" role="tab" id="heading-B">
                        <h5 class="mb-0">
                            <a class="collapsed" data-bs-toggle="collapse" href="#collapse-B"
                                aria-expanded="false" aria-controls="collapse-B">
                                Reviews
                            </a>
                        </h5>
                    </div>
                    <div id="collapse-B" class="collapse" role="tabpanel" aria-labelledby="heading-B">
                        <div class="card-body">
                            <div class="row justify-content-between">
                                <div class="col-lg-6">
                                    @foreach ($loadReviews as $reviews)
                                    <div class="review_content">
                                        <div class="clearfix add_bottom_10">
                                            <span class="rating">                  
                                                @for($i = 1; $i <= $reviews->rating; $i++)
                                                    <i class="icon-star filled"></i>
                                                @endfor
                                                <em>{{ number_format($reviews->rating, 1) }}/5.0 (đánh giá)</em>
                                            </span>
                                        </div>
                                        <h4>{{$reviews->user->name}}</h4>
                                        <p>{{$reviews->description}}</p>
                                    
                                    </div>
                                    @endforeach
                                </div>

                            </div>
                            <!-- /row -->
                            
                            <!-- /row -->
                            <p class="text-end"><a href="leave-review.html" class="btn_1">Leave a review</a></p>
                        </div>
                        <!-- /card-body -->
                    </div>
                </div>
                <!-- /tab B -->
            </div>
        </div>


        <!-- /row -->
        </div>
        <!-- /container -->

        <div class="tabs_product">
            <div class="container">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a id="tab-A" href="#pane-A" class="nav-link active" data-bs-toggle="tab"
                            role="tab">Description</a>
                    </li>
                    <li class="nav-item">
                        <a id="tab-B" href="#pane-B" class="nav-link" data-bs-toggle="tab" role="tab">Reviews</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /tabs_product -->
        <div class="tab_content_wrapper">
            <div class="container">
                <div class="tab-content" role="tablist">
                    <div id="pane-A" class="card tab-pane fade active show" role="tabpanel" aria-labelledby="tab-A">
                        <div class="card-header" role="tab" id="heading-A">
                            <h5 class="mb-0">
                                <a class="collapsed" data-bs-toggle="collapse" href="#collapse-A" aria-expanded="false"
                                    aria-controls="collapse-A">
                                    Description
                                </a>
                            </h5>
                        </div>
                        <div id="collapse-A" class="collapse" role="tabpanel" aria-labelledby="heading-A">
                            <div class="card-body">
                                <div class="row justify-content-between">
                                    <div class="col-lg-6">
                                        <h3>Details</h3>
                                        <p>Lorem ipsum dolor sit amet, in eleifend <strong>inimicus
                                                elaboraret</strong> his, harum efficiendi mel ne. Sale percipit
                                            vituperata ex mel, sea ne essent aeterno sanctus, nam ea laoreet civibus
                                            electram. Ea vis eius explicari. Quot iuvaret ad has.</p>
                                        <p>Vis ei ipsum conclusionemque. Te enim suscipit recusabo mea, ne vis mazim
                                            aliquando, everti insolens at sit. Cu vel modo unum quaestio, in vide
                                            dicta has. Ut his laudem explicari adversarium, nisl <strong>laboramus
                                                hendrerit</strong> te his, alia lobortis vis ea.</p>
                                        <p>Perfecto eleifend sea no, cu audire voluptatibus eam. An alii praesent
                                            sit, nobis numquam principes ea eos, cu autem constituto suscipiantur
                                            eam. Ex graeci elaboraret pro. Mei te omnis tantas, nobis viderer
                                            vivendo ex has.</p>
                                    </div>
                                    <div class="col-lg-5">
                                        <h3>Specifications</h3>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td><strong>Color</strong></td>
                                                        <td>Blue, Purple</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Size</strong></td>
                                                        <td>150x100x100</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Weight</strong></td>
                                                        <td>0.6kg</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Manifacturer</strong></td>
                                                        <td>Manifacturer</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /table-responsive -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /TAB A -->
                    <div id="pane-B" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
                        <div class="card-header" role="tab" id="heading-B">
                            <h5 class="mb-0">
                                <a class="collapsed" data-bs-toggle="collapse" href="#collapse-B" aria-expanded="false"
                                    aria-controls="collapse-B">
                                    Reviews
                                </a>
                            </h5>
                        </div>
                        <div id="collapse-B" class="collapse" role="tabpanel" aria-labelledby="heading-B">
                            <div class="card-body">
                                <div class="row justify-content-between">
                                    <div class="col-lg-6">
                                        <div class="review_content">
                                            <div class="clearfix add_bottom_10">
                                                <span class="rating"><i class="icon-star"></i><i class="icon-star"></i><i
                                                        class="icon-star"></i><i class="icon-star"></i><i
                                                        class="icon-star"></i><em>5.0/5.0</em></span>
                                                <em>Published 54 minutes ago</em>
                                            </div>
                                            <h4>"Commpletely satisfied"</h4>
                                            <p>Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod
                                                scaevola sea. Et nec tantas accusamus salutatus, sit commodo veritus
                                                te, erat legere fabulas has ut. Rebum laudem cum ea, ius essent
                                                fuisset ut. Viderer petentium cu his.</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="review_content">
                                            <div class="clearfix add_bottom_10">
                                                <span class="rating"><i class="icon-star"></i><i class="icon-star"></i><i
                                                        class="icon-star"></i><i class="icon-star empty"></i><i
                                                        class="icon-star empty"></i><em>4.0/5.0</em></span>
                                                <em>Published 1 day ago</em>
                                            </div>
                                            <h4>"Always the best"</h4>
                                            <p>Et nec tantas accusamus salutatus, sit commodo veritus te, erat
                                                legere fabulas has ut. Rebum laudem cum ea, ius essent fuisset ut.
                                                Viderer petentium cu his.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- /row -->
                                <div class="row justify-content-between">
                                    <div class="col-lg-6">
                                        <div class="review_content">
                                            <div class="clearfix add_bottom_10">
                                                <span class="rating"><i class="icon-star"></i><i class="icon-star"></i><i
                                                        class="icon-star"></i><i class="icon-star"></i><i
                                                        class="icon-star empty"></i><em>4.5/5.0</em></span>
                                                <em>Published 3 days ago</em>
                                            </div>
                                            <h4>"Outstanding"</h4>
                                            <p>Eos tollit ancillae ea, lorem consulatu qui ne, eu eros eirmod
                                                scaevola sea. Et nec tantas accusamus salutatus, sit commodo veritus
                                                te, erat legere fabulas has ut. Rebum laudem cum ea, ius essent
                                                fuisset ut. Viderer petentium cu his.</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="review_content">
                                            <div class="clearfix add_bottom_10">
                                                <span class="rating"><i class="icon-star"></i><i class="icon-star"></i><i
                                                        class="icon-star"></i><i class="icon-star"></i><i
                                                        class="icon-star"></i><em>5.0/5.0</em></span>
                                                <em>Published 4 days ago</em>
                                            </div>
                                            <h4>"Excellent"</h4>
                                            <p>Sit commodo veritus te, erat legere fabulas has ut. Rebum laudem cum
                                                ea, ius essent fuisset ut. Viderer petentium cu his.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- /row -->
                                <p class="text-end"><a href="leave-review.html" class="btn_1">Leave a review</a></p>
                            </div>
                            <!-- /card-body -->
                        </div>
                    </div>
                    <!-- /tab B -->
                </div>
                <!-- /tab-content -->
            </div>
            <!-- /container -->
        </div>
        <!-- /tab_content_wrapper -->

        <div class="container margin_60_35">
            <div class="main_title">
                <h2>Related</h2>
                <span>Products</span>
                <p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
            </div>
            <div class="owl-carousel owl-theme products_carousel">
                <div class="item">
                    <div class="grid_item">
                        <span class="ribbon new">New</span>
                        <figure>
                            <a href="product-detail-1.html">
                                <img class="owl-lazy" src="client/img/products/product_placeholder_square_medium.jpg"
                                    data-src="client/img/products/shoes/4.jpg" alt="">
                            </a>
                        </figure>
                        <div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i
                                class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i>
                        </div>
                        <a href="product-detail-1.html">
                            <h3>ACG React Terra</h3>
                        </a>
                        <div class="price_box">
                            <span class="new_price">$110.00</span>
                        </div>
                        <ul>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Add to favorites"><i class="ti-heart"></i><span>Add to
                                        favorites</span></a></li>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Add to compare"><i class="ti-control-shuffle"></i><span>Add to
                                        compare</span></a></li>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Add to cart"><i class="ti-shopping-cart"></i><span>Add to cart</span></a>
                            </li>
                        </ul>
                    </div>
                    <!-- /grid_item -->
                </div>
                <!-- /item -->
                <div class="item">
                    <div class="grid_item">
                        <span class="ribbon new">New</span>
                        <figure>
                            <a href="product-detail-1.html">
                                <img class="owl-lazy" src="client/img/products/product_placeholder_square_medium.jpg"
                                    data-src="client/img/products/shoes/5.jpg" alt="">
                            </a>
                        </figure>
                        <div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i
                                class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i>
                        </div>
                        <a href="product-detail-1.html">
                            <h3>Air Zoom Alpha</h3>
                        </a>
                        <div class="price_box">
                            <span class="new_price">$140.00</span>
                        </div>
                        <ul>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Add to favorites"><i class="ti-heart"></i><span>Add to
                                        favorites</span></a></li>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Add to compare"><i class="ti-control-shuffle"></i><span>Add to
                                        compare</span></a></li>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Add to cart"><i class="ti-shopping-cart"></i><span>Add to cart</span></a>
                            </li>
                        </ul>
                    </div>
                    <!-- /grid_item -->
                </div>
                <!-- /item -->
                <div class="item">
                    <div class="grid_item">
                        <span class="ribbon hot">Hot</span>
                        <figure>
                            <a href="product-detail-1.html">
                                <img class="owl-lazy" src="client/img/products/product_placeholder_square_medium.jpg"
                                    data-src="client/img/products/shoes/8.jpg" alt="">
                            </a>
                        </figure>
                        <div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i
                                class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i>
                        </div>
                        <a href="product-detail-1.html">
                            <h3>Air Color 720</h3>
                        </a>
                        <div class="price_box">
                            <span class="new_price">$120.00</span>
                        </div>
                        <ul>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Add to favorites"><i class="ti-heart"></i><span>Add to
                                        favorites</span></a></li>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Add to compare"><i class="ti-control-shuffle"></i><span>Add to
                                        compare</span></a></li>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Add to cart"><i class="ti-shopping-cart"></i><span>Add to cart</span></a>
                            </li>
                        </ul>
                    </div>
                    <!-- /grid_item -->
                </div>
                <!-- /item -->
                <div class="item">
                    <div class="grid_item">
                        <span class="ribbon off">-30%</span>
                        <figure>
                            <a href="product-detail-1.html">
                                <img class="owl-lazy" src="client/img/products/product_placeholder_square_medium.jpg"
                                    data-src="client/img/products/shoes/2.jpg" alt="">
                            </a>
                        </figure>
                        <div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i
                                class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i>
                        </div>
                        <a href="product-detail-1.html">
                            <h3>Okwahn II</h3>
                        </a>
                        <div class="price_box">
                            <span class="new_price">$90.00</span>
                            <span class="old_price">$170.00</span>
                        </div>
                        <ul>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Add to favorites"><i class="ti-heart"></i><span>Add to
                                        favorites</span></a></li>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Add to compare"><i class="ti-control-shuffle"></i><span>Add to
                                        compare</span></a></li>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Add to cart"><i class="ti-shopping-cart"></i><span>Add to cart</span></a>
                            </li>
                        </ul>
                    </div>
                    <!-- /grid_item -->
                </div>
                <!-- /item -->
                <div class="item">
                    <div class="grid_item">
                        <span class="ribbon off">-50%</span>
                        <figure>
                            <a href="product-detail-1.html">
                                <img class="owl-lazy" src="client/img/products/product_placeholder_square_medium.jpg"
                                    data-src="client/img/products/shoes/3.jpg" alt="">
                            </a>
                        </figure>
                        <div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i
                                class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i>
                        </div>
                        <a href="product-detail-1.html">
                            <h3>Air Wildwood ACG</h3>
                        </a>
                        <div class="price_box">
                            <span class="new_price">$75.00</span>
                            <span class="old_price">$155.00</span>
                        </div>
                        <ul>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Add to favorites"><i class="ti-heart"></i><span>Add to
                                        favorites</span></a></li>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Add to compare"><i class="ti-control-shuffle"></i><span>Add to
                                        compare</span></a></li>
                            <li><a href="#0" class="tooltip-1" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Add to cart"><i class="ti-shopping-cart"></i><span>Add to cart</span></a>
                            </li>
                        </ul>
                    </div>
                    <!-- /grid_item -->
                </div>
                <!-- /item -->
            </div>
            <!-- /products_carousel -->
        </div>
        <!-- /container -->

        <div class="feat">
            <div class="container">
                <ul>
                    <li>
                        <div class="box">
                            <i class="ti-gift"></i>
                            <div class="justify-content-center">
                                <h3>Free Shipping</h3>
                                <p>For all oders over $99</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="box">
                            <i class="ti-wallet"></i>
                            <div class="justify-content-center">
                                <h3>Secure Payment</h3>
                                <p>100% secure payment</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="box">
                            <i class="ti-headphone-alt"></i>
                            <div class="justify-content-center">
                                <h3>24/7 Support</h3>
                                <p>Online top support</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!--/feat-->

    </main>
    <!--Css-->
    @push('css')
        <script>
            ! function(e, n, t) {
                "use strict";
                var o = "https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&amp;display=swap",
                    r = "__3perf_googleFonts_c2536";

                function c(e) {
                    (n.head || n.body).appendChild(e)
                }

                function a() {
                    var e = n.createElement("link");
                    e.href = o, e.rel = "stylesheet", c(e)
                }

                function f(e) {
                    if (!n.getElementById(r)) {
                        var t = n.createElement("style");
                        t.id = r, c(t)
                    }
                    n.getElementById(r).innerHTML = e
                }
                e.FontFace && e.FontFace.prototype.hasOwnProperty("display") ? (t[r] && f(t[r]), fetch(o).then(function(e) {
                    return e.text()
                }).then(function(e) {
                    return e.replace(/@font-face {/g, "@font-face{font-display:swap;")
                }).then(function(e) {
                    return t[r] = e
                }).then(f).catch(a)) : a()
            }(window, document, localStorage);
        </script>
        <!-- SPECIFIC CSS -->
        <link href="{{ asset('client/css/product_page.css') }}" rel="stylesheet">
    @endpush
    <!--ENd Css-->

    <!--JS-->
    @push('js')
        <!-- SPECIFIC SCRIPTS -->
        <script src="{{ asset('client/js/carousel_with_thumbs.js') }}"></script>
    @endpush
    <!--ENd JS-->
@endsection
