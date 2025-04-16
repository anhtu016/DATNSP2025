@extends('admin.layout.default')
@section('content')
    <div class="page-content">
        <div class="container">
            <h1>Create Product</h1>

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label for="name">Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
            
                <div class="mb-3">
                    <label for="sku">Mã SKU</label>
                    <input type="text" name="sku" class="form-control" required>
                </div>
            
                <div class="mb-3">
                    <label for="price">Giá bán</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
            
                <div class="mb-3">
                    <label for="sell_price">Giá sale</label>
                    <input type="number" name="sell_price" class="form-control" value="0">
                </div>
            
                <div class="mb-3">
                    <label for="short_description">Mô tả ngắn</label>
                    <textarea name="short_description" class="form-control"></textarea>
                </div>
            
                <div class="mb-3">
                    <label for="description">Mô tả chi tiết</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
            
                <div class="mb-3">
                    <label for="quantity">Số lượng</label>
                    <input type="number" name="quantity" class="form-control" value="0">
                </div>
            
                <div class="mb-3">
                    <label for="brand_id">Thương hiệu</label>
                    <select name="brand_id" class="form-select" required>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
            
                <div class="mb-3">
                    <label for="thumbnail">Hình đại diện</label>
                    <input type="file" name="thumbnail" class="form-control">
                </div>
            
                <button type="submit" class="btn btn-primary">Tạo sản phẩm</button>
            </form>
            
        </div>

     

        <!-- container-fluid -->
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
