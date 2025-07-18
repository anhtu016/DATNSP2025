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
                                $coupon = session('coupon');
                                $hasValidCoupon = isset($coupon['type'], $coupon['value']);
                                $selectedItems = old('selected_items', session('coupon.selected_items', []));
                                $selectedCount = count($selectedItems);

                                $subtotal = 0;
                                $discount = 0;
                                $total = 0;
                            @endphp
                            @foreach ($cart as $id => $item)
                                @php
                                    $itemTotal = $item['price'] * $item['quantity'];
                                    $subtotal += $itemTotal;
                                    $itemDiscount = 0;
                                    if ($hasValidCoupon && $selectedCount > 0 && in_array($id, $selectedItems)) {
                                        if ($coupon['type'] === 'fixed') {
                                            $itemDiscount = $coupon['discount_amount'] / $selectedCount;
                                        } elseif ($coupon['type'] === 'percentage') {
                                            $itemDiscount = ($itemTotal * $coupon['value']) / 100;
                                            if (
                                                isset($coupon['max_discount_value']) &&
                                                $itemDiscount > $coupon['max_discount_value']
                                            ) {
                                                $itemDiscount = $coupon['max_discount_value'];
                                            }
                                        }
                                    }
                                    $discount += $itemDiscount;
                                    $finalItemTotal = max($itemTotal - $itemDiscount, 0);
                                    $total += $finalItemTotal;
                                @endphp
                                <tr id="cart-item-{{ $id }}" class="text-center" data-id="{{ $id }}">
                                    @php
                                        $checkedItems = old('selected_items', session('coupon.selected_items', []));
                                    @endphp
                                    <td>
                                        <input type="checkbox" name="selected_items[]" value="{{ $id }}"
                                            class="cart-item-checkbox" data-price="{{ $item['price'] }}"
                                            data-quantity="{{ $item['quantity'] }}"
                                            data-max="{{ $item['quantity_variant'] ?? 99 }}"
                                            {{ in_array($id, $checkedItems) ? 'checked' : '' }}>
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
                                                <input type="text" name="quantity"
                                                    class="form-control form-control-sm text-center quantity-input"
                                                    style="width: 50px;" value="{{ $item['quantity'] }}"
                                                    data-max="{{ $item['quantity_variant'] ?? 99 }}"
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
                                        {{ number_format($finalItemTotal) }} VNĐ
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="table"></tr>
                            <td colspan="8" class="text-end align-bottom">Tạm tính:</td>
                            <td colspan="2" id="subtotal" class="align-bottom">{{ number_format($subtotal) }} VNĐ
                            </td>
                            </tr>
                            <tr id="total-row" style="display: none;"> <!-- <== thêm id và ẩn -->
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
                                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                                'content'),
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
                                    const max = parseInt(input.dataset.max) || 99;
                                    let quantity = parseInt(input.value) || 1;

                                    if (quantity < max) {
                                        input.value = quantity + 1;
                                        updateQuantity(id, quantity + 1);
                                    } else {
                                        Toastify({
                                            text: "⚠️ Sản phẩm đã đạt giới hạn tồn kho.",
                                            duration: 3000,
                                            gravity: "top",
                                            position: "right",
                                            backgroundColor: "#ff6b6b",
                                            stopOnFocus: true,
                                        }).showToast();
                                    }
                                });
                            });
                            document.querySelectorAll('.btn-decrease').forEach(button => {
                                button.addEventListener('click', function() {
                                    const id = this.dataset.id;
                                    const input = document.querySelector(`#cart-item-${id} .quantity-input`);
                                    let quantity = parseInt(input.value) || 1;
                                    if (quantity > 1) {
                                        input.value = quantity - 1;
                                        updateQuantity(id, quantity - 1);
                                    }
                                });
                            });
                            document.querySelectorAll('.quantity-input').forEach(input => {
                                input.addEventListener('change', function() {
                                    const id = this.dataset.id;
                                    let newQuantity = parseInt(this.value);
                                    const max = parseInt(this.dataset.max) || 99;

                                    if (isNaN(newQuantity) || newQuantity < 1) {
                                        newQuantity = 1;
                                    } else if (newQuantity > max) {
                                        Toastify({
                                            text: "⚠️ Sản phẩm đã đạt giới hạn tồn kho.",
                                            duration: 3000,
                                            gravity: "top",
                                            position: "right",
                                            backgroundColor: "#ff6b6b",
                                            stopOnFocus: true,
                                        }).showToast();
                                        newQuantity = max;
                                    }
                                    this.value = newQuantity;
                                    updateQuantity(id, newQuantity);
                                });
                                // Tùy chọn: khóa không cho nhập thủ công (chỉ dùng nút tăng giảm)
                                input.addEventListener('keydown', function(e) {
                                    // Chặn nhập chữ, chỉ cho phép các phím số, backspace, delete, mũi tên, tab
                                    if (!/[0-9]/.test(e.key) &&
                                        !['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'].includes(e.key)
                                    ) {
                                        e.preventDefault();
                                    }
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
                                const totalRow = document.getElementById('total-row');
                                if (hasCoupon && discount > 0) {
                                    totalRow.style.display = 'table-row';
                                } else {
                                    totalRow.style.display = 'none';
                                }
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
                                    selectAllCheckbox.indeterminate = !allChecked && Array.from(checkboxes).some(
                                        cb => cb.checked);
                                    calculateTotal(); // Cập nhật tổng khi thay đổi trạng thái checkbox
                                });
                            });
                            // không cho thanh toán khi chưa có sản phẩm
                            const form = document.querySelector("form");
                            const submitBtn = form.querySelector("button[type='submit']");
                            form.addEventListener("submit", function(e) {
                                const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                                if (!anyChecked) {
                                    e.preventDefault();
                                    alert("Chưa có sản phẩm nào để thanh toán.");
                                }
                            });
                            const checkoutForm = document.getElementById('checkout-form');
                            checkoutForm.addEventListener('submit', function(e) {
                                const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                                if (!anyChecked) {
                                    e.preventDefault();
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Chưa có sản phẩm!',
                                        text: 'Vui lòng chọn ít nhất một sản phẩm để thanh toán.',
                                        confirmButtonText: 'Đã hiểu'
                                    });
                                }
                            });
                            calculateTotal(); // Chạy lúc đầu
                        });
                    </script>
                    @if ($relatedProducts->isNotEmpty())
                        <div class="mt-5">
                            <h4>Sản phẩm gợi ý</h4>
                            <div class="row">
                                @foreach ($relatedProducts as $product)
                                    <div class="col-md-2 text-center mb-3">
                                        <a href="{{ route('product.show', $product->id) }}">
                                            <img src="{{ asset('storage/' . $product->thumbnail) }}" class="img-fluid"
                                                alt="{{ $product->name }}">
                                            <p class="mt-2">{{ $product->name }}</p>
                                            <p class="text-danger">{{ number_format($product->price) }} VNĐ</p>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggle-coupon');
            const couponBox = document.getElementById('coupon-box');
            const couponInput = document.querySelector('input[name="coupon_code"]');
            const radios = document.querySelectorAll('input[name="suggested_coupons[]"]');
            const form = document.getElementById('coupon-form');
            const checkboxes = document.querySelectorAll('.cart-item-checkbox');
            const applyBtn = document.getElementById('apply-coupon-btn');

            // Mở/tắt hộp thoại mã giảm giá
            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                couponBox.style.display = (couponBox.style.display === 'block') ? 'none' : 'block';
            });

            // Đóng khi click ra ngoài
            document.addEventListener('click', function(e) {
                if (!couponBox.contains(e.target) && e.target !== toggleBtn) {
                    couponBox.style.display = 'none';
                }
            });

            // Cập nhật UI dựa trên checkbox sản phẩm
            function updateCouponUI() {
                const anyChecked = Array.from(checkboxes).some(cb => cb.checked);

                radios.forEach(radio => {
                    radio.disabled = !anyChecked;
                    if (!anyChecked) radio.checked = false;
                });

                applyBtn.disabled = !anyChecked || !couponInput.value.trim();
            }

            updateCouponUI();

            // Khi thay đổi checkbox sản phẩm
            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateCouponUI);
            });

            // Khi nhập mã giảm giá thủ công
            couponInput.addEventListener('input', updateCouponUI);

            // Trước khi submit form thủ công
            form.addEventListener('submit', function(e) {
                const selected = Array.from(checkboxes).filter(cb => cb.checked);

                if (selected.length === 0) {
                    e.preventDefault();
                    alert('Vui lòng chọn ít nhất một sản phẩm để áp dụng mã giảm giá.');
                    return;
                }

                // Xóa các input hidden cũ
                form.querySelectorAll('input[name="selected_items[]"]').forEach(i => i.remove());

                // Thêm input hidden tương ứng sản phẩm được chọn
                selected.forEach(cb => {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'selected_items[]';
                    hidden.value = cb.value;
                    form.appendChild(hidden);
                });
            });

            // Tự động áp dụng khi chọn radio
            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        couponInput.value = this.value;

                        const selected = Array.from(checkboxes).filter(cb => cb.checked);
                        if (selected.length === 0) {
                            alert('Vui lòng chọn ít nhất một sản phẩm để áp dụng mã giảm giá.');
                            radio.checked = false;
                            return;
                        }

                        // Xóa các input hidden cũ
                        form.querySelectorAll('input[name="selected_items[]"]').forEach(i => i
                            .remove());

                        // Thêm input hidden tương ứng sản phẩm được chọn
                        selected.forEach(cb => {
                            const hidden = document.createElement('input');
                            hidden.type = 'hidden';
                            hidden.name = 'selected_items[]';
                            hidden.value = cb.value;
                            form.appendChild(hidden);
                        });

                        form.submit();
                    }
                });
            });
        });
    </script>


@endsection
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
