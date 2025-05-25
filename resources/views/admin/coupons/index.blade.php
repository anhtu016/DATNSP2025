@extends('admin.layout.default')
@section('content')
    <div class="page-content">
        <div class="container">
            <h2 class="mb-4">Danh sách mã giảm giá</h2>
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
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('coupons.create') }}" class="btn btn-primary">Tạo mã giảm giá mới</a>
            </div>

            <form method="GET" class="row g-2 mb-4 align-items-end" action="{{ route('coupons.index') }}">
    <div class="col-md-3">
        <label for="code" class="form-label">Mã giảm giá</label>
        <input type="text" name="code" id="code" class="form-control" 
               value="{{ request('code') }}" placeholder="Nhập mã giảm giá">
    </div>

            <div class="col-md-3">
        <label for="is_active" class="form-label">Trạng thái</label>
        <select name="is_active" id="is_active" class="form-select">
            <option value="">-- Tất cả trạng thái --</option>
            <option value="hidden" {{ request('is_active') == 'hidden' ? 'selected' : '' }}>Đã ẩn</option>
            <option value="upcoming" {{ request('is_active') == 'upcoming' ? 'selected' : '' }}>Chưa bắt đầu</option>
            <option value="expired" {{ request('is_active') == 'expired' ? 'selected' : '' }}>Hết hạn sử dụng</option>
            <option value="used_up" {{ request('is_active') == 'used_up' ? 'selected' : '' }}>Hết lượt sử dụng</option>
            <option value="active" {{ request('is_active') == 'active' ? 'selected' : '' }}>Đang áp dụng</option>
        </select>
    </div>
        <div class="col-md-3">
        <label for="type" class="form-label">Loại mã giảm giá</label>
        <select name="type" id="type" class="form-select">
            <option value="">-- Tất cả loại --</option>
            <option value="fixed" {{ request('type') == 'fixed' ? 'selected' : '' }}>Giảm cố định (VND)</option>
            <option value="percentage" {{ request('type') == 'percentage' ? 'selected' : '' }}>Giảm phần trăm (%)</option>
        </select>
    </div>
    <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary flex-fill">Lọc</button>
        <a href="{{ route('coupons.index') }}" class="btn btn-outline-secondary flex-fill">Đặt lại</a>
    </div>
</form>

            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã</th>
                        <th>Loại</th>
                        <th>Giá trị</th>
                        <th>Giá trị đơn hàng tối thiểu</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Sản phẩm được áp dụng</th>
                        <th>Lượt đã sử dụng</th>
                        <th>Giới hạn sử dụng</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coupons as $coupon)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $coupon->code }}</td>
                            <td>{{ $coupon->type }}</td>
                            <td>
                                @if ($coupon->type == 'fixed')
                                    Mã giảm {{ number_format($coupon->value) }}VND
                                @elseif($coupon->type == 'percentage')
                                    Mã giảm {{ $coupon->value }}%
                                @endif
                            </td>
                            <td>
                                @if ($coupon->min_order_value)
                                    {{ number_format($coupon->min_order_value) }}VND
                                @else
                                    <span class="text-muted">Không yêu cầu</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($coupon->start_date)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y') }}</td>
                            <td>
                                @if ($coupon->apply_to_all_products)
                                    <span class="badge bg-success">Tất cả sản phẩm</span>
                                @elseif($coupon->products->isEmpty())
                                    <span class="text-muted">Chưa có sản phẩm</span>
                                @else
                                    @foreach ($coupon->products as $product)
                                        <span class="badge bg-primary">{{ $product->name }}</span>
                                    @endforeach
                                @endif
                            </td>
                            <td>{{ $coupon->usage_count }}</td>
                            <td>{{ $coupon->usage_limit }}
                            </td>
                            <td>
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $start = \Carbon\Carbon::parse($coupon->start_date)->startOfDay();
                                    $end = \Carbon\Carbon::parse($coupon->end_date)->endOfDay();
                                @endphp

                                @if (!$coupon->is_active)
                                    <span class="badge bg-secondary">Đã ẩn</span>
                                @elseif ($now->lt($start))
                                    <span class="badge bg-warning text-dark">Chưa bắt đầu</span>
                                @elseif ($now->gt($end))
                                    <span class="badge bg-danger">Hết hạn sử dụng</span>
                                @elseif ((int) $coupon->usage_limit == (int) $coupon->usage_count)
                                    <span class="badge bg-info">Hết lượt sử dụng</span>
                                @else
                                    <span class="badge bg-success">Đang áp dụng</span>
                                @endif
                            </td>

                            <td>
                                <div class="btn-group">
                                    {{-- Hiện nút "Sửa" nếu mã chưa bắt đầu hoặc chưa có lượt sử dụng --}}
                                    @if ($now->lt($start) && $coupon->usage_count == 0)
                                        <a href="{{ route('coupons.edit', $coupon->id) }}"
                                            class="btn btn-warning btn-sm">Sửa</a>
                                    @endif

                                    {{-- Hiện nút "Xóa" nếu mã đã hết hạn --}}
                                    @if ($now->gt($end))
                                        <form id="delete-form-{{ $coupon->id }}"
                                            action="{{ route('coupons.destroy', $coupon->id) }}" method="POST"
                                            style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                        <button class="btn btn-danger btn-sm"
                                            onclick="confirmDelete({{ $coupon->id }})">Xóa</button>

                                        <script>
                                            function confirmDelete(id) {
                                                Swal.fire({
                                                    title: 'Bạn có chắc chắn muốn xóa mã giảm giá này?',
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#d33',
                                                    cancelButtonColor: '#3085d6',
                                                    confirmButtonText: 'Xóa',
                                                    cancelButtonText: 'Hủy'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        document.getElementById('delete-form-' + id).submit();
                                                    }
                                                })
                                            }
                                        </script>
                                    @endif

                                    {{-- Hiện nút "Ẩn/Hiện" nếu mã đã có lượt sử dụng --}}
                                   @if (($coupon->usage_count > 0 || $now->lt($end)) && !$now->lt($start))

                                        <form id="toggle-form-{{ $coupon->id }}"
                                            action="{{ route('coupons.toggle', $coupon->id) }}" method="POST"
                                            style="display:none;">
                                            @csrf
                                            @method('PATCH')
                                        </form>

                                        <button
                                            class="btn btn-sm {{ $coupon->is_active ? 'btn-outline-secondary' : 'btn-outline-success' }}"
                                            onclick="confirmToggle({{ $coupon->id }}, {{ $coupon->is_active ? 'true' : 'false' }})">
                                            {{ $coupon->is_active ? 'Ẩn' : 'Hiện' }}
                                        </button>

                                        <script>
                                            function confirmToggle(id, isActive) {
                                                Swal.fire({
                                                    title: `Bạn có chắc chắn muốn ${isActive ? 'ẩn' : 'hiển thị'} mã này?`,
                                                    icon: 'question',
                                                    showCancelButton: true,
                                                    confirmButtonColor: isActive ? '#6c757d' : '#28a745',
                                                    cancelButtonColor: '#d33',
                                                    confirmButtonText: isActive ? 'Ẩn' : 'Hiện',
                                                    cancelButtonText: 'Hủy'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        document.getElementById('toggle-form-' + id).submit();
                                                    }
                                                });
                                            }
                                        </script>
                                    @endif
                                </div>
                            </td>



                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="">
                {{ $coupons->links('pagination::bootstrap-5') }}
            </div>
        </div>
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
