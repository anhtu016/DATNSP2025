@extends('client.layout.default')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close p-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

        <main class="checkout-wrapper py-4" style="background: #f5f5f5; min-height: 100vh;">
    <div class="container" style="max-width: 900px;">

        {{-- Địa chỉ nhận hàng --}}
        <div class="bg-white p-3 rounded shadow-sm mb-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <strong>{{ $userName }}</strong>  {{ old('phone_number', '') }}<br>
                    {{-- <span>{{ old('shipping_address', 'Chưa nhập địa chỉ') }}</span> --}}
                </div>
                {{-- <a href="#" onclick="document.getElementById('shipping-form').scrollIntoView();" class="text-primary fw-semibold">Thay đổi</a> --}}
            </div>
        </div>

        {{-- Danh sách sản phẩm --}}
        <div class="bg-white p-3 rounded shadow-sm mb-3">
            <h5 class="fw-bold mb-3">Sản phẩm</h5>
            @foreach ($cart as $item)
                <div class="d-flex border-top py-3">
                    <div class="me-3">
                        <img src="{{ asset('storage/' . $item['thumbnail']) }}" alt="Ảnh"
                             class="img-thumbnail" style="width: 80px; height: 80px;">
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold">{{ $item['name'] }}</div>
                        <div class="text-muted small">Phân loại: {{ $item['Color'] ?? 'Không' }} / {{ $item['Size'] ?? 'Không' }}</div>
                        <div class="text-muted small">Số lượng: x{{ $item['quantity'] }}</div>
                    </div>
                    <div class="text-end">
                        @if ($item['discount_amount'] > 0)
                            <del class="text-muted small">{{ number_format($item['total']) }}₫</del><br>
                            <strong class="text-danger">{{ number_format($item['total_after_discount']) }}₫</strong>
                        @else
                            <strong>{{ number_format($item['total']) }}₫</strong>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Mã giảm giá --}}
        <div class="bg-white p-3 rounded shadow-sm mb-3">
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
                        
                                        <div class="position-relative text-end" style="display: inline-block;">
                                            <div class="m-4 text-end">
                                                <a class="btn btn-outline-primary" id="toggle-coupon">🎁 Ưu đãi dành cho bạn ! xem thêm voucher !</a>
                                            </div>

                                            <!-- Hộp thoại voucher -->
                                            <div class="coupon-box" id="coupon-box" style="display:none;">
                                                <p class="small">✨ Ưu đãi cho bạn:</p>

                                                <!-- Form áp dụng mã giảm giá -->
                                                <form action="{{ route('order.storeCoupon', $id ?? 0) }}" method="POST"
                                                    id="coupon-form">
                                                    @csrf
                                                    <div class="d-flex mb-2">
                                                        <input type="text" name="coupon_code" class="form-control"
                                                            placeholder="Nhập mã giảm giá của shop" style="flex: 1;">
                                                        <button class="btn btn-sm btn-primary ms-2 m-0" type="submit"
                                                            id="apply-coupon-btn"  style="font-size: 12px;">
                                                            Áp dụng
                                                        </button>
                                                    </div>

                                                    <!-- Mã giảm giá gợi ý -->
                                                    @if ($coupons->count())
                                                        <div class="mt-3">
                                                            @foreach ($coupons->take(3) as $coupon)
                                                                @php $isExpired = \Carbon\Carbon::parse($coupon->end_date)->isPast(); @endphp
                                                                <div
                                                                    class="border rounded p-2 mb-2 bg-light position-relative d-flex align-items-center">
                                                                    <div class="me-3" style="width: 105px;">
                                                                        <img src="{{ asset('client/img/coupon2.jpg') }}"
                                                                            alt="Coupon Image" class="img-fluid" />
                                                                    </div>
                                                                    <div class="flex-grow-1 small text-start"
                                                                        style="font-size: 0.85rem;">
                                                                        <div>
                                                                            <strong>{{ $coupon->code }}</strong> -
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
                                                                    @if (!$isExpired)
                                                                        <div class="ms-3">
                                                                            <input type="radio" name="suggested_coupons[]"
                                                                                value="{{ $coupon->code }}"
                                                                                @if (session()->has('coupon') && session('coupon')['code'] === $coupon->code) checked @endif
                                                                                >
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </form>

                                                <!-- Hiển thị mã giảm giá đang áp dụng -->
                                                @if (session()->has('coupon'))
                                                    <div class="mt-3">
                                                        <div class="border rounded p-2 mb-2 bg-light position-relative">
                                                            <div class="d-flex align-items-center">
                                                                <div class="me-3" style="width: 105px;">
                                                                    <img src="{{ asset('client/img/coupon2.jpg') }}"
                                                                        alt="Coupon Image" class="img-fluid" />
                                                                </div>

                                                                <div class="flex-grow-1 small text-start"
                                                                    style="font-size: 0.85rem;">
                                                                    <strong>{{ session('coupon')['code'] }}</strong> -
                                                                    @if (session('coupon')['type'] === 'percentage')
                                                                        {{ session('coupon')['value'] }}%
                                                                    @else
                                                                        {{ number_format(session('coupon')['value'], 0, ',', '.') }}₫
                                                                    @endif
                                                                </div>
                                                                <div class="ms-3">
                                                                    <form action="{{ route('coupon.remove') }}"
                                                                        method="POST" style="margin:0;">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-danger">Hủy</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>







                                </td>
                            </tr> 
        </div>

        {{-- Hình thức giao hàng & thanh toán --}}
        <form method="POST" action="{{ route('checkout.store') }}">
            @csrf
            <div class="bg-white p-3 rounded shadow-sm mb-3" id="shipping-form">
                <h5 class="fw-bold mb-3">🚚 Giao hàng & Thanh toán</h5>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Địa chỉ nhận hàng:</label>
                    <input type="text" name="shipping_address" class="form-control" value="{{ old('shipping_address') }}">
                    @error('shipping_address')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row gx-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Phương thức giao hàng:</label>
                        <select name="shipping_method_id" class="form-select">
                            <option value="">Thay đổi</option>
                            @foreach ($shippingMethods as $id => $name)
                                <option value="{{ $id }}" {{ old('shipping_method_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('shipping_method_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Phương thức thanh toán:</label>
                        <select name="payment_methods_id" class="form-select">
                            <option value="">Thay đổi</option>
                            @foreach ($paymentMethods as $id => $name)
                                <option value="{{ $id }}" {{ old('payment_methods_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('payment_methods_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Số điện thoại:</label>
                    <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}">
                    @error('phone_number')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- Tổng kết đơn hàng --}}
            <div class="bg-white p-3 rounded shadow-sm mb-4">
                {{-- <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Tạm tính</span>
                    <span>{{ number_format($totalBeforeDiscount) }}₫</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Phí vận chuyển</span>
                    <span>{{ number_format($shippingFee ?? 0) }}₫</span>
                </div> --}}
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Số tiền giảm giá</span>
                    <span class="text-success">-{{ number_format($discountAmount) }}₫</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fs-5 fw-bold text-danger">
                    <span>Tổng thanh toán</span>
                    <span>{{ number_format($totalAfterDiscount) }}₫</span>
                </div>
            </div>

            {{-- Nút đặt hàng --}}
            <div class="text-end">
                <button type="submit" class="btn btn-danger px-5 py-2 fs-5 fw-semibold">Đặt hàng</button>
            </div>
        </form>
    </div>
</main>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('toggle-coupon');
        const couponBox = document.getElementById('coupon-box');
        const couponInput = document.querySelector('input[name="coupon_code"]');
        const radios = document.querySelectorAll('input[name="suggested_coupons[]"]');
        const form = document.getElementById('coupon-form');
        const checkboxes = document.querySelectorAll('.cart-item-checkbox');

        // Mở/tắt hộp thoại mã giảm giá
        toggleBtn?.addEventListener('click', function (e) {
            e.stopPropagation();
            couponBox.style.display = (couponBox.style.display === 'block') ? 'none' : 'block';
        });

        // Đóng hộp thoại nếu click ra ngoài
        document.addEventListener('click', function (e) {
            if (!couponBox.contains(e.target) && e.target !== toggleBtn) {
                couponBox.style.display = 'none';
            }
        });

        // Bỏ hết disable - không cần kiểm tra checkbox nữa

        // Khi submit form, vẫn thêm selected_items[] để server biết
        form?.addEventListener('submit', function (e) {
            // Xóa các input hidden cũ
            form.querySelectorAll('input[name="selected_items[]"]').forEach(i => i.remove());

            const selected = Array.from(checkboxes).filter(cb => cb.checked);
            selected.forEach(cb => {
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'selected_items[]';
                hidden.value = cb.value;
                form.appendChild(hidden);
            });
        });

        // Khi chọn radio gợi ý => tự động set coupon_input và submit
        radios.forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.checked) {
                    couponInput.value = this.value;

                    // Xóa các input hidden cũ
                    form.querySelectorAll('input[name="selected_items[]"]').forEach(i => i.remove());

                    const selected = Array.from(checkboxes).filter(cb => cb.checked);
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
