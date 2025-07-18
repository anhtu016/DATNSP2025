@extends('admin.layout.default')
@section('content')
    <div class="page-content">
        <div class="container">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" class="row g-2 mb-4">
                <div class="col-md-3">
                    <label for="customer_name" class="form-label">Tên khách hàng</label>
                    <input type="text" name="customer_name" class="form-control" value="{{ request('customer_name') }}">
                </div>
                <div class="col-md-3">
                    <label for="order_status" class="form-label">Trạng thái đơn hàng</label>
                    <select name="order_status" class="form-select">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="pending" {{ request('order_status') == 'pending' ? 'selected' : '' }}>Chờ xử lý
                        </option>
                        <option value="processing" {{ request('order_status') == 'processing' ? 'selected' : '' }}>Đang xử
                            lý đơn hàng
                        </option>
                        <option value="delivering" {{ request('order_status') == 'delivering' ? 'selected' : '' }}>Đang giao
                            hàng
                        </option>
                        <option value="shipped" {{ request('order_status') == 'shipped' ? 'selected' : '' }}>Đã giao hàng
                        </option>
                        <option value="delivered" {{ request('order_status') == 'delivered' ? 'selected' : '' }}>Hoàn thành
                        </option>
                        <option value="cancel_requested"
                            {{ request('order_status') == 'cancel_requested' ? 'selected' : '' }}>Yêu
                            cầu hủy</option>
                        <option value="cancelled" {{ request('order_status') == 'cancelled' ? 'selected' : '' }}>Đã hủy
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Từ ngày</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Đến ngày</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3 mt-2">
                    <button type="submit" class="btn btn-primary">Lọc</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary flex-fill">Đặt lại</a>
                </div>
            </form>


            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">📦 Danh sách đơn hàng</h2>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered">
                    <thead class="table-light text-center">
                        <tr>
                            <th>STT</th>
                            <th>Khách hàng</th>
                            <th>Số điện thoại</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái</th>
                            <th>Tổng tiền</th>
                            <th>Chi tiết</th>
                            <th>Hành động</th> <!-- Thêm -->
                            <th>Yêu cầu xác nhận</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->customer->name ?? 'N/A' }}</td>
                                <td>{{ $order->phone_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="">
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
                                </td>
                                <td>{{ number_format($order->total_amount) }}đ</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                        Xem
                                    </a>
                                </td>
                                <td>
                                    @if ($order->order_status === 'cancelled')
                                        <form id="delete-order-form-{{ $order->id }}"
                                            action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                            style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                        <button type="button" class="btn btn-sm btn-danger"
                                            id="delete-order-btn-{{ $order->id }}">
                                            Xoá
                                        </button>

                                        <script>
                                            document.getElementById('delete-order-btn-{{ $order->id }}').addEventListener('click', function(e) {
                                                e.preventDefault();

                                                Swal.fire({
                                                    title: 'Bạn có chắc chắn muốn xoá đơn hàng này không?',
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'Có, xoá ngay',
                                                    cancelButtonText: 'Không',
                                                    reverseButtons: true,
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        this.disabled = true;
                                                        this.innerText = '⏳ Đang xoá...';
                                                        document.getElementById('delete-order-form-{{ $order->id }}').submit();
                                                    }
                                                });
                                            });
                                        </script>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($order->order_status == 'cancel_requested')
                                        <form action="{{ route('admin.orders.confirmCancel', $order->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">✅ Xác nhận hủy</button>
                                        </form>

                                        <form action="{{ route('admin.orders.rejectCancel', $order->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-secondary">❌ Từ chối</button>
                                        </form>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>


                            </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="text-muted">Không có đơn hàng nào.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-end mt-3">
                    {{ $orders->links('pagination::bootstrap-5') }}
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
