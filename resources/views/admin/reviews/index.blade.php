@extends('admin.layout.default')
@section('content')
<h1>abc</h1>
    <h3>abc</h3>
<div class="row p-5">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">               
            </div><!-- end card header -->
            <div class="card-body">
                <div class="listjs-table" id="customerList">
                    <div class="row g-4 mb-3">
                        
                        <div class="col-sm">
                            <div class="d-flex justify-content-sm-end">
                                <div class="search-box ms-2">
                                    <input type="text" class="form-control search" placeholder="Search...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive table-card mt-3 mb-1">
                        <table class="table align-middle table-nowrap" id="customerTable">
                            <thead class="table-light">
                                <tr>                                   
                                    <th class="sort" data-sort="date">Mã sản phẩm</th>
                                    <th class="sort" data-sort="date">Product</th>
                                    <th class="sort" data-sort="date">User</th>
                                    <th class="sort" data-sort="date">Description</th>
                                    <th class="sort" data-sort="email">Rating</th>
                                    <th class="sort" data-sort="phone">Image</th>
                                    <th class="sort" data-sort="date">Video</th> 
                                    <th class="sort" data-sort="action">Action</th>
                                </tr>
                            </thead>
                            @foreach ($listReviews as $ct)
                            <tbody class="list form-check-all">
                                <tr>                                    
                                    <td>{{$ct->id}}</td>
                                    <td>{{$ct->user_id}}</td>                                   
                                    <td>{{$ct->product_id}}</td>
                                    <td>{{$ct->description}}</td>
                                    <td>{{$ct->rating}}</td>
                                    <td>{{$ct->image}}</td>
                                    <td>{{$ct->video}}</td>
                                    <td>
                                        <div class="d-flex gap-2">                                       
                                            <div class="remove">
                                                <a href="{{route('reviews.presently', $ct->id)}}">
                                                @if ($ct->status == 0) 
                                                    <button class="btn btn-sm btn-success remove-item-btn" data-bs-toggle="modal" data-bs-target="#deleteRecordModal" >Hiện</button>
                                                    @else
                                                    <button class="btn btn-sm btn-danger remove-item-btn" data-bs-toggle="modal" data-bs-target="#deleteRecordModal" >Ẩn</button>
                                                    @endif
                                                </a>
                                            </div>                                          
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                        {{-- {!! $listReviews -> links() !!} --}}
                       
                    </div>

                    
                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end col -->
</div>
    


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