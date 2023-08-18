@extends('layouts.frontend.layout')

@section('content')

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

    <!-- ##### Main Content Wrapper Start ##### -->
    <div class="main-content-wrapper d-flex clearfix">

        

        @include('layouts.frontend.header')

        <div class="single-product-area section-padding-100 clearfix">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mt-50">
                                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{route('index')}}">{{$data->category_name}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{substr($data->product_name,0,20).' ...'}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                {{-- {{dd($data->product_images)}} --}}
                <div class="row">
                    <div class="col-12 col-lg-5">
                        <div class="single_product_thumb">
                            <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    @if(count($data->product_images) > 0 ) 
                                        @foreach($data->product_images as $key=>$row)
                                            @if($key < 4)
                                                <li class="@if($key==0) {{'active'}} @endif" data-target="#product_details_slider" data-slide-to="0" style="background-image: url({{asset($row->image)}});">
                                                </li>
                                            @endif
                                        @endforeach
                                    @else 
                                        <li class="active" data-target="#product_details_slider" data-slide-to="0" style="background-image: url({{asset('/frontend/img/product-img/pro-big-1.jpg')}});">
                                        </li>
                                    @endif
                                   
                                </ol>
                                <div class="carousel-inner">
                                    @if(count($data->product_images) > 0 ) 
                                        @foreach($data->product_images as $key=>$row)
                                            @if($key < 4)
                                                <div class="carousel-item @if($key==0) {{'active'}} @endif">
                                                    <a class="gallery_img" href="{{asset($row->image)}}">
                                                        <img class="d-block w-100" src="{{asset($row->image)}}" alt="First slide">
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else 
                                        <div class="carousel-item active">
                                            <a class="gallery_img" href="{{asset('/frontend/img/product-img/pro-big-1.jpg')}}">
                                                <img class="d-block w-100" src="{{asset('/frontend/img/product-img/pro-big-1.jpg')}}" alt="First slide">
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-7">
                        <div class="single_product_desc">
                            <!-- Product Meta Data -->
                            <div class="product-meta-data">
                                <div class="line"></div>
                                <p class="product-price">Rs.{{ $data->sale_price ? $data->sale_price : $data->actual_price  }}</p>
                                <a href="#">
                                    <h6>{{ $data->product_name}}</h6>
                                </a>
                                <!-- Ratings & Review -->
                                <div class="ratings-review mb-15 d-flex align-items-center justify-content-between">
                                    {{-- <div class="ratings">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                    </div> --}}
                                    {{-- <div class="review">
                                        <a href="#">Write A Review</a>
                                    </div> --}}
                                </div>
                                <!-- Avaiable -->
                                <p class="avaibility"><i class="fa fa-circle"></i> In Stock</p>
                            </div>

                            <div class="short_overview my-5">
                                <p>{{ $data->product_desc }}</p>
                            </div>

                            <!-- Add to Cart Form -->
                            <form class="cart clearfix" method="post">
                                {{-- <div class="cart-btn d-flex mb-50">
                                    <p>Qty</p>
                                    <div class="quantity">
                                        <span class="qty-minus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i class="fa fa-caret-down" aria-hidden="true"></i></span>
                                        <input type="number" class="qty-text" id="qty" step="1" min="1" max="300" name="quantity" value="1">
                                        <span class="qty-plus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-caret-up" aria-hidden="true"></i></span>
                                    </div>
                                </div> --}}
                                <button type="button" name="addtocart" value="5" class="btn amado-btn cus-book-now ">Book Now</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product Catagories Area End -->
    </div>
    <!-- ##### Main Content Wrapper End ##### -->

    <!-- ##### Newsletter Area Start ##### -->
    <section class="newsletter-area section-padding-100-0">
        <div class="container">
            <div class="row align-items-center">
                <!-- Newsletter Text -->
                <div class="col-12 col-lg-6 col-xl-7">
                    <div class="newsletter-text mb-100">
                        <h2>Subscribe for a <span>25% Discount</span></h2>
                        <p>Nulla ac convallis lorem, eget euismod nisl. Donec in libero sit amet mi vulputate consectetur. Donec auctor interdum purus, ac finibus massa bibendum nec.</p>
                    </div>
                </div>
                <!-- Newsletter Form -->
                <div class="col-12 col-lg-6 col-xl-5">
                    <div class="newsletter-form mb-100">
                        <form action="#" method="post">
                            <input type="email" name="email" class="nl-email" placeholder="Your E-mail">
                            <input type="submit" value="Subscribe">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="prod-popup" style="display: none;">
        <div class="popup-inner"> 
            <div class="close-btn"><span>x</span></div>
            <form action="#" method="post">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="text" class="form-control" id="first_name" value="" placeholder="First Name" required="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" class="form-control" id="last_name" value="" placeholder="Last Name" required="">
                    </div>
                
                    <div class="col-12 mb-3">
                        <input type="email" class="form-control" id="email" placeholder="Email" value="">
                    </div>
                
                    <div class="col-md-6 mb-3">
                        <input type="number" class="form-control" id="phone_number" min="0" placeholder="Phone No" value="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" class="form-control" id="subject" placeholder="subject" value="">
                    </div>
                    <div class="col-12 mb-3">
                        <textarea name="comment" class="form-control w-100" id="comment" cols="30" rows="10" placeholder="Leave a comment about your order"></textarea>
                    </div>
    
                    <div class="col-12 mb-3">
                        <button type="button" class="submit-button">Book Now</button>
                    </div>
    
                </div>
            </form>
        </div> 
    </div>
    <!-- ##### Newsletter Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    @include('layouts.frontend.footer')
    
@endsection