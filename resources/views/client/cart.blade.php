@extends('client.layout.default')

@section('content')
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="cart-table-container " style="height:90vh;">
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
                            $discount = $subtotal * $coupon['value'] / 100;
                            $finalItemTotal -= ($itemTotal * $coupon['value'] / 100);
                        }
                    }
        
                    $total += max($finalItemTotal, 0);
                @endphp
                <tr>
                    <td><img src="{{ asset('storage/' . $item['thumbnail']) }}" alt="{{ $item['name'] }}" class="img-fluid" style="max-width: 80px;"></td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ number_format($item['price']) }} VNĐ</td>
                    <td>
                        <form action="{{ route('cart.update', $id) }}" method="POST" id="update-form-{{ $id }}">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control">
                        </form>
                    </td>
                    <td>{{ $item['Size'] ?? 'Không chọn' }}</td>
                    <td>{{ $item['Color'] ?? 'Không chọn' }}</td>
                    <td>{{ number_format(max($finalItemTotal, 0)) }} VNĐ</td>
                    <td>
                        <div class="cart-actions">
                            <button type="submit" form="update-form-{{ $id }}" class="btn btn-success">Cập nhật</button>
                            <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
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
        <div class="mt-4">
            @if ($hasValidCoupon)
                @php
                    $expired = isset($coupon['end_date']) && \Carbon\Carbon::parse($coupon['end_date'])->isPast();
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
                    <div class="col-3 mt-4">
                        <input type="text" name="coupon_code" placeholder="Nhập mã giảm giá" class="form-control">
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-primary">Áp dụng</button>
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

        <a href="{{ route('checkout.form') }}" class="btn btn-success">Tiến hành thanh toán</a>
    @else
        <p class="text-center fs-3">🛒 Giỏ hàng của bạn đang trống.</p>
    @endif
</div>


    <!-- css-->
    @push('admin_css')
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}">

        <!-- jsvectormap css -->
        <link href="{{ asset('admin/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Swiper slider css -->
        <link href="{{ asset('admin/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Layout config Js -->
        <script src="{{ asset('admin/assets/js/layout.js') }}"></script>

        <!-- Bootstrap Css -->
        <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Icons Css -->
        <link href="{{ asset('admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- App Css-->
        <link href="{{ asset('admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- custom Css-->
        <link href="{{ asset('admin/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush
    <!--end css-->

    <!-- js-->
    @push('admin_js')
        <!-- JAVASCRIPT -->
        <script src="{{ asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('admin/assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('admin/assets/libs/feather-icons/feather.min.js') }}"></script>
        <script src="{{ asset('admin/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
        <script src="{{ asset('admin/assets/js/plugins.js') }}"></script>

        <!-- apexcharts -->
        <script src="{{ asset('admin/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

        <!-- Vector map-->
        <script src="{{ asset('admin/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
        <script src="{{ asset('admin/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

        <!-- Swiper slider js-->
        <script src="{{ asset('admin/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

        <!-- Dashboard init -->
        <script src="{{ asset('admin/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('admin/assets/js/app.js') }}"></script>
    @endpush
    <!--end js-->
@endsection
