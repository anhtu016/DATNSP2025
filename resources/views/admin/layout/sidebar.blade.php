<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ url('homeadmin') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{asset('admin/assets/images/logo-sm.png')}}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{asset('admin/assets/images/logo-dark.png')}}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ url('homeadmin') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{asset('admin/assets/images/logo-sm.png')}}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{asset('admin/assets/images/logo-light.png')}}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <!-- Sidebar -->
    <div id="scrollbar">
        <div class="container-fluid">
    
            <!-- Logo trong menu thu gọn -->
            <div id="two-column-menu" class="text-center mb-3">
                <a href="{{ url('homeadmin') }}">
                    <img src="{{ asset('admin/assets/images/logo-sm.png') }}" alt="Mini Logo" height="32">
                </a>
            </div>
    
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title">
                    <span data-key="t-menu">Menu</span>
                </li>
    
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link menu-link d-flex align-items-center" href="{{ url('homeadmin') }}">
                        <i class="ri-dashboard-2-line me-2"></i> 
                        <span data-key="t-dashboards">Tổng quan</span>
                    </a>
                </li>
    
                <!-- Users -->
                <li class="nav-item">
                    <a class="nav-link menu-link d-flex align-items-center" href="#sidebarUsers" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarUsers">
                        <i class="ri-user-line me-2"></i> 
                        <span data-key="t-users">Người dùng</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarUsers">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('users.index')}}" class="nav-link">Danh sách người dùng</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('users.create')}}" class="nav-link">Thêm người dùng</a>
                            </li>
                        </ul>
                    </div>
                </li>
    
                <!-- Products -->
                <li class="nav-item">
                    <a class="nav-link menu-link d-flex align-items-center" href="#sidebarProducts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProducts">
                        <i class="ri-shopping-bag-2-line me-2"></i> 
                        <span data-key="t-products">Sản phẩm</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarProducts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('products.index') }}" class="nav-link">Danh sách sản phẩm</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('products.create') }}" class="nav-link">Thêm sản phẩm</a>
                            </li>
                        </ul>
                    </div>
                </li>
    
                <!-- Categories -->
                <li class="nav-item">
                    <a class="nav-link menu-link d-flex align-items-center" href="#sidebarCategories" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCategories">
                        <i class="ri-folder-line me-2"></i> 
                        <span data-key="t-categories">Danh mục</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarCategories">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('list-categories') }}" class="nav-link">Danh sách danh mục</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('add-categories') }}" class="nav-link">Thêm danh mục</a>
                            </li>
                        </ul>
                    </div>
                </li>
    
                <!-- Orders -->
                <li class="nav-item">
                    <a class="nav-link menu-link d-flex align-items-center" href="{{route('admin.orders.index')}}">
                        <i class="ri-shopping-cart-2-line me-2"></i> 
                        <span data-key="t-orders">Đơn hàng</span>
                    </a>
                </li>
    
                <!-- Coupons -->
                <li class="nav-item">
                    <a class="nav-link menu-link d-flex align-items-center" href="{{route('admin.coupons.index')}}">
                        <i class="ri-bar-chart-line me-2"></i> 
                        <span data-key="t-coupons">Mã giảm giá</span>
                    </a>
                </li>
    
                <!-- Reviews -->
                <li class="nav-item">
                    <a class="nav-link menu-link d-flex align-items-center" href="#sidebarReviews" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarReviews">
                        <i class="ri-star-line me-2"></i> 
                        <span data-key="t-reviews">Đánh giá</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarReviews">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('list-reviews') }}" class="nav-link">Danh sách đánh giá</a>
                            </li>
                        </ul>
                    </div>
                </li>
    
                <!-- Attributes -->
                <li class="nav-item">
                    <a class="nav-link menu-link d-flex align-items-center" href="#sidebarAttributes" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAttributes">
                        <i class="ri-equalizer-line me-2"></i> 
                        <span data-key="t-attributes">Biến thể</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAttributes">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ ('attributes') }}" class="nav-link">Thêm biến thể</a>
                            </li>
                        </ul>
                    </div>
                </li>
    
                <!-- Home -->
                <li class="nav-item">
                    <a class="nav-link menu-link d-flex align-items-center" href="{{ route('home') }}">
                        <i class="ri-home-line me-2"></i> 
                        <span data-key="t-home">Trang chủ</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>