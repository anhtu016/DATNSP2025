@extends('admin.layout.default')
@section('content')
<div class="page-content">
    <div class="container-fluid p-8">
        <h1 class="mb-4 text-center">Tạo mã giảm giá mới</h1>
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
        <form action="{{ route('admin.coupons.store') }}" method="POST" class="form-container">
            @csrf
            <div class="form-group">
                <label for="code">Mã giảm giá:</label>
                <input type="text" name="code" id="code" class="form-control">
                @error('code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>
            <div class="form-group">
                <label for="type">Loại:</label>
                <select name="type" id="type" class="form-control">
                    <option value="percentage">Giảm theo phần trăm</option>
                    <option value="fixed">Giảm giá Cố định</option>
                </select>
                @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>
            <div class="form-group">
                <label for="value">Giá trị:</label>
                <input type="number" name="value" id="value" class="form-control">
                @error('value')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>
            <div class="form-group">
                <label for="min_order_value">Giá trị đơn hàng tối thiểu:</label>
                <input type="number" name="min_order_value" id="min_order_value" class="form-control">
                @error('min_order_value')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>
            <div class="form-group">
                <label for="start_date">Ngày bắt đầu:</label>
                <input type="date" name="start_date" id="start_date" class="form-control">
                @error('start_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>
            <div class="form-group">
                <label for="end_date">Ngày kết thúc:</label>
                <input type="date" name="end_date" id="end_date" class="form-control">
                @error('end_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>
            <div class="form-group">
                <label for="product_ids">Chọn sản phẩm áp dụng:</label>
                <select name="product_ids[]" id="product_ids" class="form-select" multiple>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                @error('product_ids')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>
            <div class="form-group">
                <label for="usage_limit">Giới hạn lượt sử dụng:</label>
                <input type="number" name="usage_limit" id="usage_limit" class="form-control" value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}">
                @error('usage_limit')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            </div>
            
            <br>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="apply_to_all_products" value="1" {{ old('apply_to_all_products', $coupon->apply_to_all_products ?? false) ? 'checked' : '' }}>
                    Áp dụng cho tất cả sản phẩm
                </label>
            </div>
            
            <hr>
            <button type="submit" class="btn btn-primary btn-block">Tạo mã giảm giá</button>
        </form>
       
    </div>
</div>


<style>
    .form-container {
    min-height: 110vh; /* Chiếm 80% chiều cao của viewport */
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
