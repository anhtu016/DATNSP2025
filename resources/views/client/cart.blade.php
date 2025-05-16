@extends('client.layout.default')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="" style="height: 120vh;">
        @if (count($cart) > 0)
            <div class="container mt-4">
                <form action="{{ route('checkout.form') }}" method="GET" id="checkout-form">
                    @csrf
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <td colspan="9" class="fs-4 fw-bold text-center py-3">🛒 Sản phẩm trong giỏ hàng</td>
                            </tr>
                            <tr>
                                <th>
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </th>
                                <th>Ảnh</th>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Kích cỡ</th>
                                <th>Màu sắc</th>
                                <th>Số tiền</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>


                        <tbody>
                            {{-- KHỐI 1: DANH SÁCH SẢN PHẨM --}}

                            @php
                                $subtotal = 0;
                                $total = 0;
                                $discount = 0;
                                $coupon = session('coupon');
                                $hasValidCoupon = isset($coupon['type'], $coupon['value']);
                                $cartCount = max(count($cart), 1); // tránh chia 0
                            @endphp

                            @foreach ($cart as $id => $item)
                                @php
                                    $itemTotal = $item['price'] * $item['quantity'];
                                    $subtotal += $itemTotal;

                                    $itemDiscount = 0;

                                    if ($hasValidCoupon) {
                                        if ($coupon['type'] === 'fixed') {
                                            // Phân chia giảm giá đều cho mỗi item
                                            $itemDiscount = $coupon['value'] / $cartCount;
                                        } elseif ($coupon['type'] === 'percentage') {
                                            $itemDiscount = ($itemTotal * $coupon['value']) / 100;
                                        }
                                    }

                                    $finalItemTotal = max($itemTotal - $itemDiscount, 0); // tránh âm
                                    $discount += $itemDiscount;
                                    $total += $finalItemTotal;
                                @endphp
                                <tr id="cart-item-{{ $id }}" class="text-center" data-id="{{ $id }}">
                                    <td>
                                        <input type="checkbox" name="selected_items[]" value="{{ $id }}"
                                            class="cart-item-checkbox" data-price="{{ $item['price'] }}"
                                            data-quantity="{{ $item['quantity'] }}">
                                    </td>

                                    <td class="align-middle">
                                        <img src="{{ asset('storage/' . ($item['variant_image'] ?? $item['thumbnail'])) }}"
                                            alt="{{ $item['name'] }}" class="img-thumbnail" width="70">
                                    </td>

                                    <td class="align-middle">{{ $item['name'] }}</td>

                                    <td class="align-middle unit-price" data-price="{{ $item['price'] }}">
                                        {{ number_format($item['price']) }} VNĐ
                                    </td>

                                    <td class="text-center align-middle">
                                        <form action="{{ route('cart.update', $id) }}" method="POST"
                                            id="update-form-{{ $id }}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="d-flex justify-content-center align-items-center gap-1"
                                                style="max-width: 120px; margin: auto;">
                                                <button type="button"
                                                    class="btn btn-light border btn-sm px-2 btn-decrease mb-2"
                                                    data-id="{{ $id }}">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="text"
                                                    class="form-control form-control-sm text-center quantity-input"
                                                    style="width: 50px;" value="{{ $item['quantity'] }}"
                                                    data-id="{{ $id }}" min="1">
                                                <button type="button"
                                                    class="btn btn-light border btn-sm px-2 btn-increase mb-2"
                                                    data-id="{{ $id }}">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </td>

                                    <td class="align-middle">{{ $item['Size'] ?? 'Không chọn' }}</td>
                                    <td class="align-middle">{{ $item['Color'] ?? 'Không chọn' }}</td>

                                    <td class="align-middle item-total">
                                        {{ number_format(max($finalItemTotal, 0)) }} VNĐ
                                    </td>

                                    <td class="align-middle">
                                        {{-- <button type="submit" form="update-form-{{ $id }}"
                                            class="btn btn-sm btn-success">Cập nhật</button> --}}
                                        <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Xóa</button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach

                            {{-- KHỐI 2: MÃ GIẢM GIÁ --}}
                            <tr class="table">

                            </tr>
                            <tr>
                                <td colspan="9">
                                    <div class="d-flex gap-2">
                                        <style>
                                            .coupon-box {
                                                position: absolute;
                                                top: 100%;
                                                left: 0;
                                                width: 100%;
                                                max-width: 480px;
                                                background: white;
                                                border: 1px solid #ddd;
                                                border-radius: 8px;
                                                box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
                                                padding: 15px;
                                                display: none;
                                                z-index: 9999;
                                                animation: fadeInUp 0.3s ease-out;
                                            }

                                            .coupon-box p {
                                                font-size: 13px;
                                                margin-bottom: 10px;
                                            }

                                            .coupon-box .coupon-image {
                                                width: 60px;
                                            }

                                            .coupon-box .coupon-item {
                                                padding: 8px 10px;
                                                font-size: 13px;
                                            }

                                            .coupon-box .coupon-item strong {
                                                font-size: 14px;
                                            }


                                            .coupon-box.active {
                                                display: block;
                                            }

                                            .coupon-box p {
                                                font-size: 14px;
                                            }

                                            @keyframes fadeInUp {
                                                0% {
                                                    opacity: 0;
                                                    transform: translateY(20px);
                                                }

                                                100% {
                                                    opacity: 1;
                                                    transform: translateY(0);
                                                }
                                            }
                                        </style>

                                        <!-- Nút hiển thị voucher -->
                                        <div class="position-relative text-end" style="display: inline-block;">
                                            <div class="m-4 text-end">
                                                <a class="btn btn-outline-primary" id="toggle-coupon">
                                                    🎁 Ưu đãi lên đến 30% nhận voucher ngay !
                                                </a>
                                            </div>

                                            <!-- Hộp thoại voucher -->
                                            <div class="coupon-box" id="coupon-box">
                                                <p class="small">✨ Ưu đãi cho bạn:</p>
                                                <form action="{{ route('cart.applyCoupon', $id ?? 0) }}" method="POST">
                                                    @csrf
                                                    <div class="d-flex mb-2">
                                                        <input type="text" name="coupon_code" class="form-control"
                                                            placeholder="Nhập mã giảm giá của shop" style="flex: 1;">
                                                        <button class="btn btn-sm btn-primary ms-2 m-0" type="submit"
                                                            style="font-size: 12px;">Áp dụng</button>
                                                    </div>
                                                </form>

                                                @if (session()->has('coupon'))
                                                    <div class="mt-3">
                                                        <div class="border rounded p-2 mb-2 bg-light position-relative">
                                                            <div class="d-flex align-items-center">
                                                                <div class="me-3">
                                                                    <div class="coupon-image" style="width: 105px;">
                                                                        <img src="{{ asset('client/img/coupon2.jpg') }}"
                                                                            alt="Coupon Image" class="img-fluid" />
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <div class="small text-start"
                                                                        style="font-size: 0.85rem;">
                                                                        <div>
                                                                            <strong>{{ session('coupon')['code'] }}</strong>
                                                                            -
                                                                            @if (session('coupon')['type'] === 'percentage')
                                                                                {{ session('coupon')['value'] }}%
                                                                            @else
                                                                                {{ number_format(session('coupon')['value'], 0, ',', '.') }}₫
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="ms-3">
                                                                    <form action="{{ route('coupon.remove') }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-danger">Hủy</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($coupons->count())
                                                    <div class="mt-3">
                                                        @foreach ($coupons->take(3) as $coupon)
                                                            @php $isExpired = \Carbon\Carbon::parse($coupon->end_date)->isPast(); @endphp
                                                            <div
                                                                class="border rounded p-2 mb-2 bg-light position-relative">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="me-3">
                                                                        <div class="coupon-image" style="width: 105px;">
                                                                            <img src="{{ asset('client/img/coupon2.jpg') }}"
                                                                                alt="Coupon Image" class="img-fluid" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <div class="small text-start"
                                                                            style="font-size: 0.85rem;">
                                                                            <div><strong>{{ $coupon->code }}</strong> -
                                                                                {{ $coupon->type === 'percentage' ? $coupon->value . '%' : number_format($coupon->value, 0, ',', '.') . '₫' }}
                                                                                @if ($isExpired)
                                                                                    <span class="text-danger">(Hết
                                                                                        hạn)</span>
                                                                                @endif
                                                                            </div>
                                                                            @if ($coupon->min_order_value)
                                                                                <div>🛒 Đơn tối thiểu:
                                                                                    {{ number_format($coupon->min_order_value, 0, ',', '.') }}₫
                                                                                </div>
                                                                            @endif
                                                                            @if ($coupon->max_discount_value)
                                                                                <div>💸 Giảm tối đa:
                                                                                    {{ number_format($coupon->max_discount_value, 0, ',', '.') }}₫
                                                                                </div>
                                                                            @endif
                                                                            <div>📅 HSD:
                                                                                {{ \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y') }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @if (!$isExpired)
                                                                        <div class="ms-3">
                                                                            <input type="radio"
                                                                                name="suggested_coupons[]"
                                                                                value="{{ $coupon->code }}"
                                                                                @if (session()->has('coupon') && session('coupon')['code'] === $coupon->code) checked @endif>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>

                                        </div>



                                </td>
                            </tr>

                            {{-- KHỐI 3: TỔNG TIỀN & THANH TOÁN --}}
                            <tr class="table">

                            </tr>

                            <td colspan="8" class="text-end align-bottom">Tạm tính:</td>
                            <td colspan="2" id="subtotal" class="align-bottom">0 VNĐ</td>
                            </tr>

                            @if ($hasValidCoupon)
                                <tr>
                                    <td colspan="8" class="text-end align-bottom">Giảm giá:</td>
                                    <td colspan="2" id="discount" class="align-bottom">0 VNĐ</td>
                                </tr>
                            @endif

                            <tr>
                                <td colspan="8" class="text-end align-bottom fw-bold">Tổng cộng:</td>
                                <td colspan="2" class="fw-bold text-danger align-bottom" id="total">0 VNĐ</td>
                            </tr>

                            <tr>
                                <td colspan="8" class="text-end align-bottom">
                                <td colspan="2" class="fw-bold text-danger align-bottom" id="total"><button
                                        type="submit" class="btn btn-success" style="" colspan="2">Tiến hành
                                        thanh toán</button></td>

                                </td>
                            </tr>
                            </tr>


                        </tbody>
                    </table>

                    {{-- /tự động cập nhật --}}
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
    // --------- Cập nhật số lượng sản phẩm (AJAX) ----------
    const updateQuantity = (id, newQuantity) => {
        fetch("{{ url('/cart/update') }}/" + id, {
                method: "PATCH",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    quantity: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = document.querySelector(`#cart-item-${id}`);
                    row.querySelector('.quantity-input').value = newQuantity;

                    // Cập nhật lại data-quantity của checkbox để tính tổng
                    const checkbox = row.querySelector('.cart-item-checkbox');
                    if (checkbox) {
                        checkbox.dataset.quantity = newQuantity;
                    }

                    // ✅ Cập nhật lại cột Số tiền của từng dòng
                    const price = parseFloat(row.querySelector('.unit-price').dataset.price);
                    const itemTotal = row.querySelector('.item-total');
                    itemTotal.textContent = formatCurrency(price * newQuantity);

                    calculateTotal(); // Gọi lại tính tổng khi cập nhật số lượng
                }
            });
    };

    // --------- Định dạng tiền tệ ----------
    const formatCurrency = (amount) => amount.toLocaleString('vi-VN') + ' VNĐ';

    // --------- Xử lý tăng giảm số lượng ----------
    document.querySelectorAll('.btn-increase').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const input = document.querySelector(`#cart-item-${id} .quantity-input`);
            const quantity = parseInt(input.value) || 1;
            input.value = quantity + 1;
            updateQuantity(id, quantity + 1);
        });
    });

    document.querySelectorAll('.btn-decrease').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const input = document.querySelector(`#cart-item-${id} .quantity-input`);
            const quantity = parseInt(input.value) || 1;
            if (quantity > 1) {
                input.value = quantity - 1;
                updateQuantity(id, quantity - 1);
            }
        });
    });

    // --------- Xử lý khi người dùng nhập số lượng thủ công ----------
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const id = this.dataset.id;
            let newQuantity = parseInt(this.value);

            // Ràng buộc số lượng >= 1
            if (isNaN(newQuantity) || newQuantity < 1) {
                newQuantity = 1;
                this.value = 1;
            }

            updateQuantity(id, newQuantity);
        });
    });

    // --------- Tính tổng đơn hàng khi chọn sản phẩm ----------
    const checkboxes = document.querySelectorAll('.cart-item-checkbox');
    const subtotalEl = document.querySelector('#subtotal');
    const discountEl = document.querySelector('#discount');
    const totalEl = document.querySelector('#total');

    const hasCoupon = {{ $hasValidCoupon ? 'true' : 'false' }};
    const couponType = "{{ $coupon['type'] ?? '' }}";
    const couponValue = {{ $coupon['value'] ?? 0 }};
    const maxDiscountValue = {{ $coupon['max_discount_value'] ?? 'null' }};
    const minOrderValue = {{ $coupon['min_order_value'] ?? 0 }};

    // Hàm tính tổng
    function calculateTotal() {
        let subtotal = 0;

        checkboxes.forEach(cb => {
            if (cb.checked) {
                const price = parseFloat(cb.dataset.price);
                const quantity = parseInt(cb.dataset.quantity);
                subtotal += price * quantity;
            }
        });

        let discount = 0;

        if (hasCoupon && subtotal >= minOrderValue) {
            if (couponType === 'fixed') {
                discount = couponValue;
            } else if (couponType === 'percentage') {
                discount = subtotal * couponValue / 100;
                if (maxDiscountValue && discount > maxDiscountValue) {
                    discount = maxDiscountValue;
                }
            }

            if (discount > subtotal) discount = subtotal;
        }

        const total = subtotal - discount;

        subtotalEl.innerText = formatCurrency(subtotal);
        discountEl.innerText = formatCurrency(discount);
        totalEl.innerText = formatCurrency(total);
    }

    // --------- Chọn tất cả sản phẩm ----------
    const selectAllCheckbox = document.getElementById('select-all');
    selectAllCheckbox.addEventListener('change', function() {
        const isChecked = selectAllCheckbox.checked;
        checkboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        calculateTotal(); // Cập nhật tổng khi thay đổi trạng thái checkbox
    });

    // Cập nhật trạng thái "Chọn tất cả" nếu người dùng chọn/deselect một checkbox sản phẩm
    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = !allChecked && Array.from(checkboxes).some(cb => cb.checked);
            calculateTotal(); // Cập nhật tổng khi thay đổi trạng thái checkbox
        });
    });

    calculateTotal(); // Chạy lúc đầu
});

                    </script>




                </form>

            </div>
        @else
            <div class="text-center fs-4 mt-5">
                🛒 Giỏ hàng của bạn đang trống.
            </div>
        @endif
    </div>
    <style>
        .copy-btn {
            font-size: 12px;
            padding: 4px 8px;
        }

        .btn-increase,
        .btn-decrease {
            width: 32px;
            height: 32px;
            padding: 0;
            font-size: 18px;
        }

        .quantity-input {
            max-width: 50px;
            padding: 0;
        }
    </style>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const cartItemCheckboxes = document.querySelectorAll('.cart-item-checkbox');
    const subtotalEl = document.querySelector('#subtotal');
    const discountEl = document.querySelector('#discount');
    const totalEl = document.querySelector('#total');

    const hasCoupon = {{ $hasValidCoupon ? 'true' : 'false' }};
    const couponType = "{{ $coupon['type'] ?? '' }}";
    const couponValue = {{ $coupon['value'] ?? 0 }};
    const maxDiscountValue = {{ $coupon['max_discount_value'] ?? 'null' }};
    const minOrderValue = {{ $coupon['min_order_value'] ?? 0 }};

    // Chọn tất cả sản phẩm khi click vào checkbox "Chọn tất cả"
    selectAllCheckbox.addEventListener('change', function() {
        const isChecked = selectAllCheckbox.checked;
        cartItemCheckboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        calculateTotal(); // Cập nhật lại tổng khi thay đổi trạng thái checkbox
    });

    // Cập nhật trạng thái "Chọn tất cả" nếu người dùng chọn/deselect một checkbox sản phẩm
    cartItemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(cartItemCheckboxes).every(cb => cb.checked);
            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = !allChecked && Array.from(cartItemCheckboxes).some(cb => cb.checked);
            calculateTotal(); // Cập nhật lại tổng khi thay đổi trạng thái checkbox
        });
    });

    // Hàm tính tổng
    function calculateTotal() {
        let subtotal = 0;
        cartItemCheckboxes.forEach(cb => {
            if (cb.checked) {
                const price = parseFloat(cb.dataset.price);
                const quantity = parseInt(cb.dataset.quantity);
                subtotal += price * quantity;
            }
        });

        let discount = 0;
        // Nếu có mã giảm giá, tính giảm giá
        if (hasCoupon && subtotal >= minOrderValue) {
            if (couponType === 'fixed') {
                discount = couponValue;
            } else if (couponType === 'percentage') {
                discount = subtotal * couponValue / 100;
                if (maxDiscountValue && discount > maxDiscountValue) {
                    discount = maxDiscountValue;
                }
            }
        }

        const total = subtotal - discount;

        // Cập nhật giao diện
        subtotalEl.innerText = formatCurrency(subtotal);
        discountEl.innerText = formatCurrency(discount);
        totalEl.innerText = formatCurrency(total);
    }

    // Chạy tính toán ban đầu
    calculateTotal();
});

    </script> --}}
 

    {{-- script mã giảm giá --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggle-coupon');
            const couponBox = document.getElementById('coupon-box');
            const couponInput = document.querySelector('input[name="coupon_code"]');
            const radios = document.querySelectorAll('input[name="suggested_coupons[]"]'); // input type="radio"
            const form = couponInput.closest('form'); // Tìm form chứa input coupon_code

            // Toggle hiển thị coupon box
            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                couponBox.classList.toggle('active');
            });

            // Ẩn coupon box khi click ra ngoài
            document.addEventListener('click', function(e) {
                if (!couponBox.contains(e.target) && e.target !== toggleBtn) {
                    couponBox.classList.remove('active');
                }
            });

            // Xử lý sao chép mã thủ công (nếu còn dùng)
            document.querySelectorAll('.copy-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const code = this.getAttribute('data-code');
                    navigator.clipboard.writeText(code).then(() => {
                        alert('Đã sao chép mã: ' + code);
                    });
                });
            });

            // Tự động áp dụng khi chọn radio
            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        couponInput.value = this.value;
                        form.submit();
                    }
                });
            });
        });
    </script>




@endsection
