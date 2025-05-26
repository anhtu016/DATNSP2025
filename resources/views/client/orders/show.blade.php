@extends('client.layout.default')

@section('content')
    <div class="container my-5">
        <h2 class="mb-4">🧾 Chi tiết đơn hàng</h2>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Thông tin đơn hàng --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Thông tin đơn hàng
            </div>
            <div class="card-body">
                <p><strong>🗓 Ngày đặt:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</p>
                <p><strong>💳 Thanh toán:</strong> {{ $paymentMethods[$order->payment_methods_id] ?? 'Không xác định' }}</p>
                <p><strong>🚚 Vận chuyển:</strong> {{ $shippingMethods[$order->shipping_method_id] ?? 'Không xác định' }}</p>
                <p><strong>📍 Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                <p><strong>🕒 Cập nhật:</strong> <span
                        id="updated-at">{{ \Carbon\Carbon::parse($order->updated_at)->format('d/m/Y H:i') }}</span></p>

                <p><strong>📌 Trạng thái:</strong>
                    <span class="badge bg-{{ $order->getStatusBadgeClass() }} fs-6" id="order-status"
                        data-order-id="{{ $order->id }}">
                        @switch($order->order_status)
                            @case('pending')
                                Chờ xử lý
                            @break

                            @case('processing')
                                Đang xử lý đơn hàng
                            @break

                            @case('delivering')
                                Đang giao hàng
                            @break

                            @case('shipped')
                                Đã giao hàng
                            @break

                            @case('delivered')
                                Hoàn tất
                            @break

                            @case('cancelled')
                                Đã hủy
                            @break

                            @case('cancel_requested')
                                Yêu cầu hủy
                            @break

                            @default
                                Không xác định
                        @endswitch
                    </span>
                </p>


                @if ($daysSinceDelivered !== null)
                    {{-- <p class="text-muted">📦 Đơn hàng đã giao được {{ $daysSinceDelivered }} ngày.</p> --}}
                @endif
            </div>
        </div>

        {{-- Nút hành động --}}
        <div class="mb-4">
            @if ($order->order_status === 'delivered' && !$order->is_confirmed)
                <form id="confirm-order-form" action="{{ route('user.orders.confirm', $order->id) }}" method="POST" class="d-inline-block">
    @csrf
    @method('PUT')
    <button type="button" id="confirm-order-btn"
        class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out flex items-center gap-2">
        <span>Xác nhận đã hoàn thành đơn hàng</span>
    </button>
</form>
<script>
    document.getElementById('confirm-order-btn').addEventListener('click', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Xác nhận hoàn tất đơn hàng?',
            text: "Bạn sẽ không thể hoàn tác sau khi xác nhận!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Có',
            cancelButtonText: 'Không',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                this.disabled = true;
                this.innerHTML = '⏳ Đang xác nhận...';
                document.getElementById('confirm-order-form').submit();
            }
        });
    });
</script>

            @elseif ($order->is_confirmed)
                <p class="text-success"><strong>✅ Đã xác nhận hoàn tất lúc
                        {{ \Carbon\Carbon::parse($order->confirmed_at)->format('d/m/Y H:i') }}</strong></p>
            @endif

            @if ($order->order_status === 'pending')
                <form id="cancel-order-form" action="{{ route('user.orders.cancel', $order->id) }}" method="POST"
                    style="display:none;">
                    @csrf
                    @method('PUT')
                </form>

                <button id="cancel-order-btn" class="btn btn-danger mt-3">
                    ❌ Hủy đơn hàng
                </button>

                <!-- Thêm SweetAlert2 CDN nếu chưa có -->

                <script>
                    document.getElementById('cancel-order-btn').addEventListener('click', function(e) {
                        e.preventDefault(); // Ngăn submit form ngay

                        Swal.fire({
                            title: 'Bạn có chắc muốn hủy đơn hàng này không?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Có, hủy đơn',
                            cancelButtonText: 'Không, giữ lại',
                            reverseButtons: true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Nếu người dùng xác nhận, disable nút và submit form
                                this.disabled = true;
                                this.innerHTML = '⏳ Đang xử lý...';
                                document.getElementById('cancel-order-form').submit();
                            }
                        });
                    });
                </script>
            @endif
        </div>

        {{-- Sản phẩm trong đơn hàng --}}
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                🛍 Sản phẩm trong đơn hàng
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Thuộc tính</th>
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
                                        width="80" alt="Ảnh sản phẩm">
                                </td>
                                <td>{{ $item->product->name ?? 'N/A' }}</td>
                                <td>
                                    @if ($item->variant && $item->variant->attributeValues)
                                        @foreach ($item->variant->attributeValues as $value)
                                            <span class="badge bg-dark">{{ $value->attribute->name }}:
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

                {{-- Tổng tiền --}}
                <div class="d-flex justify-content-end mt-3">
                    <h5><strong>Tổng thanh toán: {{ number_format($order->total_amount) }}đ</strong></h5>
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/app.js')


    <script>
        let orderId = document.getElementById('order-status').getAttribute('data-order-id');
        console.log('Order ID:', orderId); // Kiểm tra giá trị của orderId

        document.addEventListener("DOMContentLoaded", function() {
            window.Echo.channel(`orders.${orderId}`)
                .listen('.OrderStatusUpdated', (e) => {
                    console.log('Trạng thái đơn hàng cập nhật:', e);
                    console.log('Giá trị is_confirmed:', e.is_confirmed);



                    const statusElement = document.getElementById('order-status');
                    if (statusElement && e.order_status) {
                        statusElement.innerText = e.order_status; // Cập nhật lại trạng thái hiển thị
                    }


                    // Đảm bảo rằng nút hủy đơn hàng vẫn hiển thị nếu đơn hàng có thể hủy
                    const cancelButton = document.getElementById('cancel-order-btn');
                    if (cancelButton) {
                        if (e.order_status === 'pending') {
                            cancelButton.disabled = false;
                            cancelButton.style.display = 'inline-block';
                        } else {
                            cancelButton.disabled = true;
                            cancelButton.style.display = 'none';
                        }
                    }
                    const confirmButton = document.getElementById('confirm-order-btn');
                    if (confirmButton) {
                        if (e.order_status === 'delivered' && (e.is_confirmed === false || e.is_confirmed ==
                                0 || e.is_confirmed === '0')) {
                            confirmButton.style.display = 'inline-block';
                        } else {
                            confirmButton.style.display = 'none';
                        }

                    }



                });
        });

        function convertStatusText($status) {
            switch ($status) {
                case 'pending':
                    return 'Chờ xử lý';
                case 'processing':
                    return 'Đang xử lý đơn hàng';
                case 'delivering':
                    return 'Đang giao hàng';
                case 'shipped':
                    return 'Đã giao hàng';
                case 'delivered':
                    return 'Hoàn tất';
                case 'cancelled':
                    return 'Đã hủy';
                case 'cancel_requested':
                    return 'Yêu cầu hủy';
                default:
                    return 'Không xác định';
            }
        }
    </script>




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
