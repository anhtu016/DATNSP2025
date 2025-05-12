@extends('admin.layout.default')
@section('content')
    <h1>abc</h1>
    <h3>abc</h3>
    <form action="{{route('categories.update', $editCategory->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="">
            <div class="card">
              <div class="card-header">
                <h4>Chỉnh sửa danh mục</h4>
              </div>
                                     
              <div class="card-body">
                <div class="form-group">
                  <label>Tên danh mục</label>
                  <input type="text" name="name" class="form-control" value="{{$editCategory->name}}">
                </div>

              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>SLUG</label>
                  <input type="text" name="slug" class="form-control" value="{{$editCategory->slug}}">
                </div>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>Mô tả</label>
                  <input type="text" name="description" class="form-control" value="{{$editCategory->description}}">
                </div>
              </div>
            </div>
            <div class="text-center">
                <input name="submit" class="btn btn-success" type="submit" value="Sửa">
                <input class="btn btn-danger" type="reset" value="Xóa">
                <a class="btn btn-info" href="">Quay lại</a>
            </div>
        
          </div>
    </form>
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

