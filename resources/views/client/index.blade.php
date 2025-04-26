@extends('client.layout.default')
@section('content')
    <main>
        <div id="carousel-home">
            <div class="owl-carousel owl-theme">
                <div class="owl-slide cover" style="background-image: url(client/img/slides/slide_home_2.jpg);">
                    <div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                        <div class="container">
                            <div class="row justify-content-center justify-content-md-end">
                                <div class="col-lg-6 static">
                                    <div class="slide-text text-end white">
                                        <h2 class="owl-slide-animated owl-slide-title">Attack Air<br>Tối đa 720
                                            Thấp</h2>
                                        <p class="owl-slide-animated owl-slide-subtitle">
                                            Số lượng mặt hàng có hạn với mức giá này
                                        </p>
                                        <div class="owl-slide-animated owl-slide-cta"><a class="btn_1"
                                                href="listing-grid-1-full.html" role="button">Mua Ngay</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/owl-slide-->
                <div class="owl-slide cover" style="background-image: url(client/img/slides/slide_home_1.jpg);">
                    <div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                        <div class="container">
                            <div class="row justify-content-center justify-content-md-start">
                                <div class="col-lg-6 static">
                                    <div class="slide-text white">
                                        <h2 class="owl-slide-animated owl-slide-title">Attack Air<br>VaporMax
                                            Flyknit 3</h2>
                                        <p class="owl-slide-animated owl-slide-subtitle">
                                            Số lượng có hạn với mức giá này
                                        </p>
                                        <div class="owl-slide-animated owl-slide-cta"><a class="btn_1"
                                                href="listing-grid-1-full.html" role="button">Mua ngay</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/owl-slide-->
                <div class="owl-slide cover" style="background-image: url(client/img/slides/slide_home_3.jpg);">
                    <div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(255, 255, 255, 0.5)">
                        <div class="container">
                            <div class="row justify-content-center justify-content-md-start">
                                <div class="col-lg-12 static">
                                    <div class="slide-text text-center black">
                                        <h2 class="owl-slide-animated owl-slide-title">Attack Air<br>Monarch IV SE
                                        </h2>
                                        <p class="owl-slide-animated owl-slide-subtitle">
                                            Đệm nhẹ và hỗ trợ bền bỉ với đế giữa Phylon
                                        </p>
                                        <div class="owl-slide-animated owl-slide-cta"><a class="btn_1"
                                                href="listing-grid-1-full.html" role="button">Mua ngay</a></div>
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

        <ul id="banners_grid" class="clearfix">
            <li>
                <a href="#0" class="img_container">
                    <img src="client/img/banner_menu.jpg" data-src="" alt="" class="lazy">
                    <div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                        <h3>Bộ sưu tập</h3>
                        <div><span class="btn_1">Mua ngay</span></div>
                    </div>
                </a>
            </li>
            <li>
                <a href="#0" class="img_container">
                    <img src="client/img/blog-single.jpg" alt="" class="lazy">
                    <div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                        <h3>Giày thể thao</h3>
                        <div><span class="btn_1">Mua ngay</span></div>
                    </div>
                </a>
            </li>
            <li>
                <a href="#0" class="img_container">
                    <img src="client/img/bg_cat_shoes.jpg" data-src="" alt="" class="lazy">
                    <div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                        <h3>Bộ sưu tập 2025</h3>
                        <div><span class="btn_1">Mua ngay</span></div>
                    </div>
                </a>
            </li>
        </ul>
        <!--/banners_grid -->

        <div class="container margin_60_35">
            <div class="main_title">
                <h2>Sản phẩm</h2>
                <span>Bán chạy nhất</span>
            </div>


            <!-- List product Top selling-->
            <div class="container">
                <div class="row">
                    @foreach ($data as $product)
                        <div class="col-6 col-md-4 col-xl-3">
                            <div class="grid_item">
                                <figure>
                                    <!-- Liên kết đến trang chi tiết sản phẩm -->
                                    <a href="{{ route('detail.index', $product->id) }}">
                                        <div class="col-md-6">
                                            <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                                alt="{{ $product->name }}" class="img-fluid" width="100px" height="10px">
                                        </div>
                                </figure>


                                <!-- Tên sản phẩm và giá -->
                                <a href="{{ route('detail.index', ['id' => $product->id]) }}">
                                    <h3>{{ $product->name }}</h3>
                                </a>

                                <div class="price_box">
                                    @if ($product->sell_price > 0)
                                        <span class="old_price">{{ number_format($product->sell_price) }} VNĐ</span>
                                        <span class="new_price">{{ number_format($product->price) }} VNĐ</span>
                                    @elseif ($product->sell_price == 0)
                                        <span class="new_price">{{ number_format($product->price) }} VNĐ</span>
                                    @endif
                                </div>

                                <!-- Thêm vào giỏ hàng -->
                                <ul>
                                    <li>
                                        <a href="#0" class="tooltip-1" data-bs-toggle="tooltip"
                                            data-bs-placement="left" title="Add to favorites">
                                            <i class="ti-heart"></i><span>Add to favorites</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- /grid_item -->
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <!-- /row -->
     



        <div class="bg_gray">
            <div class="container margin_30">
                <div id="brands" class="owl-carousel owl-theme">
                    <div class="item">
                        <a href="#0"><img src="client/img/brands/placeholder_brands.png"
                                data-src="client/img/brands/logo_1.png" alt="" class="owl-lazy"></a>
                    </div><!-- /item -->
                    <div class="item">
                        <a href="#0"><img src="client/img/brands/placeholder_brands.png"
                                data-src="client/img/brands/logo_2.png" alt="" class="owl-lazy"></a>
                    </div><!-- /item -->
                    <div class="item">
                        <a href="#0"><img src="client/img/brands/placeholder_brands.png"
                                data-src="client/img/brands/logo_3.png" alt="" class="owl-lazy"></a>
                    </div><!-- /item -->
                    <div class="item">
                        <a href="#0"><img src="client/img/brands/placeholder_brands.png"
                                data-src="client/img/brands/logo_4.png" alt="" class="owl-lazy"></a>
                    </div><!-- /item -->
                    <div class="item">
                        <a href="#0"><img src="client/img/brands/placeholder_brands.png"
                                data-src="client/img/brands/logo_5.png" alt="" class="owl-lazy"></a>
                    </div><!-- /item -->
                    <div class="item">
                        <a href="#0"><img src="client/img/brands/placeholder_brands.png"
                                data-src="client/img/brands/logo_6.png" alt="" class="owl-lazy"></a>
                    </div><!-- /item -->
                </div><!-- /carousel -->
            </div><!-- /container -->
        </div>
        <!-- /bg_gray -->

        {{-- <div class="container margin_60_35">
            <div class="main_title">
                <h2>Latest News</h2>
                <span>Blog</span>
                <p>Cum doctus civibus efficiantur in imperdiet deterruisset</p>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <a class="box_news" href="blog.html">
                        <figure>
                            <img src="client/img/blog-thumb-placeholder.jpg" data-src="client/img/blog-thumb-1.jpg"
                                alt="" width="400" height="266" class="lazy">
                            <figcaption><strong>28</strong>Dec</figcaption>
                        </figure>
                        <ul>
                            <li>by Mark Twain</li>
                            <li>20.11.2017</li>
                        </ul>
                        <h4>Pri oportere scribentur eu</h4>
                        <p>Cu eum alia elit, usu in eius appareat, deleniti sapientem honestatis eos ex. In ius esse
                            ullum vidisse....</p>
                    </a>
                </div>
                <!-- /box_news -->
                <div class="col-lg-6">
                    <a class="box_news" href="blog.html">
                        <figure>
                            <img src="client/img/blog-thumb-placeholder.jpg" data-src="client/img/blog-thumb-2.jpg"
                                alt="" width="400" height="266" class="lazy">
                            <figcaption><strong>28</strong>Dec</figcaption>
                        </figure>
                        <ul>
                            <li>By Jhon Doe</li>
                            <li>20.11.2017</li>
                        </ul>
                        <h4>Duo eius postea suscipit ad</h4>
                        <p>Cu eum alia elit, usu in eius appareat, deleniti sapientem honestatis eos ex. In ius esse
                            ullum vidisse....</p>
                    </a>
                </div>
                <!-- /box_news -->
                <div class="col-lg-6">
                    <a class="box_news" href="blog.html">
                        <figure>
                            <img src="client/img/blog-thumb-placeholder.jpg" data-src="client/img/blog-thumb-3.jpg"
                                alt="" width="400" height="266" class="lazy">
                            <figcaption><strong>28</strong>Dec</figcaption>
                        </figure>
                        <ul>
                            <li>By Luca Robinson</li>
                            <li>20.11.2017</li>
                        </ul>
                        <h4>Elitr mandamus cu has</h4>
                        <p>Cu eum alia elit, usu in eius appareat, deleniti sapientem honestatis eos ex. In ius esse
                            ullum vidisse....</p>
                    </a>
                </div>
                <!-- /box_news -->
                <div class="col-lg-6">
                    <a class="box_news" href="blog.html">
                        <figure>
                            <img src="client/img/blog-thumb-placeholder.jpg" data-src="client/img/blog-thumb-4.jpg"
                                alt="" width="400" height="266" class="lazy">
                            <figcaption><strong>28</strong>Dec</figcaption>
                        </figure>
                        <ul>
                            <li>By Paula Rodrigez</li>
                            <li>20.11.2017</li>
                        </ul>
                        <h4>Id est adhuc ignota delenit</h4>
                        <p>Cu eum alia elit, usu in eius appareat, deleniti sapientem honestatis eos ex. In ius esse
                            ullum vidisse....</p>
                    </a>
                </div>
                <!-- /box_news -->
            </div>
            <!-- /row -->
        </div> --}}
        <!-- /container -->
    </main>
    {{-- <div class="popup_wrapper">
    <div class="popup_content newsletter">
        <span class="popup_close">Close</span>
        <div class="row g-0">
        <div class="col-md-5 d-none d-md-flex align-items-center justify-content-center">
            <figure><img src="client/img/newsletter_img.jpg" alt=""></figure>
        </div>
        <div class="col-md-7">
            <div class="content">
                <div class="wrapper">
                <img src="client/img/logo_black.svg" alt="" width="100" height="35">
                <h3>Sign up our newsletter</h3>
                <p>Ne qui aliquam probatus moderatius, ad sint cotidieque qui, sea id cetero laoreet principes.</p>
                 <form action="#">
                     <div class="form-group">
                         <input type="email" class="form-control" placeholder="Enter your email address">
                     </div>
                    
                     <button type="submit" class="btn_1 mt-2 mb-4">Subscribe</button>
                      <div class="form-group">
                            <label class="container_check d-inline">Don't show this PopUp again
                              <input type="checkbox">
                              <span class="checkmark"></span>
                            </label>
                        </div>
                 </form>
                </div>
            </div>
        </div>
    </div>
        <!-- row -->
    </div>
</div> --}}
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

        <!-- PRELOAD LARGE CONTENT -->
        <link rel="preload" as="image" href="{{ asset('client/img/slides/slide_home_2.jpg') }}">

        <!-- BASE CSS -->
        <link rel="preload" href="{{ asset('client/css/style.css') }}" as="style">
        <link rel="stylesheet" href="{{ asset('client/css/style.css') }}">
        <!-- SPECIFIC CSS -->
        <link rel="preload" href="{{ asset('client/css/home_1.css') }}" as="style">
        <link rel="stylesheet" href="{{ asset('client/css/home_1.css') }}">
    @endpush
    <!--ENd Css-->

    <!--JS-->
    @push('js')
        <!-- SPECIFIC SCRIPTS -->
        <script src="{{ asset('client/js/carousel-home.min.js') }}"></script>
    @endpush
    <!--ENd JS-->
@endsection
