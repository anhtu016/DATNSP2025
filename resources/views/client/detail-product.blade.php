@extends('client.layout.default')
@section('content')
    <main>
        <div class="container mt-5">
            <div class="row g-5">
                <div class="col-md-6">
                    <!-- Ảnh sản phẩm -->
                    <div class="row">
                        <!-- Cột trái: ảnh phụ có cuộn -->
                        <div class="col-3">
                            <div class="position-relative" style="height: 400px;">
                                <!-- Nút lên -->
                                <button class="btn btn-light btn-sm w-100 mb-1" onclick="scrollThumbnails(-1)">
                                    <i class="fas fa-chevron-up"></i>
                                </button>

                                <!-- Danh sách ảnh phụ -->
                                <div id="thumbnail-container" class="overflow-hidden" style="height: 340px;">
                                    <div class="d-flex flex-column gap-2" id="thumbnail-list"
                                        style="transition: transform 0.3s;">
                                        <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                            class="img-thumbnail thumb-image" onclick="changeMainImage(this)">
                                        @foreach ($product->images as $img)
                                            <img src="{{ asset('storage/' . $img->image) }}"
                                                class="img-thumbnail thumb-image" onclick="changeMainImage(this)">
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Nút xuống -->
                                <button class="btn btn-light btn-sm w-100 mt-1" onclick="scrollThumbnails(1)">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Cột phải: ảnh chính -->
                        <div class="col-9">
                            <div class="bg-white p-3 d-flex align-items-center justify-content-center rounded shadow-sm"
                                style="height: 400px;">
                                <img id="product-image" src="{{ asset('storage/' . $product->thumbnail) }}"
                                    alt="{{ $product->name }}" class="img-fluid h-100" style="object-fit: contain;">
                            </div>
                        </div>
                    </div>

                    <!-- Mô tả sản phẩm -->
                    <div class="mt-4">
                        <h4 class="mb-2">Mô tả sản phẩm</h4>
                        <p><strong>Mô tả ngắn:</strong> {{ $product->short_description }}</p>
                        <div><strong>Chi tiết:</strong> {!! $product->description !!}</div>
                    </div>
                </div>


                <!-- CỘT PHẢI: Thao tác mua hàng -->
                <div class="col-md-6">
                    <div class="p-4 bg-light rounded shadow-sm h-100 d-flex flex-column justify-content-between">
                        <div>
                            <h2 class="mb-3">{{ $product->name }}</h2>
                            <p class="h3 text-danger fw-bold mb-3">{{ number_format($product->price) }} VND</p>

                            @auth
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                                    @csrf

                                    @foreach ($attributes as $attrName => $values)
                                        <div class="mb-3">
                                            <label class="form-label">{{ ucfirst($attrName) }}:</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach ($values as $value)
                                                    <input type="radio" class="btn-check"
                                                        name="attributes[{{ $attrName }}]"
                                                        id="{{ $attrName }}_{{ $value->id }}"
                                                        value="{{ $value->id }}" required>
                                                    <label class="btn btn-outline-dark"
                                                        for="{{ $attrName }}_{{ $value->id }}">
                                                        {{ $value->value }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="mb-3">
                                        <p class="text-muted">
                                            <span id="total-stock">{{ $product->quantity }}</span> sản phẩm có sẵn
                                        </p>
                                        <p id="variant-info" style="display:none;">
                                            <span id="variant-stock"></span> sản phẩm có sẵn
                                        </p>
                                    </div>

                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Số lượng:</label>
                                        <div class="d-flex align-items-center" style="max-width: 200px;">
                                            <button type="button" class="btn btn-outline-dark"
                                                style="width: 40px; height: 40px;" onclick="decrementQuantity()"
                                                id="decrement-btn">−</button>
                                            <input type="number" name="quantity" id="quantity"
                                                class="form-control text-center mx-2 no-spinner mt-2" value="1"
                                                min="1" max="{{ $product->quantity }}"
                                                style="width: 60px; height: 40px;">
                                            <button type="button" class="btn btn-outline-dark"
                                                style="width: 40px; height: 40px;" onclick="incrementQuantity()"
                                                id="increment-btn">+</button>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-3 mt-4">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ hàng
                                        </button>
                                    </div>
                                </form>
                            @else
                                <div class="alert alert-warning mt-4">
                                    Bạn cần <a href="{{ route('login') }}" class="fw-bold text-decoration-underline">đăng
                                        nhập</a> để mua hàng.
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <br>
        <br>

        <div class="mb-4">

            <!-- /container -->
            <div class="tabs_product">
                <div class="container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <h2>
                                                            <a id="tab-B" href="#pane-B" class="nav-link" data-bs-toggle="tab" role="tab">Xem đánh
                                giá</a>
                            </h2>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="container mt-4">
                <div class="tab-content" role="tablist">

                    <!-- /TAB A -->
                    <div id="pane-B" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
                        <div class="card-header" role="tab" id="heading-B">
                            <h5 class="mb-0">
                                <a class="collapsed" data-bs-toggle="collapse" href="#collapse-B" aria-expanded="false"
                                    aria-controls="collapse-B">
                                    Đánh giá sản phẩm
                                </a>
                            </h5>
                        </div>

                        <div id="collapse-B" class="collapse" role="tabpanel" aria-labelledby="heading-B">
                            <div class="card-body">
                                <div class="row justify-content-between">

                                   <div class="col-lg-6">
    @if ($loadReviews->isEmpty())
        <h5 class="text-danger">Hiện tại chưa có đánh giá về sản phẩm này !</h5>
    @else
        @foreach ($loadReviews as $reviews)
            @if ($reviews->status == 1)
                <!-- Chỉ hiển thị nếu status = 1 -->
                <div class="review_content">
                    <div class="clearfix add_bottom_10">
                        <span class="rating">
                            @for ($i = 1; $i <= $reviews->rating; $i++)
                                <i class="icon-star filled"></i>
                            @endfor
                            <em>{{ number_format($reviews->rating, 1) }}/5.0 (đánh giá)</em>
                        </span>
                    </div>
                    <h4>{{ $reviews->user->name }}</h4>
                    <p>{{ $reviews->description }}</p>
                    @if ($reviews->image) 
                        <img src="{{ asset('storage/' . $reviews->image) }}" alt="Ảnh đánh giá" width="150px">
                    @endif
                </div>
            @endif
        @endforeach
    @endif
</div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- /tab B -->
                </div>
                <!-- /tab-content -->
            </div>
            <!-- /tabs_product -->
            <!-- HIỂN THỊ ĐÁNH GIÁ NGAY DƯỚI SẢN PHẨM -->
            {{-- <div class="container mt-5">
                <h4 class="mb-4">Đánh giá sản phẩm</h4>

                @forelse ($loadReviews as $reviews)
                    @if ($reviews->status == 1)
                        <div class="review_content border rounded p-3 mb-4">

                            <div class="clearfix add_bottom_10">
                                <span class="rating">
                                    @for ($i = 1; $i <= $reviews->rating; $i++)
                                        <i class="icon-star filled text-warning"></i>
                                    @endfor
                                    <em class="ms-2">{{ number_format($reviews->rating, 1) }}/5.0</em>
                                </span>
                            </div>
                            <h5 class="fw-bold">{{ $reviews->user->name }}</h5>
                            <p>{{ $reviews->description }}</p>
                            @if ($reviews->image)
                                <img src="{{ asset('storage/' . $reviews->image) }}" alt="Ảnh đánh giá" width="150px"
                                    class="img-thumbnail">
                            @endif
                        </div>
                    @endif
                @empty
                    <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                @endforelse

           
            </div> --}}

        </div>


    </main>
    <style>
        .thumb-image {
            max-width: 100%;
            height: 80px;
            object-fit: cover;
            border: 2px solid transparent;
            transition: border-color 0.3s;
        }

        .thumb-image:hover {
            border-color: #007bff;
        }
    </style>

    <style>
        /* Ẩn mũi tên trong input number - Chrome, Safari, Edge */
        .no-spinner::-webkit-inner-spin-button,
        .no-spinner::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        .no-spinner {
            -moz-appearance: textfield;
        }
    </style>
    <script>
        function changeMainImage(el) {
            const mainImg = document.getElementById('product-image');
            mainImg.src = el.src;
        }
    </script>
<script>
    let scrollIndex = 0;
    const scrollAmount = 80; // chiều cao mỗi lần scroll

    function scrollThumbnails(direction) {
        const container = document.getElementById('thumbnail-container');
        const list = document.getElementById('thumbnail-list');
        const maxScroll = list.scrollHeight - container.clientHeight;

        scrollIndex += direction * scrollAmount;

        // Giới hạn cuộn
        scrollIndex = Math.max(0, Math.min(scrollIndex, maxScroll));

        container.scrollTo({
            top: scrollIndex,
            behavior: 'smooth'
        });
    }

    function changeMainImage(el) {
        document.getElementById('product-image').src = el.src;
    }
</script>

    <script>
        const variants = @json($variantsData);
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variantInfo = document.getElementById('variant-info');
            const variantStock = document.getElementById('variant-stock');
            const totalStockWrapper = document.getElementById('total-stock').parentElement;
            const stockAlert = document.createElement('p'); // Cảnh báo số lượng ít

            stockAlert.classList.add('alert', 'alert-warning', 'mt-3'); // Thêm class để định kiểu cảnh báo
            stockAlert.style.display = 'none'; // Ẩn cảnh báo mặc định
            stockAlert.textContent = "Sản phẩm sắp hết, chỉ còn ít sản phẩm trong kho!"; // Nội dung cảnh báo
            totalStockWrapper.after(stockAlert); // Thêm cảnh báo sau phần tổng số lượng

            const variantStockData = @json($variantStock);

            document.querySelectorAll('label.btn-outline-dark').forEach(label => {
                label.addEventListener('click', function() {
                    setTimeout(() => {
                        let selectedAttributes = {};

                        document.querySelectorAll(
                                'input[type="radio"][name^="attributes"]:checked')
                            .forEach(checked => {
                                const name = checked.name.replace('attributes[', '')
                                    .replace(']', '');
                                selectedAttributes[name] = checked.value;
                            });

                        if (Object.keys(selectedAttributes).length ===
                            {{ count($attributes) }}) {
                            const attributeOrder = {!! json_encode(array_keys($attributes)) !!};
                            const key = attributeOrder.map(attr => selectedAttributes[attr])
                                .join('-');

                            if (variantStockData[key] !== undefined) {
                                const stock = variantStockData[key];
                                variantStock.textContent = stock;
                                variantInfo.style.display = 'block';

                                // ✅ Ẩn tổng số lượng khi đã chọn đầy đủ
                                totalStockWrapper.style.display = 'none';

                                // Hiển thị cảnh báo nếu số lượng dưới 20
                                if (stock < 20) {
                                    stockAlert.style.display = 'block';
                                } else {
                                    stockAlert.style.display = 'none';
                                }
                            } else {
                                variantStock.textContent = '0';
                                variantInfo.style.display = 'block';
                                stockAlert.style.display =
                                    'none'; // Ẩn cảnh báo khi không có sản phẩm
                            }
                        } else {
                            variantInfo.style.display = 'none';
                            totalStockWrapper.style.display = 'block';
                            stockAlert.style.display =
                                'none'; // Ẩn cảnh báo nếu chưa chọn đủ thuộc tính
                        }
                    }, 50);
                });
            });
        });

        //
        document.addEventListener('DOMContentLoaded', function() {
            const variantInfo = document.getElementById('variant-info');
            const variantStock = document.getElementById('variant-stock');
            const totalStockWrapper = document.getElementById('total-stock').parentElement;

            const variantStockData = @json($variantStock);

            document.querySelectorAll('label.btn-outline-dark').forEach(label => {
                label.addEventListener('click', function() {
                    setTimeout(() => {
                        let selectedAttributes = {};

                        document.querySelectorAll(
                                'input[type="radio"][name^="attributes"]:checked')
                            .forEach(checked => {
                                const name = checked.name.replace('attributes[', '')
                                    .replace(']', '');
                                selectedAttributes[name] = checked.value;
                            });

                        if (Object.keys(selectedAttributes).length ===
                            {{ count($attributes) }}) {
                            const attributeOrder = {!! json_encode(array_keys($attributes)) !!};
                            const key = attributeOrder.map(attr => selectedAttributes[attr])
                                .join('-');

                            if (variantStockData[key] !== undefined) {
                                variantStock.textContent = variantStockData[key];
                                variantInfo.style.display = 'block';
                            } else {
                                variantStock.textContent = '0';
                                variantInfo.style.display = 'block';
                            }

                            // ✅ Ẩn tổng số lượng khi đã chọn đầy đủ
                            totalStockWrapper.style.display = 'none';
                        } else {
                            // ❗ Nếu chưa chọn đủ, hiện tổng số lượng
                            variantInfo.style.display = 'none';
                            totalStockWrapper.style.display = 'block';
                        }
                    }, 50);
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variantImage = document.getElementById('product-image');
            const variantStock = document.getElementById('variant-stock');
            const variantInfo = document.getElementById('variant-info');
            const totalStock = document.getElementById('total-stock');

            const attributeInputs = document.querySelectorAll('input[type=radio][name^="attributes"]');
            const selectedColorInput = document.querySelectorAll(
                'input[type=radio][name="attributes[color]"]'); // Chọn các input màu sắc

            // Lắng nghe sự kiện thay đổi cho màu sắc
            selectedColorInput.forEach(input => {
                input.addEventListener('change', handleColorChange);
            });

            // Lắng nghe sự kiện thay đổi các thuộc tính khác
            attributeInputs.forEach(input => {
                input.addEventListener('change', handleVariantChange);
            });

            function handleColorChange() {
                const selectedColorId = [...document.querySelectorAll(
                        'input[type=radio][name="attributes[color]"]:checked')]
                    .map(input => input.value)[0];

                if (selectedColorId) {
                    const variantWithColor = variants.find(v => v.attributes.includes(parseInt(selectedColorId)));
                    if (variantWithColor) {
                        variantImage.src = variantWithColor.image;
                        variantStock.textContent = variantWithColor.quantity;
                        variantInfo.style.display = 'block';
                    }
                }
            }

            function handleVariantChange() {
                const selectedInputs = [...document.querySelectorAll(
                    'input[type=radio][name^="attributes"]:checked')];
                const selectedIds = selectedInputs.map(input => parseInt(input.value)).sort((a, b) => a - b);

                // Tìm biến thể khớp toàn bộ tổ hợp (để hiện stock)
                let matchedVariant = null;

                for (const variant of variants) {
                    const attrs = variant.attributes.slice().sort((a, b) => a - b);
                    if (JSON.stringify(attrs) === JSON.stringify(selectedIds)) {
                        matchedVariant = variant;
                        break;
                    }
                }

                // Nếu có tổ hợp đầy đủ => cập nhật ảnh và số lượng
                if (matchedVariant) {
                    variantImage.src = matchedVariant.image;
                    variantStock.textContent = matchedVariant.quantity;
                    variantInfo.style.display = 'block';
                    return;
                }

                // Nếu chưa chọn đầy đủ nhưng chọn màu, sẽ cập nhật ảnh màu đầu tiên khớp
                const selectedColorId = selectedInputs.find(input => input.name.includes('color'))?.value;

                if (selectedColorId) {
                    const variantWithColor = variants.find(v => v.attributes.includes(parseInt(selectedColorId)));
                    if (variantWithColor) {
                        variantImage.src = variantWithColor.image;
                    }
                } else {
                    // Nếu chưa chọn gì thì dùng thumbnail mặc định
                    variantImage.src = "{{ asset('storage/' . $product->thumbnail) }}";
                }

                variantInfo.style.display = 'none'; // Ẩn stock nếu chưa chọn đủ tổ hợp
            }
        });
    </script>


    <script>
        // Tăng số lượng
        function incrementQuantity() {
            const input = document.getElementById('quantity');
            const max = parseInt(input.max);
            let current = parseInt(input.value) || 1;
            if (current < max) {
                input.value = current + 1;
            }
        }

        // Giảm số lượng
        function decrementQuantity() {
            const input = document.getElementById('quantity');
            let current = parseInt(input.value) || 1;
            if (current > 1) {
                input.value = current - 1;
            }
        }

        // Kiểm tra và hiển thị số lượng khi có đủ sản phẩm
        function enableQuantity() {
            const quantityContainer = document.getElementById('quantity-container');
            const input = document.getElementById('quantity');

            // Chỉ hiển thị phần số lượng khi có sản phẩm trong kho
            if (parseInt(input.max) > 0) {
                quantityContainer.style.display = 'block'; // Hiển thị lại phần số lượng
            } else {
                quantityContainer.style.display = 'none'; // Ẩn phần số lượng nếu không có sản phẩm trong kho
            }
        }

        // Hàm này gọi khi người dùng chọn sản phẩm hoặc biến thể
        function selectVariant() {
            enableQuantity(); // Kiểm tra và hiển thị phần số lượng
        }
    </script>



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
