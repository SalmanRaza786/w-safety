<header class="li-header-4">

    <div class="header-middle pl-sm-0 pr-sm-0 pl-xs-0 pr-xs-0">
        <div class="container">
            <div class="row">
                <!-- Begin Header Logo Area -->
                <div class="col-lg-3">
                    <div class="logo pb-sm-30 pb-xs-30">
                        <a href="{{url('/')}}">
                            <h3 class="text-light">Riyadh Gift Cards</h3>
{{--                            <img src="{{ URL::asset('build/images/menu/logo/2.jpg')}}" alt="">--}}
                        </a>
                    </div>
                </div>
                <!-- Header Logo Area End Here -->
                <!-- Begin Header Middle Right Area -->
                <div class="col-lg-9 pl-0 ml-sm-15 ml-xs-15">
                    <!-- Begin Header Middle Searchbox Area -->
                    <form action="#" class="hm-searchbox">
                        <select class="nice-select select-search-category">
                            <option value="0">All</option>
                            <option value="10">Net Flix</option>
                            <option value="10">TV Series</option>


                        </select>
                        <input type="text" placeholder="Enter your search key ...">
                        <button class="li-btn" type="submit"><i class="fa fa-search"></i></button>
                    </form>

                    <div class="header-middle-right">
                        <ul class="hm-menu">

                            <li class="hm-minicart">
                                <div class="hm-minicart-trigger">
                                    <span class="item-icon"></span>
                                    <span class="item-text">
                                        <span class="subTotal"></span>
                                          <span class="cart-item-count"></span>
                                                </span>
                                </div>
                                <span></span>
                                <div class="minicart">
                                    <ul class="minicart-product-list" id="miniCart">


                                    </ul>
                                    <p class="minicart-total">SUBTOTAL: <span class="subTotal"></span></p>
                                    <div class="minicart-button">
                                        <a href="{{route('web.cart')}}" class="li-button li-button-dark li-button-fullwidth li-button-sm">
                                            <span>View Full Cart</span>
                                        </a>
                                        <a href="{{route('web.checkout')}}" class="li-button li-button-fullwidth li-button-sm">
                                            <span>Checkout</span>
                                        </a>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Header Middle Area End Here -->
    <!-- Begin Header Bottom Area -->
    <div class="header-bottom header-sticky stick d-none d-lg-block d-xl-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Begin Header Bottom Menu Area -->
                    <div class="hb-menu">
                        <nav>
                            <ul>

                                <li><a href="{{route('user.index')}}">Home</a></li>
                                <li><a href="{{route('web.shop')}}">Shop</a></li>
                                <li><a href="{{route('web.about')}}">About Us</a></li>
                                <li><a href="{{route('web.contact')}}">Get In Touch</a></li>
                                @if(Auth::check())
                                    <li><a href="{{ route('web.my.account') }}">My Account</a></li>
                                @endif



                            </ul>
                        </nav>
                    </div>
                    <!-- Header Bottom Menu Area End Here -->
                </div>
            </div>
        </div>
    </div>
    <!-- Header Bottom Area End Here -->
    <!-- Begin Mobile Menu Area -->
    <div class="mobile-menu-area mobile-menu-area-4 d-lg-none d-xl-none col-12">
        <div class="container">
            <div class="row">
                <div class="mobile-menu">
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu Area End Here -->
</header>
