<header class="version_2">
    <div class="layer"></div><!-- Mobile menu overlay mask -->
    <div class="main_header Sticky">
        <div class="container">
            <div class="row small-gutters">
                <div class="col-xl-3 col-lg-3 d-lg-flex align-items-center">
                    <div id="logo">
                        <a href="{{route('homeadmin')}}"><img src="{{asset('client/img/logo_black.svg')}}" alt="" width="100" height="35"></a>
                    </div>
                </div>
                <nav class="col-xl-6 col-lg-7">
                    <a class="open_close" href="javascript:void(0);">
                        <div class="hamburger hamburger--spin">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </a>
                    <!-- Mobile menu button -->
                    <div class="main-menu">           
                        <div id="header_menu">
                            <a href="{{route('home')}}"><img src="{{asset('client/img/logo_black.svg')}}" alt="" width="100" height="35"></a>
                            <a href="{{route('home')}}" class="open_close" id="close_in"><i class="ti-close"></i></a>
                        </div>
                        <ul>
                            <li>
                                <a href="{{route('home')}}" class="show-submenu">Trang chủ</a>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">Danh mục</a>
                                <ul>
                                    @foreach ($categories as $category)
                                        <li>
                                            <a href="{{ route('categories.products', $category->slug) }}">{{ $category->name }}</a>
                                            @if ($category->children->isNotEmpty())
                                                <ul>
                                                    @foreach ($category->children as $child)
                                                        <li>
                                                            <a href="{{ route('categories.products', $child->slug) }}">{{ $child->name }}</a>
                                                            @if ($child->children->isNotEmpty())
                                                                <ul>
                                                                    @foreach ($child->children as $grandchild)
                                                                        <li>
                                                                            <a href="{{ route('categories.products', $grandchild->slug) }}">{{ $grandchild->name }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li>
                                <a href="{{route('promotions.index')}}" class="show-submenu">Ưu đãi</a>
                            </li>
                            {{-- <li>
                                <a href="blog.html">Blog</a>
                            </li>
                            <li>
                                <a href="#" target="_parent">Contact</a>
                            </li>        --}}
                        </ul>
                    </div>
                    <!--/main-menu -->
                </nav>
                
                <div class="col-xl-3 col-lg-2 d-lg-flex align-items-center justify-content-end text-end">
                    <ul class="top_tools d-flex align-items-center gap-3">
                        <!-- Tài khoản -->
                        <li>
                            <div class="dropdown">
                                @if(Auth::check()) 
                                    <button class="btn dropdown-toggle d-flex align-items-center" type="button" id="user" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span>Xin chào, <strong>{{ Auth::user()->name }}</strong></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="user">
                                     
                                        <li><a class="dropdown-item" href="{{route('user.orders.index')}}"><i class="ti-user"></i> Theo dõi đơn hàng</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger"><i class="ti-power-off"></i> Đăng xuất</button>
                                            </form>
                                        </li>
                                    </ul>
                                @else
                                    <div class="dropdown dropdown-access">
                                        <a href="{{ route('login') }}" class="access_link"><span>Tài Khoản</span></a>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('login') }}" class="btn_1">Đăng nhập hoặc đăng ký</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                        </li>
                    </ul>
                    <div class="position-relative ms-2 mt-2 p-2">
                        <a href="{{ route('cart.view') }}" class="text-dark" style="font-size: 20px;">
                            <div style="position: relative; display: inline-block;">
                                <i class="ti-shopping-cart"></i>
                    
                                @php
                                    $cart = session()->get('cart', []);
                                    $cartCount = array_sum(array_column($cart, 'quantity'));
                                @endphp
                    
                                <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger"
                                      style="font-size: 11px; padding: 4px 6px;">
                                    {{ $cartCount > 0 ? $cartCount : '0' }}
                                </span>
                            </div>
                        </a>
                    </div>
                    
                </div>

            </div>
            <!-- /row -->
        </div>
    </div>
    <!-- /main_header -->
</header>
