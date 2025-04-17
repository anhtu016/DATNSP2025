@extends('admin.layout.default')
@section('content')
    <h1>abc</h1>
    <h3>abc</h3>
    <form action="{{route('store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="">
            <div class="card">
              <div class="card-header">
                <h4>Thêm mới danh mục</h4>
              </div>
              <div class="card-body">
              <div class="form-group">
                <label>ID Danh mục</label>
                  <input type="text" name="id" class="form-control" disabled >    
              </div>
            </div>  
                             
              <div class="card-body">
                <div class="form-group">
                  <label>Tên danh mục</label>
                  <input type="text" name="name" class="form-control">
                </div>

              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>SLUG</label>
                  <input type="text" name="slug" class="form-control">
                </div>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>Mô tả</label>
                  <input type="text" name="description" class="form-control">
                </div>
              </div>
            </div>
            <div class="text-center">
                <input name="submit" class="btn btn-success" type="submit" value="Thêm mới">
                <input class="btn btn-danger" type="reset" value="Xóa">
                <a class="btn btn-info" href="">Quay lại</a>
            </div>

            
            
            
          </div>
    </form>

@endsection

@push('admin_css')
<!-- App favicon -->
<link rel="shortcut icon" href="assets/images/favicon.ico">

<!-- Plugins css -->
<link href="admin/assets/libs/dropzone/dropzone.css" rel="stylesheet" type="text/css" />

<!-- Layout config Js -->
<script src="admin/assets/js/layout.js"></script>
<!-- Bootstrap Css -->
<link href="admin/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="admin/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="admin/assets/css/app.min.css" rel="stylesheet" type="text/css" />
<!-- custom Css-->
<link href="admin/assets/css/custom.min.css" rel="stylesheet" type="text/css" />

@endpush
<!--end css-->

<!-- js-->
@push('admin_js')
   <!-- JAVASCRIPT -->
   <script src="admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="admin/assets/libs/simplebar/simplebar.min.js"></script>
   <script src="admin/assets/libs/node-waves/waves.min.js"></script>
   <script src="admin/assets/libs/feather-icons/feather.min.js"></script>
   <script src="admin/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
   <script src="admin/assets/js/plugins.js"></script>

   <!-- ckeditor -->
   <script src="admin/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>

   <!-- dropzone js -->
   <script src="admin/assets/libs/dropzone/dropzone-min.js"></script>

   <script src="admin/assets/js/pages/ecommerce-product-create.init.js"></script>

   <!-- App js -->
   <script src="admin/assets/js/app.js"></script>
@endpush
<!--end js-->