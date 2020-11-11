@inject('CommonTrait', 'App\Http\Controllers\UserAccountController')
<div class="mobile-fix-option"></div>
<div class="top-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="header-contact">
                    <ul>
                        <li>Welcome to Our store @isset($company_data[0]->company_name){{$company_data[0]->company_name}}@endisset</li>
                        <li><i class="fa fa-phone" aria-hidden="true"></i>Call Us: @isset($company_data[0]->company_phone){{$company_data[0]->company_phone}}@endisset</li>
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
                            <li><a href="#" data-lng="en">Login</a></li>
                            <li><a href="{{ url('user/registration') }}" data-lng="en">Registration</a></li>
                            <li><a href="#" data-lng="es">Logout</a></li>
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
                        <a href="index.html">
                            <img src="{{asset('public')}}/frontend_asset/images/icon/logo.png" class="img-fluid blur-up lazyload" alt="">
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
                                
                                @foreach($all_parent_category as $category)
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
                                    <div><img src="{{asset('public')}}/frontend_asset/images/icon/cart.png"
                                              class="img-fluid blur-up lazyload" alt=""> <i
                                              class="ti-shopping-cart"></i></div>
                                    <ul class="show-div shopping-cart">
                                        <li>
                                            <div class="media">
                                                <a href="#"><img alt="" class="mr-3"
                                                                 src="{{asset('public')}}/frontend_asset/images/fashion/product/1.jpg"></a>
                                                <div class="media-body">
                                                    <a href="#">
                                                        <h4>item name</h4>
                                                    </a>
                                                    <h4><span>1 x $ 299.00</span></h4>
                                                </div>
                                            </div>
                                            <div class="close-circle"><a href="#"><i class="fa fa-times"
                                                                                     aria-hidden="true"></i></a></div>
                                        </li>
                                        <li>
                                            <div class="media">
                                                <a href="#"><img alt="" class="mr-3"
                                                                 src="{{asset('public')}}/frontend_asset/images/fashion/product/2.jpg"></a>
                                                <div class="media-body">
                                                    <a href="#">
                                                        <h4>item name</h4>
                                                    </a>
                                                    <h4><span>1 x $ 299.00</span></h4>
                                                </div>
                                            </div>
                                            <div class="close-circle"><a href="#"><i class="fa fa-times"
                                                                                     aria-hidden="true"></i></a></div>
                                        </li>
                                        <li>
                                            <div class="total">
                                                <h5>subtotal : <span>$299.00</span></h5>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="buttons"><a href="cart.html" class="view-cart">view
                                                    cart</a> <a href="#" class="checkout">checkout</a></div>
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