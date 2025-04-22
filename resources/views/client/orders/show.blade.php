@extends('client.layout.default')

@section('content')
    <div class="container">
        <h2 class="mb-4">🧾 Chi tiết đơn hàng</h2>

        <!-- Flash message -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Thông tin chung -->
        <div class="card-body mb-4">
            <h5>Thông tin đơn hàng</h5>
            <p><strong>Ngày đặt:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</p>
            <p><strong>Phương thức thanh toán:</strong> {{ $order->paymentMethod->name ?? 'Thanh Toán khi nhận hàng' }}</p>
            <p><strong>Phương thức vận chuyển:</strong> {{ $order->shippingMethod->name ?? 'Giao hàng tiết kiệm' }}</p>
            <p><strong>Địa chỉ nhận hàng:</strong> {{ $order->shipping_address }}</p>

            <div id="order-status-partial">
                @include('client.orders.order-status', ['order' => $order, 'daysSinceDelivered' => $daysSinceDelivered])
            </div>
            <script>
                setInterval(() => {
                    fetch("{{ route('order.status.partial', $order->id) }}")
                        .then(res => res.text())
                        .then(html => {
                            document.getElementById('order-status-wrapper').innerHTML = html;
                        })
                        .catch(err => console.error('Lỗi khi load trạng thái đơn hàng:', err));
                }, 3000); // 5 giây
            </script>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="card mb-4">
            <div class="card-body">
                <h5>Sản phẩm trong đơn hàng</h5>
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Ảnh</th>
                                <th>Sản phẩm</th>
                                <th>Thông số sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderDetails as $item)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . ($item->product->thumbnail ?? 'default.png')) }}"
                                            width="100px" alt="">
                                    </td>
                                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                                    <td>
                                        @if ($item->variant && $item->variant->attributeValues)
                                            @foreach ($item->variant->attributeValues as $value)
                                                <span class="badge bg-secondary">{{ $value->attribute->name }}:
                                                    {{ $value->value }}</span>
                                            @endforeach
                                        @else
                                            ---
                                        @endif
                                    </td>

                                    <td>{{ number_format($item->price) }}đ</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price * $item->quantity) }}đ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Tổng tiền -->
                <div class="d-flex justify-content-end mt-3">
                    <h5><strong>Tổng thanh toán: {{ number_format($order->total_amount) }}đ</strong></h5>
                </div>
            </div>
        </div>
    </div>
    

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
