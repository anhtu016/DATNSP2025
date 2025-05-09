@extends('admin.layout.default')
@section('content')
<div style="min-height: 200vh">
    <div class="page-content">
        <div class="container mt-4">
            <h4>Tạo Biến Thể cho: {{ $product->name }}</h4>

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

            <!-- Hiển thị các biến thể đã tạo -->
            <h5>Danh sách Biến Thể Hiện Tại:</h5>
            @if($product->variants->count() > 0)
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>STT</th>
                 
                            @foreach ($attributes as $attribute)
                                <th>{{ ucfirst($attribute->name) }}</th>
                            @endforeach
                            <th>Số Lượng</th>
                            <th>ảnh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->variants as $variant)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                              
                                @foreach ($variant->attributeValues as $attributeValue)
                                    <td>{{ $attributeValue->value }}</td>
                                @endforeach
                                <td>{{ $variant->quantity_variant }}</td>
                                <td><img src="{{ asset('storage/' . $variant->image_variant) }}" alt="Ảnh biến thể" height="50px"/>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Chưa có biến thể nào.</p>
            @endif

            <!-- Form tạo biến thể mới -->
            <form action="{{ route('products.variants.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mt-4">
                    @foreach ($attributes as $attribute)
                        <div class="col-md-4 mb-3">
                            <label for="attribute_{{ $attribute->id }}" class="form-label">
                                <strong>{{ ucfirst($attribute->name) }}</strong>
                            </label>
                            <select id="attribute_{{ $attribute->id }}" name="attributes[{{ $attribute->id }}]"
                                class="form-select" required>
                                <option value="">-- Chọn {{ strtolower($attribute->name) }} --</option>
                                @foreach ($attribute->attributeValue as $value)
                                    <option value="{{ $value->id }}">{{ $value->value }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
                <div class="row mt-4">

                    <div class="col-md-4 mb-3">
                        <label for="quantity_variant" class="form-label"><strong>Số lượng</strong></label>
                        <input type="number" id="quantity_variant" name="quantity_variant" class="form-control" min="0" required>
                    </div>                   
                     <div class="col-md-4 mb-3">
                        <label for="image_variant" class="form-label"><strong>ảnh</strong></label>
                        <input type="file" id="image_variant" name="image_variant" class="form-control" accept="image/*" required>
                    </div>
                </div>


                <button type="submit" class="btn btn-primary mt-2">Tạo Biến Thể</button>
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
            <link href="{{ asset('admin/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet"
                type="text/css" />

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
