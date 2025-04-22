@extends('admin.layout.default')
@section('content')
    <div class="container py-5 ">
        <div class="card shadow rounded">
            <div class="card-body">
                <h2 class="mb-4 mt-4">Chi tiết đơn hàng <span class="text-primary">#{{ $order->id }}</span></h2>

                <div class="mb-4">
                    <p><strong>👤 Khách hàng:</strong> {{ $order->customer->name ?? 'N/A' }}</p>
                    <p><strong>📞 SĐT:</strong> {{ $order->phone_number }}</p>
                    <p><strong>📍 Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                    <p><strong>⏰ Ngày đặt:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</p>
                    <p><strong>📦 Trạng thái:</strong>
                        <span
                            class="badge 
                        @if ($order->order_status == 'pending') bg-warning
                         @elseif($order->order_status == 'processing') bg-primary
                          @elseif($order->order_status == 'delivering') bg-secondary 
                        @elseif($order->order_status == 'shipped') bg-info
                        @elseif($order->order_status == 'delivered') bg-success
                        @elseif($order->order_status == 'cancelled') bg-danger
                         @elseif($order->order_status == 'cancel_requested') bg-dark @endif">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </p>

                </div>

                <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="mb-4">
                    @csrf
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label for="order_status" class="form-label">Thay đổi trạng thái:</label>
                            <select name="order_status" id="order_status" class="form-select" @disabled(in_array($order->order_status, ['cancel_requested', 'cancelled']))>

                                <option value="pending" @selected($order->order_status == 'pending')>Chờ xử lý</option>
                                <option value="processing" @selected($order->order_status == 'processing')>Đang xử lý đơn hàng</option>
                                <option value="delivering" @selected($order->order_status == 'delivering')>Đang giao hàng</option>
                                <option value="shipped" @selected($order->order_status == 'shipped')>Đã giao hàng</option>
                                <option value="delivered" @selected($order->order_status == 'delivered')>Hoàn tất</option>
                                <option value="cancelled" @selected($order->order_status == 'cancelled')>Đã hủy</option>
                            </select>
                            @if ($order->order_status == 'cancel_requested')
                                <small class="text-warning">Yêu cầu hủy, không thể thay đổi trạng thái</small>
                            @endif
                        </div>
                        <div class="col-md-2">
                            @if (!in_array($order->order_status, ['cancel_requested', 'cancelled']))
                                <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
                            @endif

                        </div>
                    </div>
                </form>

                <h4 class="mb-3">🛒 Sản phẩm đã đặt</h4>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Thông số sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderDetail as $item)
                                <tr>
                                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                                    <td>
                                        @if ($item->variant && $item->variant->attributeValues)
                                            @foreach ($item->variant->attributeValues as $attrValue)
                                                <span class="badge bg-secondary">
                                                    {{ $attrValue->attribute->name ?? '' }}: {{ $attrValue->value }}
                                                </span>
                                            @endforeach
                                        @else
                                            <em>Không có</em>
                                        @endif
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price) }}đ</td>
                                    <td>{{ number_format($item->total) }}đ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- End Page-content -->

    <!-- css-->
    @push('admin_css')
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}">

        <!-- jsvectormap css -->
        <link href="{{ asset('admin/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

        <!--Swiper slider css-->
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

        <!--Swiper slider js-->
        <script src="{{ asset('admin/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

        <!-- Dashboard init -->
        <script src="{{ asset('admin/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('admin/assets/js/app.js') }}"></script>
    @endpush
    <!--end js-->
@endsection
