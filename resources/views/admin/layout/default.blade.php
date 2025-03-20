<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Widgets | Velzon - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
</head>
    @include('admin.layout.partials.css')
<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

<header id="page-topbar">
   {{-- navbar header --}}
    @include('admin.layout.navbar')
   {{-- end navbar header --}}
</header>

        <!-- ========== App Menu ========== -->
       

        {{-- siderbar --}}
        @include('admin.layout.sidebar')
        {{-- end siderbar --}}


        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->


        <!--  Page-content -->
        <div class="main-content">
            @yield('content')
            @include('admin.layout.footer')
        </div>
        <!-- end main content-->



    </div>
    <!-- END layout-wrapper -->

    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->


    <!-- Theme Settings -->
  @include('admin.layout.theme-setting')
    <!-- End Theme Settings -->


    <!--js-->
    @include('admin.layout.partials.js')
    <!--end js-->

</body>

</html>