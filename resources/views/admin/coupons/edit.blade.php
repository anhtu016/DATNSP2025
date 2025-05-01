@extends('admin.layout.default')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <h1 class="mb-4 text-center">Sửa mã giảm</h1>
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Đã xảy ra lỗi!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
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
        <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST" class="form-container">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="code">Mã giảm giá</label>
                <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $coupon->code) }}">
            </div>
        
            <div class="form-group">
                <label for="type">Loại</label>
                <select name="type" id="type" class="form-control">
                    <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>Giảm giá cố định</option>
                    <option value="percentage" {{ $coupon->type == 'percentage' ? 'selected' : '' }}>Giảm giá theo phần trăm</option>
                </select>
            </div>
        
            <div class="form-group">
                <label for="value">Giá trị</label>
                <input type="hidden" name="value" id="value" value="{{ old('value', $coupon->value) }}">
                <input type="text" id="value_display" class="form-control format-currency" value="{{ number_format(old('value', $coupon->value), 0, ',', '.') }}">
            </div>
            
            <div class="form-group">
                <label for="min_order_value">Giá trị đơn hàng tối thiểu</label>
                <input type="hidden" name="min_order_value" id="min_order_value" value="{{ old('min_order_value', $coupon->min_order_value) }}">
                <input type="text" id="min_order_value_display" class="form-control format-currency" value="{{ number_format(old('min_order_value', $coupon->min_order_value), 0, ',', '.') }}">
            </div>
            
        
            <div class="form-group">
                <label for="start_date">Ngày bắt đầu:</label>
                <input type="date" name="start_date" id="start_date" class="form-control">
            </div>
            <div class="form-group">
                <label for="end_date">Ngày kết thúc:</label>
                <input type="date" name="end_date" id="end_date" class="form-control">
            </div>
        
            <div class="form-group">
                <label for="product_ids">Chọn sản phẩm áp dụng:</label>
                <select name="product_ids[]" id="product_ids" class="form-control" multiple>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ in_array($product->id, old('product_ids', $coupon->products->pluck('id')->toArray())) ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <br>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="apply_to_all_products" value="1" {{ old('apply_to_all_products', $coupon->apply_to_all_products ?? false) ? 'checked' : '' }}>
                    Áp dụng cho tất cả sản phẩm
                </label>
            </div>
            <div class="form-group">
                <label for="usage_limit">Giới hạn số lần sử dụng</label>
                <input type="number" name="usage_limit" id="usage_limit" class="form-control" value="{{ old('usage_limit', $coupon->usage_limit) }}" min="0">
            </div>
            
        <br>
        
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
        
    </div>
    <script>
        function formatNumber(n) {
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    
        function parseNumber(n) {
            return n.replace(/\./g, "");
        }
    
        document.querySelectorAll('.format-currency').forEach(function(input) {
            input.addEventListener('input', function () {
                const rawValue = parseNumber(this.value);
                this.value = formatNumber(rawValue);
    
                const target = this.id.replace('_display', '');
                document.getElementById(target).value = parseFloat(rawValue) || 0;
            });
        });
    </script>
    
<style>

    .form-container {
    min-height: 110vh;
}
</style>

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
