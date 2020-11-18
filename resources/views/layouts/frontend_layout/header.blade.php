@inject('CommonTrait', 'App\Http\Controllers\UserAccountController')
<div class="mobile-fix-option"></div>
<div class="top-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="header-contact">
                    <ul>
                        <li>Welcome to Our store @isset(company_info()->company_name){{company_info()->company_name}}@endisset</li>
                        <li><i class="fa fa-phone" aria-hidden="true"></i>Call Us: @isset(company_info()->company_phone){{company_info()->company_phone}}@endisset</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 text-right">
                <ul class="header-dropdown">
                    <li class="mobile-wishlist"><a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a>
                    </li>
                    <li class="onhover-dropdown mobile-account"> <i class="fa fa-user" aria-hidden="true"></i>
                        My Account
                        <ul class="onhover-show-div">

                            @if(Session::get('user_id'))                          
                            <li><a href="{{ url('user/logout') }}" >Logout</a></li>
                            @else
                            <li><a href="{{ url('user/login') }}" data-lng="en">Login</a></li>
                            <li><a href="{{ url('user/registration') }}" data-lng="en">Registration</a></li>
                            @endif
                            
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="main-menu">
                <div class="menu-left">
                    <div class="navbar">
                        <a href="javascript:void(0)" onclick="openNav()">
                            <div class="bar-style"><i class="fa fa-bars sidebar-bar" aria-hidden="true"></i>
                            </div>
                        </a>
                        <div id="mySidenav" class="sidenav">
                            <a href="javascript:void(0)" class="sidebar-overlay" onclick="closeNav()"></a>
                            <nav>
                                <div onclick="closeNav()">
                                    <div class="sidebar-back text-left">
                                        <i class="fa fa-angle-left pr-2" aria-hidden="true"></i> 
                                        Back
                                    </div>
                                </div>
                                <ul id="sub-menu" class="sm pixelstrap sm-vertical">
                                @foreach(get_all_category() as $category)
                                <li>

                                    <a href="{{url('/'.$category->slug)}}">
                                        {{ $category->category_name }}
                                    </a>

                                    @if(count($category->subcategory))
                                        @include('frontend.header.category.sub_category_list',['sub_categories' => $category->subcategory])
                                    @endif

                                </li>
                                @endforeach
                                    
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="brand-logo">
                        <a href="{{url('/')}}">
                            <img src="{{asset('storage')}}/app/@isset(company_info()->company_thumbnail){{company_info()->company_thumbnail}}@endisset" class="img-fluid blur-up lazyload" alt="">
                        </a>
                    </div>
                </div>
                <div class="menu-right pull-right">
                    <div>
                        <nav id="main-nav">
                            <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
                            <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                                <li>
                                    <div class="mobile-back text-right">
                                        Back
                                        <i class="fa fa-angle-right pl-2" aria-hidden="true"></i>
                                    </div>
                                </li>
                                <li>
                                    <a href="#">Home</a>
                                </li>
                                
                                @foreach(get_all_category() as $category)
                                <li>
                                    
                                    <a href="{{url('/'.$category->slug)}}">
                                        {{ $category->category_name }}
                                    </a>
                                        
                                    @if(count($category->subcategory))
                                        @include('frontend.header.category.sub_category_list', ['sub_categories' => $category->subcategory])
                                    @endif
                                    
                                </li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>
                    <div>
                        <div class="icon-nav">
                            <ul>
                                <li class="onhover-div mobile-search">
                                    <div><img src="{{asset('public')}}/frontend_asset/images/icon/search.png" onclick="openSearch()"
                                              class="img-fluid blur-up lazyload" alt=""> <i class="ti-search"
                                              onclick="openSearch()"></i></div>
                                    <div id="search-overlay" class="search-overlay">
                                        <div> <span class="closebtn" onclick="closeSearch()"
                                                    title="Close Overlay">×</span>
                                            <div class="overlay-content">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <form>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                           id="exampleInputPassword1"
                                                                           placeholder="Search a Product">
                                                                </div>
                                                                <button type="submit" class="btn btn-primary"><i
                                                                        class="fa fa-search"></i></button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="onhover-div mobile-setting">
                                    <div><img src="{{asset('public')}}/frontend_asset/images/icon/setting.png"
                                              class="img-fluid blur-up lazyload" alt=""> <i
                                              class="ti-settings"></i></div>
                                    <div class="show-div setting">
                                        <h6>language</h6>
                                        <ul>
                                            <li><a href="#">english</a></li>
                                            <li><a href="#">french</a></li>
                                        </ul>
                                        <h6>currency</h6>
                                        <ul class="list-inline">
                                            <li><a href="#">euro</a></li>
                                            <li><a href="#">rupees</a></li>
                                            <li><a href="#">pound</a></li>
                                            <li><a href="#">doller</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="onhover-div mobile-cart">
                                    <div><a href="{{url('cart/cart-list')}}"><img src="{{asset('public')}}/frontend_asset/images/icon/cart.png"
                                              class="img-fluid blur-up lazyload" alt=""> <i
                                              class="ti-shopping-cart"></i></a></div>
                                    <ul class="show-div shopping-cart">
                                        <div id="getCart"></div>
                                        <li>
                                            <div class="buttons"><a href="{{url('cart/cart-list')}}" class="view-cart">view
                                                    cart</a> <a href="{{url('cart/checkout')}}" class="checkout">checkout</a></div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>