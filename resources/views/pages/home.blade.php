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

        <!-- Product Catagories Area Start -->
        <div class="products-catagories-area clearfix">
            <div class="amado-pro-catagory clearfix">

                @if($data)
                    @php
                        $previous = 0; 
                        $current = 1;
                    @endphp
                    @foreach($data as $key=>$row)
                    <!-- Single Catagory -->
                    
                    @php
                        do {
                            $current = rand(1,5);
                            
                        } while ($current == $previous);
                        $previous = $current;
                    @endphp
                    
                    <div class="single-products-catagory bg-color-{{$current}} clearfix">
                        <a href="{{route('product-detail',$row->id)}}">
                            @if(count($row->product_images) > 0 ) 
                            <img width="40" src="{{asset($row->product_images[0]->image)}}" /> 
                            @else
                            <img width="40" src="{{asset('/frontend/img/product-img/no-img.jpg')}}" />
                            @endif
                            <!-- Hover Content -->
                            <div class="hover-content">
                                <div class="line"></div>
                                <p>From Rs.{{ $row->sale_price ? $row->sale_price : $row->actual_price  }}</p>
                                <h2 class="category">{{$row->category_name}}</h2>
                                <h4>{{substr($row->product_name,0,30)}}</h4>
                            </div>
                            <div class="desc">
                                <p>
                                    {{ substr($row->product_desc,0,100). ' ...' }}
                                </p>
                            </div>
                        </a>
                        
                    </div>
                    @endforeach
                @endif

                
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
    <!-- ##### Newsletter Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    @include('layouts.frontend.footer')

@endsection