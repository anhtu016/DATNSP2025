@extends('client.layout.default')
@section('content')
<br>
<br>
<div class="container">
    <h2 class="mb-4">Sản phẩm trong danh mục: {{ $category->name }}</h2>
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 d-flex flex-column justify-content-between">
                    <!-- Ảnh sản phẩm căn giữa -->
                    <div class="text-center p-3">
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" class="card-img-top img-fluid" style="max-height: 200px; width: auto; margin: 0 auto;" alt="{{ $product->name }}">
                    </div>

                    <!-- Nội dung sản phẩm -->
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-center">{{ $product->name }}</h5>
                        <p class="text-center">Giá: {{ number_format($product->price) }} đ</p>

                        <!-- Nút chi tiết căn giữa và nằm ở cuối -->
                        <div class="mt-auto text-center">
                            <a href="{{ route('detail.index', ['id' => $product->id]) }}" class="btn btn-primary btn-sm">Chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Phân trang -->
    <div class="d-flex justify-content-center">
        {{ $products->links() }}
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
@endsection
