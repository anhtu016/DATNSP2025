@extends('admin.layout.default')
@section('content')
<div class="page-content container mt-4">
    <h1 class="mb-4">📊 Thống kê Doanh thu</h1>

    <div class="card shadow-sm mb-4 p-3">
        <h5 class="mb-3">🔍 Bộ lọc Doanh thu</h5>
        <form method="GET" action="{{ route('turnover.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="year" class="form-label">Năm</label>
                <select id="year" name="year" class="form-select">
                    <option value="">Tất cả</option>
                    @for ($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <label for="month" class="form-label">Tháng</label>
                <select id="month" name="month" class="form-select">
                    <option value="">Tất cả</option>
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>Tháng {{ $m }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Lọc</button>
            </div>
        </form>
    </div>
    
    <div class="card shadow-sm mb-4">
        <div class="card-body">
          <h3 class="card-title"><i class="bi bi-currency-dollar">Tổng doanh thu</i></h3>
          <p class="lead">{{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</p>
        </div>
      </div>
      

      <div class="mb-4">
        <h3>Doanh thu theo tháng và năm</h3>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Tháng</th>
                    <th>Năm</th>
                    <th>Doanh thu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthlyRevenue as $revenue)
                    <tr>
                        <td>{{ $revenue->month }}</td>
                        <td>{{ $revenue->year }}</td>
                        <td>{{ number_format($revenue->revenue, 0, ',', '.') }} VNĐ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h3 class="card-title">Doanh thu từ đơn hàng có mã giảm giá</h3>
            <p class="lead">{{ number_format($revenueWithDiscount, 0, ',', '.') }} VNĐ</p>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h3 class="card-title">Tổng số tiền giảm giá</h3>
            <p class="lead">{{ number_format($totalDiscount, 0, ',', '.') }} VNĐ</p>
        </div>
    </div>
    <hr>
    
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
