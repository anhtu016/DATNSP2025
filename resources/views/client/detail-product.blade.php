@extends('client.layout.default')
@section('content')
    <main>
        <div class="container mt-5">
            <div class="row g-4">
                <!-- Ảnh sản phẩm -->
                <div class="col-md-6 d-flex align-items-center justify-content-center">
                    <div class="border rounded shadow-sm p-3 bg-white">
                        <img  id="product-image" src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
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
                                                <input type="radio" class="btn-check" name="attributes[{{ $attrName }}]"
                                                    id="{{ $attrName }}_{{ $value->id }}" value="{{ $value->id }}"
                                                    required>
                                                <label class="btn btn-outline-dark"
                                                    for="{{ $attrName }}_{{ $value->id }}">
                                                    {{ $value->value }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                                <div class="mb-3">
                                    <p class="text-success fw-semibold">
                                        Tổng số sản phẩm còn : <span id="total-stock">{{ $product->quantity }}</span> sản phẩm
                                    </p>
                                    <p id="variant-info" style="display:none;">
                                        Số lượng: <span id="variant-stock"></span> sản phẩm
                                    </p>
                                </div>


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
                            <div class="alert alert-warning mt-4">
                                Bạn cần <a href="{{ route('login') }}" class="fw-bold text-decoration-underline">đăng nhập</a>
                                để mua hàng.
                            </div>
                        @endauth
                    </div>
                </div>











            </div>
        </div>


        <!-- /row -->

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
                                            @if ($reviews->status == 1)
                                                <!-- Chỉ hiển thị nếu status = 1 -->
                                                <div class="review_content">
                                                    <div class="clearfix add_bottom_10">
                                                        <span class="rating">
                                                            @for ($i = 1; $i <= $reviews->rating; $i++)
                                                                <i class="icon-star filled"></i>
                                                            @endfor
                                                            <em>{{ number_format($reviews->rating, 1) }}/5.0 (đánh
                                                                giá)</em>
                                                        </span>
                                                    </div>
                                                    <h4>{{ $reviews->user->name }}</h4>
                                                    <p>{{ $reviews->description }}</p>
                                                    <img src="{{ asset('storage/' . $reviews->image) }}" alt="Ảnh đánh giá"
                                                        width="150px">

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

            <div class="tabs_product">
                <div class="container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a id="tab-B" href="#pane-B" class="nav-link" data-bs-toggle="tab"
                                role="tab">Reviews</a>
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
                            </div>
                            <div id="collapse-A" class="collapse" role="tabpanel" aria-labelledby="heading-A">


                                <div class="feat">
                                    <div class="container">


                                        <!-- /TAB A -->
                                        <div id="pane-B" class="card tab-pane fade" role="tabpanel"
                                            aria-labelledby="tab-B">
                                            <div class="card-header" role="tab" id="heading-B">
                                                <h5 class="mb-0">
                                                    <a class="collapsed" data-bs-toggle="collapse" href="#collapse-B"
                                                        aria-expanded="false" aria-controls="collapse-B">
                                                        Reviews
                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="collapse-B" class="collapse" role="tabpanel"
                                                aria-labelledby="heading-B">
                                                <div class="card-body">
                                                    <div class="row justify-content-between">
                                                        <div class="col-lg-6">
                                                            @foreach ($loadReviews as $reviews)
                                                                <div class="review_content">
                                                                    <div class="clearfix add_bottom_10">
                                                                        <span class="rating">
                                                                            @for ($i = 1; $i <= $reviews->rating; $i++)
                                                                                <i class="icon-star filled"></i>
                                                                            @endfor
                                                                            <em>{{ number_format($reviews->rating, 1) }}/5.0
                                                                                (đánh giá)
                                                                            </em>
                                                                        </span>
                                                                    </div>
                                                                    <h4>{{ $reviews->user->name }}</h4>
                                                                    <p>{{ $reviews->description }}</p>

                                                                </div>
                                                            @endforeach
                                                        </div>

                                                    </div>
                                                    <!-- /row -->

                                                    <!-- /row -->
                                                    <p class="text-end"><a href="leave-review.html" class="btn_1">Leave
                                                            a review</a></p>
                                                </div>
                                                <!-- /card-body -->
                                            </div>
                                        </div>


                                    </div>
                                    <!-- /tab-content -->
                                </div>
                                <!-- /container -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>


    </main>
    <script>
        const variants = @json($variantsData);
    </script>
    
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variantInfo = document.getElementById('variant-info');
            const variantStock = document.getElementById('variant-stock');
            const totalStock = document.getElementById('total-stock');

            const variantStockData = @json($variantStock);

            // Bắt sự kiện click trên tất cả các label
            document.querySelectorAll('label.btn-outline-dark').forEach(label => {
                label.addEventListener('click', function() {
                    // Delay 1 chút để đảm bảo input được chọn sau khi label được click
                    setTimeout(() => {
                        let selectedAttributes = {};

                        document.querySelectorAll(
                                'input[type="radio"][name^="attributes"]:checked')
                            .forEach(checked => {
                                const name = checked.name.replace('attributes[', '')
                                    .replace(']', '');
                                selectedAttributes[name] = checked.value;
                            });

                        // Nếu đã chọn đủ tất cả thuộc tính
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
                        } else {
                            variantInfo.style.display = 'none';
                        }
                    }, 50); // Delay ngắn để chờ radio được checked
                });
            });
        });
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const variantImage = document.getElementById('product-image');
        const variantStock = document.getElementById('variant-stock');
        const variantInfo = document.getElementById('variant-info');
        const totalStock = document.getElementById('total-stock');

        const attributeInputs = document.querySelectorAll('input[type=radio][name^="attributes"]');
        const selectedColorInput = document.querySelectorAll('input[type=radio][name="attributes[color]"]'); // Chọn các input màu sắc

        // Lắng nghe sự kiện thay đổi cho màu sắc
        selectedColorInput.forEach(input => {
            input.addEventListener('change', handleColorChange);
        });

        // Lắng nghe sự kiện thay đổi các thuộc tính khác
        attributeInputs.forEach(input => {
            input.addEventListener('change', handleVariantChange);
        });

        function handleColorChange() {
            const selectedColorId = [...document.querySelectorAll('input[type=radio][name="attributes[color]"]:checked')]
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
            const selectedInputs = [...document.querySelectorAll('input[type=radio][name^="attributes"]:checked')];
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
