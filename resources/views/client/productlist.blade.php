@extends('client.layout.default')
@section('content')
    <main>
        <div class="registration-container">

            <h2 class="fw-bold text-white">Khám phá Allaia Giày Nam Mới Nhất 2025</h2>
            <p class="text-white-50">
                Từ phong cách năng động đến lịch lãm – lựa chọn hoàn hảo cho quý ông hiện đại.
            </p>


        </div>

        <div class="container margin_60_35">

            <div class="row">
                <!-- CỘT TRÁI: BỘ LỌC -->
                <div class="col-md-3">
                    <form method="GET" action="{{ route('product.filter') }}">
                        <!-- Thương hiệu -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                    class="bi bi-sliders2" viewBox="0 0 16 16">
                                    <path
                                        d="M0 3a.5.5 0 0 1 .5-.5h2.757a2 2 0 0 1 3.486 0H15.5a.5.5 0 0 1 0 1H6.743a2 2 0 0 1-3.486 0H.5A.5.5 0 0 1 0 3Zm1 0h2.021a2.001 2.001 0 0 1 0 1H1a.5.5 0 0 1 0-1Zm6.743 0a1 1 0 1 0-1 1 1 1 0 0 0 1-1ZM0 8a.5.5 0 0 1 .5-.5h8.757a2 2 0 0 1 3.486 0H15.5a.5.5 0 0 1 0 1h-2.757a2 2 0 0 1-3.486 0H.5A.5.5 0 0 1 0 8Zm1 0h8.021a2.001 2.001 0 0 1 0 1H1a.5.5 0 0 1 0-1Zm10.743 0a1 1 0 1 0-1 1 1 1 0 0 0 1-1ZM0 13a.5.5 0 0 1 .5-.5h4.757a2 2 0 0 1 3.486 0H15.5a.5.5 0 0 1 0 1H8.743a2 2 0 0 1-3.486 0H.5a.5.5 0 0 1-.5-.5Zm1 0h4.021a2.001 2.001 0 0 1 0 1H1a.5.5 0 0 1 0-1Zm6.743 0a1 1 0 1 0-1 1 1 1 0 0 0 1-1Z" />
                                </svg>
                                <h5 class="ms-2 mb-0 fw-bold">Bộ lọc</h5>
                            </div>

                            <a href="{{ route('productlist') }}" class="btn btn-outline-secondary btn-sm">
                                Bỏ lọc
                            </a>
                        </div>

                        <hr class="custom-hr">
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <h5 class="m-0">Thương hiệu</h5>
                            <button type="button" class="btn btn-sm btn-toggle p-0" data-bs-toggle="collapse"
                                data-bs-target="#collapseBrands" aria-expanded="true" aria-controls="collapseBrands"
                                aria-label="Toggle Thương hiệu filter">
                                <svg class="icon-caret" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </button>
                        </div>

                        <div class="collapse show" id="collapseBrands">
                            @foreach ($brands as $brand)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="brand-{{ $brand->id }}"
                                        name="brands[]" value="{{ $brand->id }}"
                                        {{ in_array($brand->id, request()->brands ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="brand-{{ $brand->id }}">{{ $brand->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <hr class="custom-hr">
                        <!-- Danh mục -->
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <h5 class="m-0">Danh mục</h5>
                            <button type="button" class="btn btn-sm btn-toggle p-0" data-bs-toggle="collapse"
                                data-bs-target="#collapseCategories" aria-expanded="true" aria-controls="collapseCategories"
                                aria-label="Toggle Danh mục filter">
                                <svg class="icon-caret" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </button>
                        </div>
                        <div class="collapse show" id="collapseCategories">
                            @foreach ($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="category-{{ $category->id }}"
                                        name="categories[]" value="{{ $category->id }}"
                                        {{ in_array($category->id, request()->categories ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="category-{{ $category->id }}">{{ $category->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <hr class="custom-hr">
                        <!-- Size -->
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <h5 class="m-0">Size</h5>
                            <button type="button" class="btn btn-sm btn-toggle p-0" data-bs-toggle="collapse"
                                data-bs-target="#collapseSizes" aria-expanded="true" aria-controls="collapseSizes"
                                aria-label="Toggle Size filter">
                                <svg class="icon-caret" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </button>
                        </div>
                        <div class="collapse show" id="collapseSizes">
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($sizes as $size)
                                    <button type="button"
                                        class="btn btn-outline-dark size-btn {{ request()->size == $size ? 'active' : '' }}"
                                        data-size="{{ $size }}" style="border-radius: 0;">
                                        {{ $size }}
                                    </button>
                                @endforeach
                            </div>
                            <input type="hidden" name="size" id="selected-size" value="{{ request()->size }}">
                        </div>
                        <hr class="custom-hr">
                        <!-- Khoảng giá -->
                        <!-- Khoảng giá -->
<div class="mb-3 d-flex justify-content-between align-items-center">
    <h5 class="m-0">Khoảng giá</h5>
    <button type="button" class="btn btn-sm btn-toggle p-0" data-bs-toggle="collapse"
        data-bs-target="#collapsePrice" aria-expanded="true" aria-controls="collapsePrice"
        aria-label="Toggle Khoảng giá filter">
        <svg class="icon-caret" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
            fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
        </svg>
    </button>
</div>
<div class="collapse show" id="collapsePrice">
    <div class="d-flex gap-2">
        <!-- input hiển thị định dạng số có dấu chấm -->
        <input type="text" id="price_from_display" placeholder="Từ" class="form-control" 
               value="{{ request()->price_from ? number_format(request()->price_from, 0, ',', '.') : '' }}" autocomplete="off">
        <input type="hidden" name="price_from" id="price_from" value="{{ request()->price_from }}">

        <input type="text" id="price_to_display" placeholder="Đến" class="form-control" 
               value="{{ request()->price_to ? number_format(request()->price_to, 0, ',', '.') : '' }}" autocomplete="off">
        <input type="hidden" name="price_to" id="price_to" value="{{ request()->price_to }}">
    </div>
</div>


                        <button type="submit" class="btn btn-primary w-100 mt-3">ÁP DỤNG</button>
                    </form>
                </div>



                <!-- CỘT PHẢI: DANH SÁCH SẢN PHẨM -->
                <div class="col-md-9">
                    <div class="row">
                        @foreach ($products ?? $data as $product)
                            <div class="col-6 col-md-4 col-xl-3 mb-4">
                                <div class="grid_item">
                                    <figure class="text-center">
                                        <a href="{{ route('detail.index', ['id' => $product->id]) }}">
                                            <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                                alt="{{ $product->name }}" class="img-fluid" style="max-width: 160px;">
                                        </a>
                                    </figure>
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
                                    {{-- <ul>
                                        <li>
                                            <a href="#0" class="tooltip-1" data-bs-toggle="tooltip"
                                                data-bs-placement="left" title="Add to favorites">
                                                <i class="ti-heart"></i><span>Add to favorites</span>
                                            </a>
                                        </li>
                                    </ul> --}}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sizeButtons = document.querySelectorAll('.size-btn');
            const selectedSizeInput = document.getElementById('selected-size');

            sizeButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const size = btn.getAttribute('data-size');

                    if (btn.classList.contains('active')) {
                        // Nếu đang active, click lần nữa sẽ bỏ chọn
                        btn.classList.remove('active');
                        selectedSizeInput.value = ''; // clear giá trị size
                    } else {
                        // Nếu chưa active, bỏ active tất cả rồi active cái đang click
                        sizeButtons.forEach(b => b.classList.remove('active'));
                        btn.classList.add('active');
                        selectedSizeInput.value = size;
                    }
                });
            });
        });
    </script>

    <style>
        .btn-toggle {
            border: none;
            background: transparent;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-toggle:focus {
            outline: none;
            box-shadow: none;
        }

        .btn-toggle[aria-expanded="true"] .icon-caret {
            transform: rotate(180deg);
            transition: transform 0.3s ease;
        }

        .icon-caret {
            transition: transform 0.3s ease;
        }

        .size-btn.active {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

        .custom-hr {
            border: none;
            border-top: 2px solid #343a40;
            /* Màu xám đậm */
            width: 100%;
            margin: 1rem auto;
        }
    </style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    function formatNumberWithDots(x) {
        x = x.replace(/\D/g, '');
        return x.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function unformatNumber(x) {
        return x.replace(/\./g, '');
    }

    const form = document.querySelector('form[action="{{ route('product.filter') }}"]');
    const priceFromDisplay = document.getElementById('price_from_display');
    const priceToDisplay = document.getElementById('price_to_display');
    const priceFrom = document.getElementById('price_from');
    const priceTo = document.getElementById('price_to');

    priceFromDisplay.addEventListener('input', function () {
        this.value = formatNumberWithDots(this.value);
        priceFrom.value = unformatNumber(this.value);
    });

    priceToDisplay.addEventListener('input', function () {
        this.value = formatNumberWithDots(this.value);
        priceTo.value = unformatNumber(this.value);
    });

    form.addEventListener('submit', function (e) {
        const fromVal = parseInt(priceFrom.value) || 0;
        const toVal = parseInt(priceTo.value) || 0;

        if (toVal > 0 && toVal < fromVal) {
            e.preventDefault();

            Swal.fire({
                icon: 'error',
                title: 'Khoảng giá không hợp lệ',
                text: 'Giá "Đến" phải lớn hơn hoặc bằng giá "Từ".',
                confirmButtonText: 'Đã hiểu'
            });

            priceToDisplay.focus();
        }
    });
});
</script>






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
