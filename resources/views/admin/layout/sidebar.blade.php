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
    
                <li class="nav-item">
                    <a class="nav-link menu-link d-flex align-items-center" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line me-2"></i> 
                        <span data-key="t-dashboards">Dashboards</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
            
                            <!-- User submenu -->
                            <li class="nav-item">
                                <a class="nav-link" href="#userMenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="userMenu">
                                    <i class="ri-user-line me-1"></i> User
                                </a>
                                <div class="collapse menu-dropdown" id="userMenu">
                                    <ul class="nav nav-sm flex-column ms-3">
                                        <li class="nav-item">
                                            <a href="{{route('users.index')}}" class="nav-link">List User</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('users.create')}}" class="nav-link">Add User</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
            
                            <!-- Other links -->
                            <li class="nav-item">
                                <a href="dashboard-crm.html" class="nav-link">
                                    <i class="ri-bar-chart-line me-1"></i> CRM
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.orders.index')}}" class="nav-link">
                                    <i class="ri-shopping-cart-2-line me-1"></i> Orders
                                </a>
                            </li>
            
                        </ul>
                    </div>
                </li>
            
                <!-- Attributes -->
                <li class="nav-item">
                    <a class="nav-link menu-link d-flex align-items-center" href="#sidebarAttributes" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAttributes">
                        <i class="ri-equalizer-line me-2"></i> <span data-key="t-dashboards">Attribute</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAttributes">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ ('attributes') }}" class="nav-link">Add</a>
                            </li>
                        </ul>
                    </div>
                </li>
            
                <!-- Products Section with Logo and Add Product -->
                <li class="nav-item">
                    <a class="nav-link menu-link d-flex align-items-center" href="#sidebarProducts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProducts">
                        <i class="ri-shopping-bag-2-line me-2"></i> <span data-key="t-products">Products</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarProducts">
                        <ul class="nav nav-sm flex-column ms-3">
                            <li class="nav-item">
                                <a href="{{ route('products.index') }}" class="nav-link">List Products</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('products.create') }}" class="nav-link">Add Product</a>
                            </li>
                        </ul>
                    </div>
                </li>
            
    
                <!-- Apps -->
                <li class="nav-item">
                    <a class="nav-link menu-link d-flex align-items-center" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line me-2"></i> <span data-key="t-apps">Apps</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                            <!-- Categories -->
                            <li class="nav-item">               
                                <a href="#categoriesMenu" class="nav-link d-flex align-items-center" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="categoriesMenu">
                                    <i class="ri-folder-line me-1"></i> Categories
                                </a>
                                <div class="collapse menu-dropdown" id="categoriesMenu">
                                    <ul class="nav nav-sm flex-column ms-3">
                                        <li class="nav-item">
                                            <a href="{{ url('list-categories') }}" class="nav-link">List Category</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('add-categories') }}" class="nav-link" data-key="t-create-product"> Add Category </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            
                            <!-- Reviews -->
                            <li class="nav-item">
                                <a href="#reviewsMenu" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="reviewsMenu">
                                   <i class="ri-star-line me-1"></i> Reviews
                                </a>
                                <div class="collapse menu-dropdown" id="reviewsMenu">
                                    <ul class="nav nav-sm flex-column ms-3">
                                        <li class="nav-item">
                                            <a href="{{ url('list-reviews') }}" class="nav-link" data-key="t-products"> List Reviews </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link d-flex align-items-center" href="{{ route('home') }}">
                        <i class="ri-home-line me-2"></i> <span data-key="t-home">Trang chủ</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>