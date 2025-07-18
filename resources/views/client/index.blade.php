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
        <div class="container margin_60_35 text-center">
            <h2 class="luxury-font">Gentlemen Footwear</h2>
            <h4 class="luxury-font mx-auto" style="max-width: 600px;">
                Allaia – nơi khởi nguồn phong cách lịch lãm. Mỗi đôi giày da được chế tác tỉ mỉ, để cùng bạn khẳng định bản
                lĩnh và khí chất riêng trên từng bước đi.
            </h4>
        </div>

        <div class="container margin_60_35">
            <div class="container main_title d-flex justify-content-between align-items-center">
                {{-- <h2 class="text-danger mb-0 border p-2">Sản phẩm mới</h2> --}}
                {{-- <h2 class="border p-2 mb-0 link-hover">Xem tất cả</h2> --}}
            </div>




            <!-- List product mới nhất -->
            <div class="container">
                <div class="row">
                    @foreach ($latestProducts as $product)
                        <div class="col-6 col-md-4 col-xl-3">
                            <div class="grid_item position-relative" style="height: 370px; overflow: hidden;">

                                {{-- Ảnh --}}
                                <figure class="text-center mb-2">
                                    <a href="{{ route('detail.index', ['id' => $product->id]) }}">
                                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                                            class="img-fluid" style="max-width:270px; height:300px; object-fit:cover;">
                                    </a>
                                </figure>

                                {{-- Tên & giá --}}

                                <div class="product_info text-center">
                                    <a href="{{ route('detail.index', ['id' => $product->id]) }}">
                                        <h3>{{ $product->name }}</h3>
                                    </a>
                                    <div class="price_box">
                                        @if ($product->sell_price > 0)
                                            <span class="old_price">{{ number_format($product->sell_price) }} VNĐ</span>
                                            <span class="new_price">{{ number_format($product->price) }} VNĐ</span>
                                        @else
                                            <span class="new_price">{{ number_format($product->price) }} VNĐ</span>
                                        @endif
                                    </div>
                                </div>


                                {{-- Nút xem chi tiết (ẩn mặc định) --}}

                                <div class="hover_btn position-absolute w-100 text-center py-2" style="bottom: 0; left: 0;">
                                    <a href="{{ route('detail.index', ['id' => $product->id]) }}" class="btn btn-light">
                                        <h6 class="mt-2">Xem chi tiết</h6>
                                    </a>
                                </div>



                            </div>
                        </div>
                    @endforeach
                </div>
            </div>



        </div>
        {{-- 4 sản phẩm mới --}}
        <div class="registration-container">
            <h1 class="text-white">Đăng ký nhận tin Allaia Stadium</h1>
            <p>Hãy đăng ký để nhận tin nhắn nhanh nhất qua email</p>
            <input type="email" placeholder="Nhập địa chỉ email của bạn" required />
            <button type="submit">ĐĂNG KÝ</button>
        </div>
        <div class="container my-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Allaia</h2>
                <a href="#" class="btn btn-outline-warning">View all</a>
            </div>

            <div class="row g-4">

                <div class="col-12 col-md-3 mb-4 text-center">
                    <img src="client/img/a.webp" class="img-fluid mb-3 hover-zoom" alt="Sản xuất tại Việt Nam">
                    <h5 class="fw-bold">SẢN XUẤT TẠI VIỆT NAM</h5>
                    <p class="small">
                        Từ những nghệ nhân đóng giày dày dạn kinh nghiệm với mong muốn mang đến cho Quý Ông đôi giày mang
                        Thương Hiệu Việt chất lượng tốt nhất.
                    </p>
                </div>
                <div class="col-12 col-md-3 mb-4 text-center">
                    <img src="client/img/a2.webp" class="img-fluid mb-3 hover-zoom" alt="Vật tư nhập khẩu">
                    <h5 class="fw-bold">VẬT TƯ NHẬP KHẨU</h5>
                    <p class="small">
                        Giày được làm từ những mảng da bò Ý, chọn lọc kỹ càng để đảm bảo thành phẩm là một đôi giày chất
                        lượng và lên màu giày chuẩn nhất.
                    </p>
                </div>
                <div class="col-12 col-md-3 mb-4 text-center">
                    <img src="client/img/a3.webp" class="img-fluid mb-3 hover-zoom" alt="Last giày cho Quý ông Việt">
                    <h5 class="fw-bold">LAST CHUẨN QUÝ ÔNG VIỆT</h5>
                    <p class="small">
                        Với châm ngôn “Giày Tây dành cho Ta”, Allaia thiết kế phom (Last) giày phù hợp với phom chân
                        chuẩn của Quý Ông Việt.
                    </p>
                </div>
                <div class="col-12 col-md-3 mb-4 text-center">
                    <img src="client/img/a4.webp" class="img-fluid mb-3 hover-zoom" alt="Bảo hành 3 năm">
                    <h5 class="fw-bold">BẢO HÀNH 3 NĂM</h5>
                    <p class="small">
                        Chính sách Bảo Hành - Bảo Dưỡng miễn phí trong 3 Năm, nhằm hỗ trợ quý khách hàng tốt nhất trong quá
                        trình sử dụng giày.
                    </p>
                </div>

            </div>
        </div>
