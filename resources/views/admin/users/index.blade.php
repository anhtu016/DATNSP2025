@extends('admin.layout.default')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <h2 class="mb-4">Danh sách người dùng</h2>

            <!-- Thông báo lỗi -->
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Thông báo thành công -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form method="GET" action="{{ route('users.index') }}" class="row gy-2 gx-3 align-items-center mb-4">
                <div class="col-md-4">
                    <label class="form-label visually-hidden" for="keywordInput">Tìm kiếm</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="keywordInput" name="keyword"
                            placeholder="Tên hoặc email" value="{{ request('keyword') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label visually-hidden" for="permissionSelect">Quyền</label>
                    <select class="form-select" id="permissionSelect" name="permission_id">
                        <option value="">-- Tất cả quyền --</option>
                        @foreach ($permissions as $permission)
                            @php
                                switch ($permission->permission_name) {
                                    case 'admin':
                                        $displayName = 'Quản trị viên';
                                        break;
                                    case 'staff':
                                        $displayName = 'Nhân viên quản lý';
                                        break;
                                    case 'accountant':
                                        $displayName = 'Kế toán';
                                        break;
                                    case 'user':
                                    default:
                                        $displayName = 'Người dùng';
                                        break;
                                }
                            @endphp
                            <option value="{{ $permission->id }}"
                                {{ request('permission_id') == $permission->id ? 'selected' : '' }}>
                                {{ $displayName }}
                            </option>
                        @endforeach
                    </select>

                </div>

                <div class="col-md-2">
                    <label class="form-label visually-hidden" for="statusSelect">Trạng thái</label>
                    <select class="form-select" id="statusSelect" name="is_active">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Đang hoạt động</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Đã khóa</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-filter"></i> Lọc
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-clockwise"></i> Đặt lại
                    </a>
                </div>
            </form>

            <!-- Bảng danh sách người dùng -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Quyền</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>

                            <!-- Quyền của người dùng -->
                            <td>
                                @if ($user->permissions && $user->permissions->count())
                                    @foreach ($user->permissions as $permission)
                                        @php
                                            switch ($permission->permission_name) {
                                                case 'admin':
                                                    $displayName = 'Quản trị viên';
                                                    $color = 'text-danger';
                                                    break;
                                                case 'staff':
                                                    $displayName = 'Nhân viên quản lý';
                                                    $color = 'text-primary';
                                                    break;
                                                case 'accountant':
                                                    $displayName = 'Kế toán';
                                                    $color = 'text-warning';
                                                    break;
                                                case 'user':
                                                default:
                                                    $displayName = 'Người dùng';
                                                    $color = 'text-success';
                                                    break;
                                            }
                                        @endphp
                                        <span class="{{ $color }}">{{ $displayName }}</span>
                                        @if (!$loop->last)
                                            <span>, </span>
                                        @endif
                                    @endforeach
                                @else
                                    <span class="text-success">Người dùng</span>
                                @endif
                            </td>


                            <!-- Ngày tạo người dùng -->
                            <td>{{ $user->created_at->format('d-m-Y H:i') }}</td>

                            <!-- Hành động: Sửa và Khóa -->
                            <td class="text-center">
                                <!-- Nút sửa -->
                                @if ($user->permissions && !$user->permissions->contains('permission_name', 'admin'))
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                @endif
                                {{-- <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')


                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>

                                </form> --}}

                            </td>

                            <td>

                                @if ($user->is_active)
                                    <span class="text-success">Đang hoạt động</span>
                                @else
                                    <span class="text-danger">Đã khóa</span>
                                @endif

                                <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    @if ($user->permissions && !$user->permissions->contains('permission_name', 'admin'))
                                        <button class="btn btn-sm btn-danger">
                                            {{ $user->is_active ? 'Khóa' : 'Mở khóa' }}
                                        </button>
                                    @endif


                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end mt-3">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
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
    <!--end js-->
@endsection
