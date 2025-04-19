@extends('client.layout.default')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="cart-table-container">
        <h2 class="mb-4">📋 Lịch sử đơn hàng của bạn</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th>Tổng tiền</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge 
                            @if($order->order_status == 'pending') bg-warning
                            @elseif($order->order_status == 'shipped') bg-info
                            @elseif($order->order_status == 'delivered') bg-success
                            @elseif($order->order_status == 'cancelled') bg-danger
                            @elseif($order->order_status == 'cancel_requested') bg-dark
                            @endif">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </td>
                    <td>{{ number_format($order->total_amount) }}đ</td>
                    <td>
                        <a href="{{ route('user.orders.show', $order->id) }}" class="btn btn-sm btn-primary">Xem</a>
                        @if ($order->order_status == 'delivered')
                       <a href="{{route('orders.review', $order->id)}}" class="btn btn-sm btn-success">
                            Đánh giá
                        </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">Bạn chưa có đơn hàng nào.</td>
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

    @push('scripts')
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        
    @endpush
    <!--end js-->
@endsection
