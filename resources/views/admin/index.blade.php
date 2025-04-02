@extends('admin.layout.default')
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
                @include('admin.layout.title-box')
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <h5 class="text-decoration-underline mb-3 pb-1">Tile Boxs</h5>
                </div>
            </div>
            <!-- end row-->

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <!-- card -->
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-uppercase fw-medium text-muted mb-0">Total Earnings</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <h5 class="text-success fs-14 mb-0">
                                        <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +16.24 %
                                    </h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">$<span class="counter-value" data-target="559.25">0</span>k</h4>
                                    <a href="" class="text-decoration-underline">View net earnings</a>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-success-subtle rounded fs-3">
                                        <i class="bx bx-dollar-circle text-success"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <!-- card -->
                    <div class="card card-animate bg-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-uppercase fw-medium text-white-50 mb-0">Orders</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <h5 class="text-warning fs-14 mb-0">
                                        <i class="ri-arrow-right-down-line fs-13 align-middle"></i> -3.57 %
                                    </h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4 text-white"><span class="counter-value" data-target="36894">0</span></h4>
                                    <a href="" class="text-decoration-underline text-white-50">View all orders</a>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-white bg-opacity-25 rounded fs-3">
                                        <i class="bx bx-shopping-bag text-white"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <!-- card -->
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-uppercase fw-medium text-muted mb-0">Customers</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <h5 class="text-success fs-14 mb-0">
                                        <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +29.08 %
                                    </h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="183.35">0</span>M</h4>
                                    <a href="" class="text-decoration-underline">See details</a>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-warning-subtle rounded fs-3">
                                        <i class="bx bx-user-circle text-warning"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <!-- card -->
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-uppercase fw-medium text-muted mb-0">My Balance</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <h5 class="text-muted fs-14 mb-0">
                                        +0.00 %
                                    </h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">$<span class="counter-value" data-target="165.89">0</span>k</h4>
                                    <a href="" class="text-decoration-underline">Withdraw money</a>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-primary-subtle rounded fs-3">
                                        <i class="bx bx-wallet text-primary"></i>
                                    </span>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div> <!-- end row-->

        
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Users</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="28.05">0</span>k</h2>
                                    <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0"><i class="ri-arrow-up-line align-middle"></i> 16.24 % </span> vs. previous month</p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                            <i data-feather="users" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-xl-3 col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Sessions</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="97.66">0</span>k</h2>
                                    <p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0"><i class="ri-arrow-down-line align-middle"></i> 3.96 % </span> vs. previous month</p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                            <i data-feather="activity" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-xl-3 col-md-6">
                    <div class="card card-animate bg-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-white-50 mb-0">Avg. Visit Duration</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold text-white"><span class="counter-value" data-target="3">0</span>m <span class="counter-value" data-target="40">0</span>sec</h2>
                                    <p class="mb-0 text-white-50"><span class="badge bg-white bg-opacity-25 text-white mb-0"><i class="ri-arrow-down-line align-middle"></i> 0.24 % </span> vs. previous month</p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-white bg-opacity-25 rounded-circle fs-2">
                                            <i data-feather="clock" class="text-white"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-xl-3 col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Bounce Rate</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="33.48">0</span>%</h2>
                                    <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0"><i class="ri-arrow-up-line align-middle"></i> 7.05 % </span> vs. previous month</p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                            <i data-feather="external-link" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div> <!-- end row-->

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success card-height-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-white bg-opacity-25 text-white rounded-2 fs-2">
                                        <i class="bx bx-shopping-bag"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-medium text-white-50 mb-3">Total Sales</p>
                                    <h4 class="fs-4 mb-3 text-white"><span class="counter-value" data-target="2045">0</span></h4>
                                    <p class="text-white-50 mb-0">From 1930 last year</p>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <span class="badge bg-white bg-opacity-25 text-white fs-12"><i class="ri-arrow-up-s-line fs-13 align-middle me-1"></i>6.11 %<span></span></span>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div> <!-- end col-->

                <div class="col-xl-3 col-md-6">
                    <div class="card card-height-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-warning-subtle text-warning rounded-2 fs-2">
                                        <i class="bx bxs-user-account"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-medium text-muted mb-3">Number of Users</p>
                                    <h4 class="fs-4 mb-3"><span class="counter-value" data-target="7522">0</span></h4>
                                    <p class="text-muted mb-0">From 9530 last year</p>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <span class="badge bg-danger-subtle text-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>10.35 %</span>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div> <!-- end col-->

                <div class="col-xl-3 col-md-6">
                    <div class="card card-height-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-danger-subtle text-danger rounded-2 fs-2">
                                        <i class="bx bxs-badge-dollar"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-medium text-muted mb-3">Total Revenue</p>
                                    <h4 class="fs-4 mb-3">$<span class="counter-value" data-target="2845.05">0</span></h4>
                                    <p class="text-muted mb-0">From $1,750.04 last year</p>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <span class="badge bg-success-subtle text-success fs-12"><i class="ri-arrow-up-s-line fs-13 align-middle me-1"></i>22.96 %<span></span></span>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div> <!-- end col-->

                <div class="col-xl-3 col-md-6">
                    <div class="card card-height-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-info-subtle text-info rounded-2 fs-2">
                                        <i class="bx bx-store-alt"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-medium text-muted mb-3">Number of Stores</p>
                                    <h4 class="fs-4 mb-3"><span class="counter-value" data-target="405">0</span>k</h4>
                                    <p class="text-muted mb-0">From 308 last year</p>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <span class="badge bg-success-subtle text-success fs-12"><i class="ri-arrow-up-s-line fs-13 align-middle me-1"></i>16.31 %</span>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div> <!-- end col-->
            </div> <!-- end row-->
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

      <!-- css-->
      @push('admin_css')
         <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('admin/assets/images/favicon.ico')}}">

        <!-- jsvectormap css -->
        <link href="{{asset('admin/assets/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

        <!--Swiper slider css-->
        <link href="{{asset('admin/assets/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css" />

        <!-- Layout config Js -->
        <script src="{{asset('admin/assets/js/layout.js')}}"></script>
        <!-- Bootstrap Css -->
        <link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('admin/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('admin/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="{{asset('admin/assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />

      @endpush
      <!--end css-->
  
      <!-- js-->
      @push('admin_js')
         <!-- JAVASCRIPT -->
        <script src="{{asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('admin/assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{asset('admin/assets/libs/node-waves/waves.min.js')}}"></script>
        <script src="{{asset('admin/assets/libs/feather-icons/feather.min.js')}}"></script>
        <script src="{{asset('admin/assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
        <script src="{{asset('admin/assets/js/plugins.js')}}"></script>

        <!-- apexcharts -->
        <script src="{{asset('admin/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

        <!-- Vector map-->
        <script src="{{asset('admin/assets/libs/jsvectormap/js/jsvectormap.min.js')}}"></script>
        <script src="{{asset('admin/assets/libs/jsvectormap/maps/world-merc.js')}}"></script>

        <!--Swiper slider js-->
        <script src="{{asset('admin/assets/libs/swiper/swiper-bundle.min.js')}}"></script>

        <!-- Dashboard init -->
        <script src="{{asset('admin/assets/js/pages/dashboard-ecommerce.init.js')}}"></script>

        <!-- App js -->
        <script src="{{asset('admin/assets/js/app.js')}}"></script>
      @endpush
      <!--end js-->
@endsection