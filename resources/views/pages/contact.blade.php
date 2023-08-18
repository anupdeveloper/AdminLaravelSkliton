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

        <div class="cart-table-area contact-page section-padding-100">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="cart-title mt-50">
                            <h2>Send Us A Message</h2>
                            <p>Do you have any questions? Please do not hesitate to contact us directly. Our team will come back to you within a matter of hours to help you.</p>
                        </div>

                        <div class="form">
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
                                    <div class="col-6 mb-3">
                                        <input type="text" class="form-control" id="subject" placeholder="subject" value="">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <textarea name="comment" class="form-control w-100" id="comment" cols="30" rows="10" placeholder="Leave a comment about your order"></textarea>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <button type="button" class="submit-button">Submit</button>
                                    </div>

                                </div>
                            </form>
    
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 cus-con-form">
                        <ul class="list-unstyled mb-0">
                            <li><i class="fa fa-map-marker" aria-hidden="true"></i>
                                <p>San Francisco, CA 94126, USA</p>
                            </li>
            
                            <li><i class="fa fa-phone" aria-hidden="true"></i>
                            </i>
                                <p><a href="tel:+01 234 567 89">+ 01 234 567 89</a></p>
                            </li>
            
                            <li><i class="fa fa-envelope-o" aria-hidden="true"></i>
                                <p><a href="mailto:contact@mdbootstrap.com">contact@mdbootstrap.com</a></p>
                            </li>
                        </ul>
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
                        <h2>{{$data->page_name}}</h2>
                        <p>{{$data->page_heading}}</p>
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