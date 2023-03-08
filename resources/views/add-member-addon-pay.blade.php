@extends('layouts.app_header')

@section('content')
<style>
    .btn-style-one .btn-title {
         padding: 9px 40px;
    }
    .wpwl-form {
        margin:30px 0;
    }
</style>
<!-- Page Title -->
<section class="page-title">
    <div class="auto-container">
        <div class="content-box">
            @if (\Session::has('success') or \Session::has('error') )
                <div class="content-wrapper">
                    <div class="title">
                        <h1>Payment Confirmation</h1>
                    </div>
                    <ul class="bread-crumb clearfix">
                        <li>Payment Confirmation</li>
                    </ul>
                </div> 
            @else
                <div class="content-wrapper">
                    <div class="title">
                        <h1>Awaser Paynow</h1>
                    </div>
                    <ul class="bread-crumb clearfix">
                        <li>Awaser Paynow</li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</section>
<!-- Page Title -->

<!-- Pricing Section -->
<section class="pricing-section">
    <div class="auto-container">
                    
        <div class="pricing-content">
            <!-- Tab panes -->
            @if (\Session::has('success'))
            <div class="row">
                <div class="col-md-12 text-center d-flex align-items-center justify-content-center" style="min-height: 200px;">
                    <div class="payment-message success">
                        <span class="success-icon icon mb-5 rounded-circle"><i class="bi bi-check2"></i></span> 

                        <h2 class="fw-bold">Payment Completed Successfully</h2>

                        <div class="link-btn">
                            <a href="example://awaser/TabNavigator" class="theme-btn btn-style-one"><span class="btn-title">Start With Awaser</span></a>
                        </div>
                    </div>
                
                </div>
            </div>
            @elseif(\Session::has('error'))
            <div class="row">
                <div class="col-md-12 text-center d-flex align-items-center justify-content-center" style="min-height: 200px;">
                    <div class="payment-message failure">
                        <span class="success-icon icon mb-5 rounded-circle"><i class="bi bi-x-lg"></i></span> 

                        <h2 class="fw-bold">Payment Failed to complete</h2>

                        <div class="link-btn">
                            <a class="theme-btn btn-style-one"><span class="btn-title">Try Again</span></a>
                        </div>
                    </div>
                
                </div>
            </div>
            @else
                <div class="row">
                    
                    <div class="col-md-6 mx-auto">
                        <div class="pricing-block">
                            <div class="">
                                @if(env('SANDBOX_MODE') == true)
                                    @php 
                                    $url = "https://eu-prod.oppwa.com";
                                    @endphp
                                @else 
                                    @php 
                                    $url = "https://test.oppwa.com";
                                    @endphp
                                @endif
                               
                                <script src="{{ $url }}/v1/paymentWidgets.js?checkoutId={{ $checkout->id }}"></script>
                                <form
                                    action="{{ route('user.pay.subscription') }}"
                                    class="paymentWidgets"
                                    data-brands="{{ $brand }}"
                                    method="POST"
                                ></form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
          
                    
                
        </div>

    </div>
</section>
{{-- <script>
    var redirectToApp = function() {
      var scheme = "Awaser";
      var openURL = "awaser" + window.location.pathname + window.location.search + window.location.hash;
      var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
      var Android = /Android/.test(navigator.userAgent);
      var newLocation;
      if (iOS) {
        newLocation = scheme + ":" + openURL;
      } else if (Android) {
        newLocation = "intent://" + openURL + "#Intent;scheme=" + scheme + ";package=com.awaser;end";
      } else {
        newLocation = scheme + "://" + openURL;
      }
      console.log(newLocation)
      window.location.replace(newLocation);
    }
    window.onload = redirectToApp;
  </script> --}}
@endsection