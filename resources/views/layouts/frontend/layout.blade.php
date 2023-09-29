<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>{{  env('APP_NAME') }} | Home</title>

    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{asset('/frontend/css/core-style.css') }}">
    <link rel="stylesheet" href="{{asset('/frontend/style.css') }}">

</head>
    <body>
        {{-- @include('layouts.frontend.header') --}}

        @yield('content')

        {{-- @include('layouts.frontend.footer') --}}
        <script src="{{asset('/frontend/js/jquery/jquery-2.2.4.min.js')}}"></script>
        <!-- Popper js -->
        <script src="{{asset('/frontend/js/popper.min.js')}}"></script>
        <!-- Bootstrap js -->
        <script src="{{asset('/frontend/js/bootstrap.min.js')}}"></script>
        <!-- Plugins js -->
        <script src="{{asset('/frontend/js/plugins.js')}}"></script>
        <!-- Active js -->
        <script src="{{asset('/frontend/js/active.js')}}"></script>

        <script>
            jQuery(document).ready(function(){
                jQuery(".prod-popup").hide();
                jQuery(".close-btn").click(function(){
                    jQuery(".prod-popup").hide();
                });
                jQuery(".cus-book-now ").click(function(){
                    $(".prod-popup").show();
                });
            });
        </script>
    </body>

</html>