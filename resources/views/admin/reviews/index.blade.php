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

                                    <th class="" data-sort="date">STT</th>
                                    <th class="" data-sort="date">Mã sản phẩm</th>
                                    <th class="" data-sort="phone">Ảnh sản phẩm</th>
                                    <th class="" data-sort="date">Người dùng</th>
                                    <th class="" data-sort="date">Nội dung đánh giá</th>
                                    <th class="" data-sort="email">Xếp hạng</th>
                                    <th class="" data-sort="action">Thao tác</th>
                                </tr>
                            </thead>
                            @foreach ($listReviews as $ct)
                            <tbody class="list form-check-all">
                                <tr>                                    
                                    <td>{{ $loop->iteration }}</td>                                
                                    <td>{{ $ct->product->name ?? 'Không rõ' }}</td>

                                    <td> <img src="{{ asset('storage/' . $ct->image) }}" alt="Ảnh đánh giá" width="70px"></td>
                                    <td>{{$ct->user->name ?? 'không rõ'}}</td>   
                                    <td>{{$ct->description}}</td>
                                    <td>{{$ct->rating}} sao </td>
                                    <td>
                                        <div class="d-flex gap-2">                                       
                                            <div class="remove">
                                                <a href="{{route('admin.reviews.presently', $ct->id)}}">
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
                        <div class="d-flex justify-content-end mt-3">
                            {{ $listReviews->links('pagination::bootstrap-5') }}
                        </div>
                       
                    </div>

                    
                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end col -->
</div>
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
