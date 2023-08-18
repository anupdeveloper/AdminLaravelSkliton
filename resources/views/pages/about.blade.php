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

        
        <div class="cart-table-area About-page section-padding-100">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-lg-8 left-side">
 


            <div class="row about-us-sec">
            <div class="col-12">
            <div class="about mt-50">
                <h2>{{$data->page_name}}</h2>
            <p>{{$data->page_content}}</p>
            </div>
            </div>
        </div>
                       
                {{-- <div class="row our-team">
                    <div class="col-12"> <h2 style="text-align:center">Our Team</h2></div>
                        <div class="col-12 col-lg-4">
                            <div class="card">
                                <img src="{{asset('/frontend/img/core-img/about-us.jpg')}}">
                                <div class="text-block">
                                    <h3>Jane Doe</h3>
                                    <p class="title">CEO & Founder</p>
                                    <p>Some text that describes me lorem ipsum ipsum lorem.</p>
                                    <p>jane@example.com</p>
                                    <p><button class="button">Contact</button></p>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                </div>
                <div class="col-12 col-lg-4 right-side">
                    <div class="profile-detail">
                    <img src="{{asset('/frontend/img/core-img/about-us.jpg')}}">
                    <h3>{{$data->page_name}}</h3>
                    <p>{{$data->page_heading}}</p>
                        <a href="{{route('contact')}}" class="learn-more-btn">Contact us</a>    
                        </div>
                </div>
                </div>
            </div>
        </div>
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
    <!-- ##### Newsletter Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    @include('layouts.frontend.footer')

@endsection