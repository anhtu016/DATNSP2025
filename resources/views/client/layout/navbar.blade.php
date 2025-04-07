<header class="version_2">
    <div class="layer"></div><!-- Mobile menu overlay mask -->
    <div class="top_line version_1 plus_select">
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-sm-6 col-5">"Marketplace since 1995"
                </div>
                <div class="col-sm-6 col-7">
                    <ul class="top_links">
                        <li>
                            <div class="styled-select lang-selector">
                                <select>
                                    <option value="English" selected>English</option>
                                    <option value="French">French</option>
                                    <option value="Spanish">Spanish</option>
                                    <option value="Russian">Russian</option>
                                </select>
                            </div>
                        </li>
                        <li><div class="styled-select currency-selector">
                            <select>
                                <option value="US Dollars" selected="">US Dollars</option>
                                <option value="Euro">Euro</option>
                            </select>
                        </div></li>
                    </ul>
                </div>
            </div>
            <!-- End row -->
        </div>
        <!-- End container-->
    </div>
    <div class="main_header Sticky">
        <div class="container">
            <div class="row small-gutters">
                <div class="col-xl-3 col-lg-3 d-lg-flex align-items-center">
                    <div id="logo">
                        <a href="index.html"><img src="{{asset('client/img/logo_black.svg')}}" alt="" width="100" height="35"></a>
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
                            <a href="index.html"><img src="{{asset('client/img/logo_black.svg')}}" alt="" width="100" height="35"></a>
                            <a href="#" class="open_close" id="close_in"><i class="ti-close"></i></a>
                        </div>
                        <ul>
                            <li>
                                <a href="javascript:void(0);" class="show-submenu">Home</a>
                            </li>
                            <li class="megamenu submenu">
                                <a href="javascript:void(0);" class="show-submenu-mega">Pages</a>
                                <div class="menu-wrapper">
                                    <div class="row small-gutters">
                                        <div class="col-lg-3">
                                            <h3>Listing grid</h3>
                                            <ul>
                                                <li><a href="listing-grid-1-full.html">Grid Full Width</a></li>
                                                <li><a href="listing-grid-2-full.html">Grid Full Width 2</a></li>
                                                <li><a href="listing-grid-3.html">Grid Boxed</a></li>
                                                <li><a href="listing-grid-4-sidebar-left.html">Grid Sidebar Left</a></li>
                                                <li><a href="listing-grid-5-sidebar-right.html">Grid Sidebar Right</a></li>
                                                <li><a href="listing-grid-6-sidebar-left.html">Grid Sidebar Left 2</a></li>
                                                <li><a href="listing-grid-7-sidebar-right.html">Grid Sidebar Right 2</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3">
                                            <h3>Listing row &amp; Product</h3>
                                            <ul>
                                                <li><a href="listing-row-1-sidebar-left.html">Row Sidebar Left</a></li>
                                                <li><a href="listing-row-2-sidebar-right.html">Row Sidebar Right</a></li>
                                                <li><a href="listing-row-3-sidebar-left.html">Row Sidebar Left 2</a></li>
                                                <li><a href="listing-row-4-sidebar-extended.html">Row Sidebar Extended</a></li>
                                                <li><a href="product-detail-1.html">Product Large Image</a></li>
                                                <li><a href="product-detail-2.html">Product Carousel</a></li>
                                                <li><a href="product-detail-3.html">Product Sticky Info</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3">
                                            <h3>Other pages</h3>
                                            <ul>
                                                <li><a href="cart.html">Cart Page</a></li>
                                                <li><a href="checkout.html">Check Out Page</a></li>
                                                <li><a href="confirm.html">Confirm Purchase Page</a></li>
                                                <li><a href="account.html">Create Account Page</a></li>
                                                <li><a href="track-order.html">Track Order</a></li>
                                                <li><a href="help.html">Help Page</a></li>
                                                <li><a href="help-2.html">Help Page 2</a></li>
                                                <li><a href="leave-review.html">Leave a Review</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3 d-xl-block d-lg-block d-md-none d-sm-none d-none">
                                            <div class="banner_menu">
                                                <a href="#0">
                                                    <img src="data:{{asset('client/image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==')}}" data-src="{{asset('client/img/banner_menu.jpg')}}" width="400" height="550" alt="" class="img-fluid lazy">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /row -->
                                </div>
                                <!-- /menu-wrapper -->
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">Extra Pages</a>
                                <ul>
                                    @foreach ($categories as $category)
                                        <li>
                                            <a href="{{ $category->slug }}">{{ $category->name }}</a>
                                            @if ($category->children->isNotEmpty())
                                                <ul>
                                                    @foreach ($category->children as $child)
                                                        <li>
                                                            <a href="{{ $child->slug }}">{{ $child->name }}</a>
                                                            @if ($child->children->isNotEmpty())
                                                                <ul>
                                                                    @foreach ($child->children as $grandchild)
                                                                        <li>
                                                                            <a href="{{ $grandchild->slug }}">{{ $grandchild->name }}</a>
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
                                <a href="blog.html">Blog</a>
                            </li>
                            <li>
                                <a href="#" target="_parent">Contact</a>
                            </li>
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
                                        <li><a class="dropdown-item" href="#"><i class="ti-user"></i> My Profile</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="ti-package"></i> My Orders</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="ti-user"></i> Track your Orders</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="ti-heart"></i> Wishlist </a></li>
                                        <li><a class="dropdown-item" href="#"><i class="ti-help-alt"></i> Help and Faq </a></li>
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
                                        <a href="{{ route('login') }}" class="access_link"><span>Account</span></a>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('login') }}" class="btn_1">Sign In or Sign Up</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /row -->
        </div>
    </div>
    <!-- /main_header -->
</header>