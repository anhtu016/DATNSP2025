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
                                <td>
                                    @if ($item['discount_amount'] > 0)
                                        <del>{{ number_format($item['total']) }}₫</del><br>
                                        <strong>{{ number_format($item['total_after_discount']) }}₫</strong>
                                    @else
                                        {{ number_format($item['total']) }}₫
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>
                <p>Mã giảm giá: {{ session('coupon.code') }}</p>
                <p>Giảm: -{{ number_format(session('coupon.discount_amount')) }}đ</p>
                <p class="text-danger">Tổng sau giảm: {{ number_format($total - session('coupon.discount_amount')) }}đ</p>
            </div>

            <!-- Thông tin đặt hàng -->
            <div class="card">
                <h2>📦 Thông tin đặt hàng</h2>

                @if (session('success'))
                    <div class="success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('checkout.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Địa chỉ giao hàng:</label>
                        <input type="text" name="shipping_address" class="form-control"
                            value="{{ old('shipping_address') }}">
                        @error('shipping_address')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Phương thức giao hàng:</label>
                            <select name="shipping_method_id" class="form-select">
                                @foreach ($shippingMethods as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('shipping_method_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('shipping_method_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Phương thức thanh toán:</label>
                            <select name="payment_methods_id" class="form-select">
                                @foreach ($paymentMethods as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('payment_methods_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_methods_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên khách hàng:</label>
                        <p class="form-control-plaintext">{{ $userName }}</p>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Số điện thoại:</label>
                            <input type="text" name="phone_number" class="form-control"
                                value="{{ old('phone_number') }}">
                            @error('phone_number')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Ngày đặt hàng:</label>
                            <input type="date" name="order_date" class="form-control" value="{{ old('order_date') }}">
                            @error('order_date')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3">
                        ✅ Xác nhận đặt hàng
                    </button>
                </form>

            </div>
        </div>

    </main>
@endsection
