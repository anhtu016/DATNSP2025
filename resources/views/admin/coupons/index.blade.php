@extends('admin.layout.default')
@section('content')
<div class="page-content">
    <div class="container">
        <h2 class="mb-4">Danh sách mã giảm giá</h2>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary mb-3">Tạo mã giảm giá mới</a>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Loại</th>
                    <th>Giá trị</th>
                    <th>Giá trị đơn hàng tối thiểu</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Sản phẩm được áp dụng</th>
                    <th>Lượt đã sử dụng</th>
                    <th>Giới hạn sử dụng</th>
                    <th>Trạng thái</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coupons as $coupon)
                    <tr>
                        <td>{{ $coupon->code }}</td>
                        <td>{{ $coupon->type }}</td>
                        <td>
                            @if($coupon->type == 'fixed')
                              Mã giảm {{ number_format($coupon->value) }}VND
                            @elseif($coupon->type == 'percentage')
                            Mã giảm {{ $coupon->value }}%
                            @endif
                        </td>
                        <td>
                            @if($coupon->min_order_value)
                                {{ number_format($coupon->min_order_value) }}VND
                            @else
                                <span class="text-muted">Không yêu cầu</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($coupon->start_date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y') }}</td>
                        <td>
                            @if($coupon->apply_to_all_products)
                                <span class="badge bg-success">Tất cả sản phẩm</span>
                            @elseif($coupon->products->isEmpty())
                                <span class="text-muted">Chưa có sản phẩm</span>
                            @else
                                @foreach($coupon->products as $product)
                                    <span class="badge bg-primary">{{ $product->name }}</span>
                                @endforeach
                            @endif
                        </td>
                        <td>{{ $coupon->usage_count }}</td>
                        <td>{{ $coupon->usage_limit}}
                        </td>
                        
                        <td>
                            @if (\Carbon\Carbon::parse($coupon->end_date)->isPast())
                                <span class="badge bg-danger">Hết hạn sử dụng</span>
                            @else
                                <span class="badge bg-success">Còn hạn sử dụng</span>
                            @endif
                        </td>
                        
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-warning">Sửa</a>
                                <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa mã giảm giá này?')">Xóa</button>
                                </form>
                              </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
