<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ (App::getlocale()=='ar' ? 'rtl' : 'ltr') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <title> {{  env('APP_NAME') }} </title>

   
 
  <!-- Stylesheets -->
<link href="{{asset('/assets_front/css/bootstrap.css')}}" rel="stylesheet">
@if (App::getLocale()=='en')
<link href="{{asset('/assets_front/css/style.css')}}" rel="stylesheet">
@else
<link href="{{asset('/assets_front/css/style-rtl.css')}}" rel="stylesheet">
@endif
<!-- Responsive File -->
<link href="{{asset('/assets_front/css/responsive.css')}}" rel="stylesheet">
<!-- Color File -->
<link href="{{asset('/assets_front/css/color.css')}}" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&family=Fira+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<link rel="stylesheet" href="{{asset('/assets_front/style.css')}}">
<link rel="shortcut icon" href="{{asset('/assets_admin/images/favicon-32x32.png')}}" type="image/x-icon">
<link rel="icon" href="{{asset('/assets_admin/images/favicon-32x32.png')}}" type="image/x-icon">

<!-- Responsive -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<style>
.language-translator {
   position: absolute;
   top: 0;
   right: 0;
   z-index: 999 !important;
}
</style>
 
@if(App::getlocale()=='ar')

<style>
label.pricing-label.card.shadow.bg-white.no-border.mb-0, p.alert.alert-info, .pricing-block {
    text-align: right !important;
}

.note {
    text-align: right !important;
}
</style>


@endif
  
  @stack('links')
</head>
<body>
    
    <div class="page-wrapper" id="app">
        <!-- Preloader -->
    <div class="loader-wrap">
        <div class="preloader"><div class="preloader-close">Preloader Close</div></div>
        <div class="layer layer-one"><span class="overlay"></span></div>
        <div class="layer layer-two"><span class="overlay"></span></div>        
        <div class="layer layer-three"><span class="overlay"></span></div>        
    </div>
        
    <!-- Main Header -->
    <header class="main-header header-style-one">

        <!-- Header Upper -->
        
        <div class="header-upper">
            <div class="auto-container">
                <div class="inner-container clearfix">
                    <!--Logo-->
                    <div class="logo-box">
                        <div class="logo"><a target="_blank" href="{{ url('/') }}"><img src="{{asset('/assets_front/img/logo.png')}}" alt=""><span>Awaser</span></a></div>
                    </div>
                    <!--Nav Box-->
                </div>
            </div>
        </div>
        
        <!--End Header Upper-->

        <!-- Mobile Menu  -->
        <div class="mobile-menu">
            <div class="menu-backdrop"></div>
            <div class="close-btn"><span class="icon flaticon-remove"></span></div>
            
            <nav class="menu-box">
                <div class="nav-logo"><a href="index.html"><img src="{{asset('/assets_front/img/logo.png')}}" alt="" title=""><span>Awaser</span></a></div>
                <div class="menu-outer"><!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header--></div>
                <!--Social Links-->
                <div class="social-links">
                    <ul class="clearfix">
                        <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                        <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                        <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                        <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                        <li><a href="#"><span class="fab fa-youtube"></span></a></li>
                    </ul>
                </div>
            </nav>
        </div><!-- End Mobile Menu -->

        <div class="nav-overlay">
            <div class="cursor"></div>
            <div class="cursor-follower"></div>
        </div>
        
    </header>
        @yield('content')

        @include('layouts.footer')
    </div>
</body>
</html>
