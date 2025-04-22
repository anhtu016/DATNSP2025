@extends('admin.layout.default')
@section('content')
<div class="page-content">
    <div class="container mt-4">
        <div class="container">
            <h1>Chỉnh sửa sản phẩm</h1>
        
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
        
                <div class="form-group">
                    <label>Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}">
                </div>
        
                <div class="form-group">
                    <label>SKU</label>
                    <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
                </div>
        
                <div class="form-group">
                    <label>Giá</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}">
                </div>
        
                <div class="form-group">
                    <label>Giá sale</label>
                    <input type="number" name="sell_price" class="form-control" value="{{ old('sell_price', $product->sell_price) }}">
                </div>
        
                <div class="form-group">
                    <label>Số lượng</label>
                    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $product->quantity) }}">
                </div>
        
                <div class="form-group">
                    <label>Mô tả ngắn</label>
                    <textarea name="short_description" class="form-control">{{ old('short_description', $product->short_description) }}</textarea>
                </div>
        
                <div class="form-group">
                    <label>Mô tả chi tiết</label>
                    <textarea name="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
                </div>
        
                <div class="form-group">
                    <label>Thương hiệu</label>
                    <select name="brand_id" class="form-control">
                        @foreach (\App\Models\Brand::all() as $brand)
                            <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
        
                <div class="form-group">
                    <label>Ảnh hiện tại</label><br>
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" width="100">
                </div>
        
                <div class="form-group">
                    <label>Ảnh mới (nếu muốn thay)</label>
                    <input type="file" name="thumbnail" class="form-control">
                </div>

                <!-- Chọn danh mục -->
                <div class="form-group mt-3">
                    <label><strong>Chọn danh mục</strong></label>
                    <div class="row">
                        @foreach ($categories as $category)
                            <div class="col-md-4 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="category-{{ $category->id }}" 
                                           {{ $product->categories->contains($category->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category-{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
        
                <hr>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
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
