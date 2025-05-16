@extends('admin.layout.default')
@section('content')
    <div class="page-content">
        <div class="">
            <h1>Danh sách sản phẩm</h1>

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

            <table class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Ảnh sản phẩm</th>
                        <th>Ảnh phụ</th>
                        <th>Giá sản phẩm</th>
                        <th>Màu sắc</th>
                        <th>Kích cỡ</th>
                        <th>Danh mục</th>
                        {{-- <th>Tổng số lượng sản phẩm</th> --}}
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody> <!-- ✅ chỉ mở 1 lần thôi -->
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="Product Image" width="70px">
                            </td>
                            <td>
                                @foreach ($product->images as $img)
                                    <img src="{{ asset('storage/' . $img->image) }}" width="70px" height="70px">
                                @endforeach
                            </td>
                            <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
                            <td>
                                @foreach ($product->variants as $variant)
                                    @php
                                        $colors = $variant->attributeValues
                                            ->filter(fn($v) => $v->attribute->type == 'color')
                                            ->pluck('value')
                                            ->unique() // Dùng unique để tránh trùng lặp
                                            ->join(', ');
                                    @endphp
                                    <div>{{ $colors }}</div>
                                @endforeach
                            </td>

                            <td>
                                @foreach ($product->variants as $variant)
                                    @php
                                        $sizes = $variant->attributeValues
                                            ->filter(fn($v) => $v->attribute->type == 'size')
                                            ->pluck('value')
                                            ->unique() // Dùng unique để tránh trùng lặp
                                            ->join(', ');
                                    @endphp
                                    <div>{{ $sizes }}</div>
                                @endforeach
                            </td>

                            <td>
                                @foreach ($product->categories as $cat)
                                    <span class="badge bg-info">{{ $cat->name }}</span>
                                @endforeach
                            </td>
                            {{-- <td>{{$product->quantity}}</td> --}}
                            <td>
                                <div class="btn btn-gruop">
                                    <a href="{{ route('Variants', $product->id) }}" class="btn btn-sm btn-success">Biến
                                        thể</a>

                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm  btn-danger">xóa</button>
                                    </form>

                                    <a href="{{ route('products.edit', $product->id) }}"
                                        class="btn btn-sm  btn-warning">Sửa</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


            <div class="d-flex justify-content-center mt-3">
                {{ $products->links() }}
            </div>

            <a href="{{ route('products.create') }}" class="btn btn-primary mt-3">Thêm sản phẩm mới</a>
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
