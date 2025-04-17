@extends('client.layout.default')

@section('content')
    <main>
        <!-- resources/views/checkout.blade.php -->
        <div class="checkout-container">
            <!-- Thông tin sản phẩm -->
            <div class="card">
                <h2>🛒 Sản phẩm trong giỏ hàng</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Ảnh</th>
                            <th>Tên</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $item)
                            <tr>
                                <td><img src="{{ asset('storage/' . $item['thumbnail']) }}" alt="Ảnh"></td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>{{ number_format($item['price']) }}₫</td>
                                <td>{{ number_format($item['price'] * $item['quantity']) }}₫</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        
            <!-- Thông tin đặt hàng -->
            <div class="card">
                <h2>📦 Thông tin đặt hàng</h2>
        
                @if (session('success'))
                    <div class="success">{{ session('success') }}</div>
                @endif
        
                <form method="POST" action="{{ route('checkout.store') }}">
                    @csrf
        
                    <div class="form-group">
                        <label>Địa chỉ giao hàng:</label>
                        <input type="text" name="shipping_address" value="{{ old('shipping_address') }}">
                        @error('shipping_address') <div class="error">{{ $message }}</div> @enderror
                    </div>
        
                    <div class="form-group">
                        <label>Phương thức giao hàng:</label>
                        <select name="shipping_method_id">
                            @foreach ($shippingMethods as $id => $name)
                                <option value="{{ $id }}" {{ old('shipping_method_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('shipping_method_id') <div class="error">{{ $message }}</div> @enderror
                    </div>
        
                    <div class="form-group">
                        <label>Phương thức thanh toán:</label>
                        <select name="payment_methods_id">
                            @foreach ($paymentMethods as $id => $name)
                                <option value="{{ $id }}" {{ old('payment_methods_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('payment_methods_id') <div class="error">{{ $message }}</div> @enderror
                    </div>
        
                    <div class="form-group">
                        <label>Tổng tiền:</label>
                        <input type="text" value="{{ number_format($total) }}₫" readonly>
                        <input type="hidden" name="total_amount" value="{{ $total }}">
                    </div>
        
                    <div class="form-group">
                        <label>Tên khách hàng:</label>
                        <p>{{ $userName }}</p>
                    </div>
        
                    <div class="form-group">
                        <label>Số điện thoại:</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number') }}">
                        @error('phone_number') <div class="error">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Ngày đặt hàng:</label>
                        <input type="date" name="order_date" value="{{ old('order_date') }}">
                        @error('order_date') <div class="error">{{ $message }}</div> @enderror
                    </div>
                    
                    <button type="submit">✅ Xác nhận đặt hàng</button>
                </form>
            </div>
        </div>
        
    </main>

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