<section class="py-5" style="background: #2c3e50; color: #fff;">
    <div class="container">
        <div class="row align-items-center">
            <!-- Bên trái -->
            <div class="col-md-5 mb-4 mb-md-0">
                <h3 class="fw-bold mb-2">Đánh giá từ</h3>
                <h3 class="fw-bold mb-4">Khách Hàng</h3>
                <h1 class="display-3 fw-bold mb-2">+45,969</h1>
                <p>Hàng nghìn khách hàng đã tin tưởng và ủng hộ sản phẩm của Allaia</p>
            </div>

            <!-- Bên phải: Carousel tự chạy -->
            <div class="col-md-7">
                <div id="reviewCarousel" class="carousel slide" data-ride="carousel" data-interval="4000">
                    <div class="carousel-inner">

                        <!-- Đánh giá 1 -->
                        <div class="carousel-item active">
                            <div class="p-4 bg-light text-dark rounded">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="client/img/staff/1_carousel.jpg" class="rounded-circle mr-3"
                                         width="60" alt="Nguyễn Thanh Tú">
                                    <div>
                                        <h6 class="fw-bold mb-0">Nguyễn Thanh Tú</h6>
                                        <small class="text-muted">⭐⭐⭐⭐⭐</small>
                                    </div>
                                </div>
                                <p class="mb-0">“Mình chọn Allaia bởi mỗi sản phẩm đều thiết kế tinh tế và cẩn thận.”</p>
                            </div>
                        </div>

                        <!-- Đánh giá 3 -->
                        <div class="carousel-item">
                            <div class="p-4 bg-light text-dark rounded">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="client/img/staff/4_carousel.jpg" class="rounded-circle mr-3" width="60"
                                         alt="MC Đức Bảo">
                                    <div>
                                        <h6 class="fw-bold mb-0">Hoàng Ninh T</h6>
                                        <small class="text-muted">⭐⭐⭐⭐⭐</small>
                                    </div>
                                </div>
                                <p class="mb-0">"Phong cách lịch lãm, hoàn toàn đáp ứng yêu cầu."</p>
                            </div>
                        </div>
                             <div class="carousel-item">
                            <div class="p-4 bg-light text-dark rounded">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="client/img/staff/3_carousel.jpg" class="rounded-circle mr-3" width="60"
                                         alt="MC Đức Bảo">
                                    <div>
                                        <h6 class="fw-bold mb-0">Nguyễn Văn C</h6>
                                        <small class="text-muted">⭐⭐⭐⭐⭐</small>
                                    </div>
                                </div>
                                <p class="mb-0">"Phong cách hoàn hảo ,phù hợp với người trưởng thành"</p>
                            </div>
                        </div>

                        <!-- Bạn có thể thêm nhiều đánh giá khác ở đây -->

                    </div>

                    <!-- Ẩn nút điều hướng nếu không cần -->
                    <style>
                        .carousel-control-prev,
                        .carousel-control-next {
                            display: none !important;
                        }
                    </style>
                </div>
            </div>
        </div>
    </div>
