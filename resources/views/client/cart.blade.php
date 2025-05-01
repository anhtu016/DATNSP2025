@extends('client.layout.default')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="cart-table-container d-flex justify-content-between" style="height: 155vh;">
        <!-- Giỏ hàng -->
        <div class="cart-table-wrapper flex-fill">
            @if (count($cart) > 0)
                <table class="cart-table table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Size</th>
                            <th>Màu</th>
                            <th>Tổng</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
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
                            <tr>
                                <td><img src="{{ asset('storage/' . $item['thumbnail']) }}" alt="{{ $item['name'] }}"
                                        class="img-fluid" style="max-width: 80px;"></td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ number_format($item['price']) }} VNĐ</td>
                                <td class="align-middle text-center">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" id="update-form-{{ $id }}" class="d-inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                            class="form-control text-center" style="width: 80px; display: inline-block;">
                                    </form>
                                </td>
                                
                                <td>{{ $item['Size'] ?? 'Không chọn' }}</td>
                                <td>{{ $item['Color'] ?? 'Không chọn' }}</td>
                                <td>{{ number_format(max($finalItemTotal, 0)) }} VNĐ</td>
                                <td>
                                    <div class="cart-actions">
                                        <button type="submit" form="update-form-{{ $id }}"
                                            class="btn btn-success">Cập nhật</button>
                                        <form action="{{ route('cart.remove', $id) }}" method="POST" class="">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">Xóa</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($coupons->count())
                <div class="mt-5">
                    <details>
                        <summary class="btn btn-outline-primary">Mã giảm giá gợi ý (click để xem)</summary>
                        <div class="mt-3">
                            @foreach ($coupons as $coupon)
                                <div class="border p-3 mb-3 rounded shadow-sm {{ \Carbon\Carbon::parse($coupon->end_date)->isPast() ? 'bg-light text-muted' : 'bg-white' }}">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="mb-0">
                                            Mã: <strong id="code-{{ $coupon->id }}">{{ $coupon->code }}</strong>
                                        </h5>
                                        @if (!\Carbon\Carbon::parse($coupon->end_date)->isPast())
                                            <button class="btn btn-sm btn-outline-secondary" onclick="copyToClipboard('{{ $coupon->id }}')">📋 Sao chép</button>
                                        @else
                                            <span class="text-danger small">(Hết hạn)</span>
                                        @endif
                                    </div>
                                    <div class="row small">
                                        <div class="col-md-6">
                                            <ul class="list-unstyled mb-0">
                                                <li><strong>Giảm:</strong>
                                                    @if ($coupon->type === 'percentage')
                                                        {{ $coupon->value }}%
                                                    @elseif($coupon->type === 'fixed')
                                                        {{ number_format($coupon->value, 0, ',', '.') }}₫
                                                    @endif
                                                </li>
                                                @if ($coupon->min_order_value)
                                                    <li><strong>Đơn tối thiểu:</strong> {{ number_format($coupon->min_order_value, 0, ',', '.') }}₫</li>
                                                @endif
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="list-unstyled mb-0">
                                                @if ($coupon->max_discount_value)
                                                    <li><strong>Giảm tối đa:</strong> {{ number_format($coupon->max_discount_value, 0, ',', '.') }}₫</li>
                                                @endif
                                                <li><strong>Hạn dùng:</strong> {{ \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y') }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                    </details>
                </div>
            @endif
                <div class="mt-4">
                    @if ($hasValidCoupon)
                        @php
                            $expired =
                                isset($coupon['end_date']) && \Carbon\Carbon::parse($coupon['end_date'])->isPast();
                        @endphp

                        @if (!$expired)
                            <div class="alert alert-success">
                                ✅ Mã giảm giá đã được áp dụng: <strong>{{ $coupon['code'] }}</strong>
                            </div>
                        @else
                            <div class="alert alert-danger">
                                ❌ Mã giảm giá <strong>{{ $coupon['code'] }}</strong> đã hết hạn và sẽ không được áp dụng.
                            </div>
                        @endif
                    @else
                        <form action="{{ route('cart.applyCoupon', $id ?? 0) }}" method="POST" class="row">
                            @csrf
                            <div class="col-12 mt-4">
                                <input type="text" name="coupon_code" placeholder="Nhập mã giảm giá"
                                    class="form-control">
                            </div>
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary w-20">Áp dụng</button>
                            </div>
                        </form>
                    @endif

                    <div class="mt-3">
                        @if (session('coupon'))
                            <form action="{{ route('coupon.remove') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Hủy mã giảm giá</button>
                            </form>
                        @else
                            <p>Chưa có mã giảm giá nào áp dụng.</p>
                        @endif
                    </div>
                </div>

                <div class="cart-totals mt-4">
                    @if ($hasValidCoupon)
                        <p>Giảm giá: -{{ number_format($discount) }} VNĐ</p>
                    @endif
                    <p><strong>Tổng cộng: {{ number_format($total) }} VNĐ</strong></p>
                </div>

                <a href="{{ route('checkout.form') }}" class="btn btn-success w-20">Tiến hành thanh toán</a>
            @else
                <p class="text-center fs-3">🛒 Giỏ hàng của bạn đang trống.</p>
            @endif
        </div>


    </div>
@endsection

