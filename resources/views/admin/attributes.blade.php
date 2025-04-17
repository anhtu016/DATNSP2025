@extends('admin.layout.default')
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Products</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Ecommerce</a></li>
                                <li class="breadcrumb-item active">Products</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="">
                    <div>
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="row g-4">
                                    <div class="col-sm-auto">
                                        <div>
                                            <!-- Horizontal Collapse -->
                                            <div class="mb-3">
                                                <button class="btn btn-secondary" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseWidthExample" aria-expanded="true"
                                                    aria-controls="collapseWidthExample">
                                                    <i class="ri-add-line align-bottom me-1"> Add Attribute</i>
                                                </button>
                                            </div>

                                            <div>
                                                <div class="collapse collapse-horizontal hiden" id="collapseWidthExample">
                                                    <div class="card card-body mb-0" style="width: 300px;">
                                                        <div>
                                                            <form action="{{ route('attributes.store') }}" method="post">
                                                                @csrf
                                                                <label for="nameAttribute" class="form-label">Name
                                                                    Attribute</label>
                                                                <input type="text" class="form-control"
                                                                    name="nameAttribute" id="nameAttribute">
                                                                <label for="selectAttribute" class="form-label">Type</label>
                                                                <select id="selectAttribute" name="selectAttribute"
                                                                    class="form-select mb-3"
                                                                    aria-label="Default select example">
                                                                    <option selected>Open this select menu</option>
                                                                    <option value="text">Text</option>
                                                                    <option value="image">Image</option>
                                                                    <option value="color">Color</option>
                                                                </select>
                                                                <button type="submit"
                                                                    class="btn btn-success bg-gradient waves-effect waves-light">Success</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="search-box ms-2">
                                                <input type="text" class="form-control" id="searchProductList"
                                                    placeholder="Search Products...">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Varying Modal Content -->


                            <!-- Varying modal content -->

                            <!-- Bordered Tables -->
                            <table class="table table-bordered table-nowrap">
                                <thead>
                                    <tr>
                                        <th scope="col">Index</th>
                                        <th scope="col">Attribute</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Value</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>



                                    @foreach ($dataAttributes as $index => $attribute)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $attribute->name }}</td>
                                            <td><span
                                                    class="badge bg-secondary-subtle text-secondary">{{ $attribute->type }}</span>
                                            </td>
                                            <td>
                                                @foreach ($attribute->attributeValue as $value)
                                                    {{ $value->value }}
                                                @endforeach
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <a href="#" role="button" id="dropdownMenuLink"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-2-fill"></i>
                                                    </a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <li>
                                                            {{-- <a class="dropdown-item" >Edit</a> --}}
                                                            <!-- Horizontal Collapse -->
                                                            <!-- Grids in modals -->
                                                            <button type="button" class="btn dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#{{ $attribute->name }}">
                                                                Edit
                                                            </button>

                                                        </li>
                                                        <li>
                                                            <form id="deleteForm-{{ $attribute->id }}"
                                                                action="{{ route('attributes.destroy', $attribute->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('delete')
                                                                {{-- <a class="btn dropdown-item" href="{{ route('attributes.destroy')}}">Delete</a> --}}
                                                            </form>
                                                            <button class="btn dropdown-item"
                                                                onclick="confirmDelete({{ $attribute->id }})">Delete</button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="{{ $attribute->name }}" tabindex="-1"
                                            aria-labelledby="id?{{ $attribute->id }}" aria-modal="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="id?{{ $attribute->id }}">Update
                                                            Attribute</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('attributes.update', $attribute->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('put')
                                                            <div class="row g-3">
                                                                <div class="col-xxl-6">
                                                                    <div>
                                                                        <label for="firstName" class="form-label">Name
                                                                            Attribute</label>
                                                                        <input type="text" class="form-control"
                                                                            id="firstName" name="updateAttribute"
                                                                            value="{{ $attribute->name }}">
                                                                    </div>
                                                                </div><!--end col-->
                                                                <div class="col-xxl-6">
                                                                    <div>
                                                                        <label for="selectType"
                                                                            class="form-label">Type</label>
                                                                        <select name="updateType" id="selectType"
                                                                            class="form-select">
                                                                            <option selected
                                                                                value="{{ $attribute->type }}">
                                                                                {{ $attribute->type }}</option>
                                                                            @foreach (['color', 'size', 'image'] as $type)
                                                                                @if ($type !== $attribute->type)
                                                                                    <!-- Kiểm tra giá trị hiện tại có trùng không -->
                                                                                    <option value="{{ $type }}">
                                                                                        {{ ucfirst($type) }}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div><!--end col-->

                                                                <div class="col-lg-12">
                                                                    <div class="hstack gap-2 justify-content-end">
                                                                        <button type="button" class="btn btn-light"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Update</button>
                                                                    </div>
                                                                </div><!--end col-->
                                                            </div><!--end row-->
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $dataAttributes->links('pagination::bootstrap-5') }}
                            <!-- end card header -->

                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- css-->
    @push('admin_css')
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}">

        <!-- nouisliderribute css -->
        <link rel="stylesheet" href="{{ asset('admin/assets/libs/nouislider/nouislider.min.css') }}">

        <!-- gridjs css -->
        <link rel="stylesheet" href="{{ asset('admin/assets/libs/gridjs/theme/mermaid.min.css') }}">

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
        <link href="{{ asset('admin/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
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

        <!-- nouisliderribute js -->
        <script src="{{ asset('admin/assets/libs/nouislider/nouislider.min.js') }}"></script>
        <script src="{{ asset('admin/assets/libs/wnumb/wNumb.min.js') }}"></script>

        <!-- gridjs js -->
        <script src="{{ asset('admin/assets/libs/gridjs/gridjs.umd.js') }}"></script>
        <script src="https://unpkg.com/gridjs/plugins/selection/dist/selection.umd.js')}}"></script>
        <!-- Sweet Alerts js -->
        <script src="{{ asset('admin/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <!-- Sweet alert init js-->
        <script src="{{ asset('admin/assets/js/pages/sweetalerts.init.js') }}"></script>
        <!-- App js -->
        <script src="{{ asset('admin/assets/js/app.js') }}"></script>
        @if (session('success'))
            <script>
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "{{ session('success') }}",
                    width: 300,
                    height: 100,
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
        @endif
        <script>
            function confirmDelete(id) {
                Swal.fire({
                    title: 'Bạn có chắc chắn muốn xóa?',
                    text: "Hành động này không thể hoàn tác!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Vâng, xóa nó!',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tìm form có id là deleteForm và submit nó
                        document.getElementById('deleteForm-' + id).submit();
                    }
                });

            }
        </script>
    @endpush
    <!--end js-->
@endsection
