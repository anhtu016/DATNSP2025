@extends('client.layout.default')
@section('content')
<div class="container">
    <h2>Sản phẩm trong danh mục: {{ $category->name }}</h2>
    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p>Giá: {{ number_format($product->price) }} đ</p>
                        <a href="{{route('detail.index',['id' => $product->id])}}" class="btn btn-primary btn-sm">Chi tiết</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $products->links() }}
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
