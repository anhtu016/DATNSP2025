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
                
                        @auth
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
                                                        'red' => '#FF0000', 'blue' => '#0000FF', 'green' => '#00FF00',
                                                        'black' => '#000000', 'white' => '#FFFFFF', 'yellow' => '#FFFF00',
                                                        'gray' => '#808080', 'xanh' => '#0000FF', 'đỏ' => '#FF0000',
                                                        'đen' => '#000000', 'trắng' => '#FFFFFF', 'vàng' => '#FFFF00',
                                                    ];
                                                    $colorCode = $colorMap[$colorName] ?? '#ccc';
                                                    $isColor = strtolower($attrName) === 'color';
                                                @endphp
                
                                                <input type="radio" class="btn-check" name="attributes[{{ $attrName }}]"
                                                       id="{{ $attrName }}_{{ $value->id }}" value="{{ $value->id }}" required>
                
                                                <label class="btn {{ $isColor ? 'color-swatch' : 'btn-outline-dark' }}"
                                                       for="{{ $attrName }}_{{ $value->id }}"
                                                       @if($isColor) style="background-color: {{ $colorCode }}" @endif>
                                                    @unless($isColor)
                                                        {{ $value->value }}
                                                    @endunless
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                                <div class="mb-3">
                                    <p>Số lượng có sẵn: 
                                        <span class="quantity">
                                            {{ $product->quantity }} sản phẩm
                                        </span>
                                    </p>
                                    {{-- cảnh báo sắp hết --}}
                                    @if (isset($isLowStock) && $isLowStock)
                                    <div class="alert alert-warning"> 
                                        <strong>Cảnh báo:</strong> Sản phẩm này gần hết hàng ! Chỉ còn {{ $detailProduct->quantity }} sản phẩm.
                                    </div>
                                @endif
                                
                                </div>
                                <div class="mb-3">
                                    <label for="quantity">Số lượng:</label>
                                    <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $product->quantity }}">
                                </div>
                
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ hàng
                                </button>
                            </form>
                        @else
                            <div class="alert alert-warning mt-4">
                                Bạn cần <a href="{{ route('login') }}" class="fw-bold text-decoration-underline">đăng nhập</a> để mua hàng.
                            </div>
                        @endauth
                    </div>
                </div>
                
            </div>
        </div>
        
        
        <!-- /row -->
    </div>
    <!-- /container -->

    <div class="tabs_product">
        <div class="container">
            <ul class="nav nav-tabs" role="tablist">
                
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
                                    @foreach ($loadReviews as $reviews)
                                        @if($reviews->status == 1) <!-- Chỉ hiển thị nếu status = 1 -->
                                            <div class="review_content">
                                                <div class="clearfix add_bottom_10">
                                                    <span class="rating">
                                                        @for($i = 1; $i <= $reviews->rating; $i++)
                                                            <i class="icon-star filled"></i>
                                                        @endfor
                                                        <em>{{ number_format($reviews->rating, 1) }}/5.0 (đánh giá)</em>
                                                    </span>
                                                </div>
                                                <h4>{{ $reviews->user->name }}</h4>
                                                <p>{{ $reviews->description }}</p>
                                                <img src="{{ asset('storage/' . $reviews->image) }}" alt="Ảnh đánh giá" width="150px">

                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                
                            </div>
                
                            
                        </div>
                    </div>
                </div>
                
                <!-- /tab B -->
            </div>
            <!-- /tab-content -->
        </div>
        <!-- /container -->
    </div>
    <!-- /tab_content_wrapper -->

    
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
