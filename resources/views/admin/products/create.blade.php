@extends('admin.layout.default')
@section('content')
<div class="page-content">
    <div class="container">
        <h1>Create Product</h1>

        {{-- Thông báo lỗi chung --}}
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

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Tên sản phẩm --}}
            <div class="mb-3">
                <label for="name">Tên sản phẩm</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"  value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            

            {{-- SKU --}}
            <div class="mb-3">
                <label for="sku">Mã SKU</label>
                <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror"  value="{{ old('sku') }}">
                @error('sku')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Giá bán --}}
            <div class="mb-3">
                <label for="price">Giá sale</label>
                <input type="text" class="form-control format-currency @error('price') is-invalid @enderror" id="price_display" autocomplete="off" value="{{ old('price', 0) }}">
                <input type="hidden" name="price" id="price" value="{{ old('price') }}">
                @error('price')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- Giá sale --}}
            <div class="mb-3">
                <label for="sell_price">Giá gốc</label>
                <input type="text" class="form-control format-currency @error('sell_price') is-invalid @enderror" id="sell_price_display" autocomplete="off" value="{{ old('sell_price', 0) }}">
                <input type="hidden" name="sell_price" id="sell_price" value="{{ old('sell_price') }}">
                @error('sell_price')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- Mô tả ngắn --}}
            <div class="mb-3">
                <label for="short_description">Mô tả ngắn</label>
                <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror">{{ old('short_description') }}</textarea>
                @error('short_description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Mô tả chi tiết --}}
            <div class="mb-3">
                <label for="description">Mô tả chi tiết</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Thương hiệu --}}
            <div class="mb-3">
                <label for="brand_id">Thương hiệu</label>
                <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror" required>
                    <option value="">-- Chọn thương hiệu --</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                @error('brand_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Danh mục --}}
            <div class="mb-3">
                <div class="col-md-12 mt-3">
                    <label><strong>Danh mục</strong></label>
                </div>
                @foreach ($categories as $category)
                    <div class="col-md-4 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}"
                                   id="category-{{ $category->id }}"
                                   {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}>
                            <label class="form-check-label" for="category-{{ $category->id }}">
                                {{ $category->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
                @error('categories')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- Hình đại diện --}}
            <div class="mb-3">
                <label for="thumbnail">Hình đại diện</label>
                <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror">
                @error('thumbnail')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Tạo sản phẩm</button>
        </form>
    </div>
</div>

<script>
    function formatNumber(n) {
        return n.replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function parseNumber(n) {
        return n.replace(/\./g, "");
    }

    document.querySelectorAll('.format-currency').forEach(function(input) {
        input.addEventListener('input', function(e) {
            const rawValue = parseNumber(this.value);
            this.value = formatNumber(rawValue);

            const target = this.id.replace('_display', '');
            document.getElementById(target).value = parseFloat(rawValue) || 0;
        });
    });
</script>

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
