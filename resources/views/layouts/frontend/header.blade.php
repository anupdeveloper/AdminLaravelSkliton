<!-- Mobile Nav (max width 767px)-->
<div class="mobile-nav">
    <!-- Navbar Brand -->
    <div class="amado-navbar-brand">
        <a href="{{route('index')}}"><h1>{{  env('APP_NAME') }}</h1></a>
    </div>
    <!-- Navbar Toggler -->
    <div class="amado-navbar-toggler">
        <span></span><span></span><span></span>
    </div>
</div>
<!-- Search Wrapper Area Start -->
<div class="search-wrapper section-padding-100">
    <div class="search-close">
        <i class="fa fa-close" aria-hidden="true"></i>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="search-content">
                    <form action="#" method="get">
                        <input type="search" name="search" id="search" placeholder="Type your keyword...">
                        <button type="submit"><img src="{{asset('/frontend/img/core-img/search.png')}}" alt=""></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Search Wrapper Area End -->
<!-- Header Area Start -->
<header class="header-area clearfix">
    <!-- Close Icon -->
    <div class="nav-close">
        <i class="fa fa-close" aria-hidden="true"></i>
    </div>
    <!-- Logo -->
    <div class="logo">
        <a href="{{route('index')}}"><!--h1>{{  env('APP_NAME') }}</h1--><img src="{{asset('/frontend/img/logo.png')}}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style=""></a>
    </div>
    <!-- Amado Nav -->
    <nav class="amado-nav">
        <ul>
            <li @if(Route::is('index')) class="active" @endif ><a href="{{route('index')}}">Home</a></li>
            <li @if(Route::is('about')) class="active" @endif><a href="{{route('about')}}">About</a></li>
            {{-- <li @if(Route::is('index')) class="active" @endif><a href="{{route('index')}}">Products</a></li> --}}
            <li @if(Route::is('contact')) class="active" @endif><a href="{{route('contact')}}">Contact</a></li>
        </ul>
    </nav>
    <!-- Button Group -->
     {{-- <div class="amado-btn-group mt-30 mb-100">
        <a href="#" class="btn amado-btn mb-15">%Discount%</a>
        <a href="#" class="btn amado-btn active">New this week</a>
    </div> --}}
    <!-- Cart Menu -->
    <div class="cart-fav-search mb-100">
        {{-- <a href="cart.html" class="cart-nav"><img src="{{asset('/frontend/img/core-img/cart.png')}}" alt=""> Cart <span>(0)</span></a>
        <a href="#" class="fav-nav"><img src="{{asset('/frontend/img/core-img/favorites.png')}}" alt=""> Favourite</a> --}}
        {{-- <a href="#" class="search-nav"><img src="{{asset('/frontend/img/core-img/search.png')}}" alt=""> Search</a> --}}
    </div>
    <!-- Social Button -->
    <div class="social-info d-flex justify-content-between">
        <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
        <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
        <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
        <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
    </div>
</header>
<!-- Header Area End -->