</section>

        <div class="container my-5">
            <h2 class="text-uppercase font-weight-bold mb-4 text-center">Tin tức <span class="text-dark"></span>
            </h2>
            <div class="row">
                <!-- Tin 1 -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <a href="#" class="text-dark" style="text-decoration: none;">
                        <img src="client/img/c1.webp" class="img-fluid mb-3 hover-zoom" alt="Tin 1">
                        <h6 class="font-weight-bold text-uppercase">CÁCH MIX GIÀY TÂY NAM & PHỤ KIỆN: CHUẨN SANG, KHÔNG...
                        </h6>
                        <p class="text-muted mb-0">Ở phái mạnh, việc phối hợp giày tây nam & phụ kiện chính là nghệ
                            thuật...</p>
                    </a>
                </div>

                <!-- Tin 2 -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <a href="#" class="text-dark" style="text-decoration: none;">
                        <img src="client/img/c2.webp" class="img-fluid mb-3 hover-zoom" alt="Tin 2">
                        <h6 class="font-weight-bold text-uppercase">SỰ KIỆN CƯỚI PLANNED TO PERFECTION</h6>
                        <p class="text-muted mb-0">Sự kiện cưới đẳng cấp do JW Marriott tổ chức đã khép lại bằng sự thành
                            công...</p>
                    </a>
                </div>

                <!-- Tin 3 -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <a href="#" class="text-dark" style="text-decoration: none;">
                        <img src="client/img/c3.webp" class="img-fluid mb-3 hover-zoom" alt="Tin 3">
                        <h6 class="font-weight-bold text-uppercase">BE CLASSY & THE DREAM VOYAGE</h6>
                        <p class="text-muted mb-0">THE DREAM VOYAGE 2025 khép lại với dư âm ngọt ngào trong lòng 300 cặp
                            đôi...</p>
                    </a>
                </div>

                <!-- Tin 4 -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <a href="#" class="text-dark" style="text-decoration: none;">
                        <img src="client/img/c4.webp" class="img-fluid mb-3 hover-zoom" alt="Tin 4">
                        <h6 class="font-weight-bold text-uppercase">"KICK-OFF" WEDDING FAIR – THE DREAM VOYAGE</h6>
                        <p class="text-muted mb-0">Hành trình chính phục các quý ông của Be Classy đã chính thức “cập bến”
                            The Dream Voyage...</p>
                    </a>
                </div>
            </div>
        </div>



        {{-- <div class="container margin_60_35">
            <div class="row">
                @foreach ($categories as $index => $category)
                    @if ($category->products->count() > 0)
                        <div class="container margin_60_35">
                            <div class="main_title">
                                <h2>{{ $category->name }}</h2>
                            </div>

                            <div class="row">
                                @foreach ($category->products->take(4) as $product)
                                    <div class="col-6 col-md-4 col-xl-3">
                                        <div class="grid_item ">
                                            <figure class="text-center">
                                                <a href="{{ route('detail.index', ['id' => $product->id]) }}">
                                                    <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                                        alt="{{ $product->name }}" class="img-fluid"
                                                        style="max-width: 160px;">
                                                </a>
                                            </figure>
                                            <a href="{{ route('detail.index', ['id' => $product->id]) }}">
                                                <h3>{{ $product->name }}</h3>
                                            </a>
                                            <div class="price_box">
                                                @if ($product->sell_price > 0)
                                                    <span class="old_price">{{ number_format($product->sell_price) }}
                                                        VNĐ</span>
                                                    <span class="new_price">{{ number_format($product->price) }}
                                                        VNĐ</span>
                                                @else
                                                    <span class="new_price">{{ number_format($product->price) }}
                                                        VNĐ</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div> --}}
    </main>
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
    @push('js')
        <script src="{{ asset('client/js/carousel-home.min.js') }}"></script>
    @endpush
@endsection
<style>
    /* Ẩn nút khi chưa hover */
    .grid_item .hover_btn {
        transform: translateY(100%);
        opacity: 0;
        transition: transform 0.4s ease, opacity 0.4s ease;
        pointer-events: none;
    }

    /* Khi hover: hiện nút */
    .grid_item:hover .hover_btn {
        transform: translateY(0);
        opacity: 1;
        pointer-events: auto;
    }

    /* Tên & giá: hiển thị bình thường */
    .grid_item .product_info {
        opacity: 1;
        transition: opacity 0.3s ease;
    }

    /* Khi hover: ẩn tên & giá */
    .grid_item:hover .product_info {
        opacity: 0;
    }




    .luxury-font {
        font-family: 'Playfair Display', serif;
        font-style: italic;
    }

    .hover-zoom {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    .hover-zoom:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        border-radius: 8px;
    }
</style>
