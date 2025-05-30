@extends('admin.layout.default')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <h2 class="mb-4">Thêm người dùng mới</h2>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
            
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            
                <div class="form-group">
                    <label for="name">Tên người dùng</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label for="permissions">Chọn quyền</label>
                    <select name="permissions" id="permissions" class="form-control">
                        @foreach($permissions as $permission)
                            <option value="{{ $permission->id }}" {{ old('permissions') == $permission->id ? 'selected' : '' }}>
                                {{ $permission->permission_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Xác nhận mật khẩu</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Thêm người dùng</button>
            </form>
            
            
        </div>
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

    <!-- Swiper slider js-->
    <script src="{{ asset('admin/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('admin/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('admin/assets/js/app.js') }}"></script>
@endpush
@endsection
