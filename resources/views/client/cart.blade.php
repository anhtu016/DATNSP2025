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
                <table class="table table-hover table-bordered">
<thead class="table-light">
    <tr>
        <td colspan="8" class="fs-4 fw-bold text-center py-3">🛒 Sản phẩm trong giỏ hàng</td>
    </tr>
    <tr>
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
                        @endphp

                        @foreach ($cart as $id => $item)
                            @php
                                $itemTotal = $item['price'] * $item['quantity'];
                                $subtotal += $itemTotal;

                                $finalItemTotal = $itemTotal;

                                if ($hasValidCoupon) {
                                    if ($coupon['type'] === 'fixed') {
                                        $discount = $coupon['value'];
                                        $finalItemTotal -= $coupon['value'] / count($cart);
                                    } elseif ($coupon['type'] === 'percentage') {
                                        $discount = ($subtotal * $coupon['value']) / 100;
                                        $finalItemTotal -= ($itemTotal * $coupon['value']) / 100;
                                    }
                                }

                                $total += max($finalItemTotal, 0);
                            @endphp
                            <tr class="text-center">
                                <td class="align-middle"><img
                                        src="{{ asset('storage/' . ($item['variant_image'] ?? $item['thumbnail'])) }}"
                                        alt="{{ $item['name'] }}" class="img-thumbnail" width="70"></td>
                                <td class="align-middle">{{ $item['name'] }}</td>
                                <td class="align-middle">{{ number_format($item['price']) }} VNĐ</td>
                                <td class="text-center align-middle"
                                    style="display: flex; justify-content: center; align-items: center; height: 100px;">
                                    <form action="{{ route('cart.update', $id) }}" method="POST"
                                        id="update-form-{{ $id }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                            class="form-control" style="width: 60px;">
                                    </form>
                                </td>
                                <td class="align-middle">{{ $item['Size'] ?? 'Không chọn' }}</td>
                                <td class="align-middle">{{ $item['Color'] ?? 'Không chọn' }}</td>
                                <td class="align-middle">{{ number_format(max($finalItemTotal, 0)) }} VNĐ</td>
                                <td class="align-middle">
                                    <button type="submit" form="update-form-{{ $id }}"
                                        class="btn btn-sm btn-success">Cập nhật</button>
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
                            <td colspan="8">
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

                                            @if ($coupons->count())
                                                <div class="mt-3">
                                                    @foreach ($coupons->take(3) as $coupon)
                                                        @php $isExpired = \Carbon\Carbon::parse($coupon->end_date)->isPast(); @endphp
                                                        <div class="border rounded p-2 mb-2 bg-light position-relative">
                                                            <div class="d-flex align-items-center">
                                                                <!-- Ảnh nằm bên trái -->
                                                                <div class="me-3">
                                                                    <div class="coupon-image" style="width: 105px;">
                                                                        <!-- Giảm kích thước ảnh -->
                                                                        <img src="{{ asset('client/img/coupon2.jpg') }}"
                                                                            alt="Coupon Image" class="img-fluid" />
                                                                    </div>
                                                                </div>

                                                                <!-- Thông tin mã giảm giá ở giữa -->
                                                                <div class="flex-grow-1">
                                                                    <div class="small text-start"
                                                                        style="font-size: 0.85rem;">
                                                                        <!-- Giảm kích thước chữ -->
                                                                        <div><strong>{{ $coupon->code }}</strong> -
                                                                            {{ $coupon->type === 'percentage' ? $coupon->value . '%' : number_format($coupon->value, 0, ',', '.') . '₫' }}
                                                                            @if ($isExpired)
                                                                                <span class="text-danger">(Hết hạn)</span>
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

                                                                <!-- Nút radio nằm bên phải -->
                                                                @if (!$isExpired)
    <div class="ms-3">
        <input type="radio" name="suggested_coupons[]"
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

                        <tr class="">
                      
                        </tr>

                        <tr>
                            <td colspan="6" class="text-end">Tạm tính:</td>
                            <td colspan="2">{{ number_format($subtotal) }} VNĐ</td>
                        </tr>
                        @if ($hasValidCoupon)
                            <tr>
                                <td colspan="6" class="text-end">Giảm giá:</td>
                                <td colspan="2">-{{ number_format($discount) }} VNĐ</td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="6" class="text-end fw-bold">Tổng cộng:</td>
                            <td colspan="2" class="fw-bold text-danger">{{ number_format($total) }} VNĐ</td>
                        </tr>
                        <tr>
                            <td colspan="8" class="text-end">
                                <a href="{{ route('checkout.form') }}" class="btn btn-success" style="margin-right: 80px;">Tiến hành thanh toán</a>

                            </td>
                            
                        </tr>
                    </tbody>
                </table>
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
    </style>

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
