@extends('layouts.app_header')

@section('content')
@if(App::getlocale()=='en')
<style>
    .btn-style-one .btn-title {
         padding: 9px 40px;
    }
    .pay-section input[type="radio"]{
        opacity: 0;
        position: absolute;
    }
    .pay-section label{
        padding:15px 0px 15px 50px;
        border-radius: 10px;
        cursor:pointer;
    }
    .pay-section label:before{
        content:"";
        position: absolute;
        top:20px;
        left: 30px;
        height: 20px;
        width:20px;
        border-radius: 50%;
        background:#ddd;
    }
    .pay-section input[type="radio"]:checked + label{
        border:1px solid #1d1f5a !important;
        color:#1d1f5a !important;
        background:#f3f3f7;
    }
    .pay-section input[type="radio"]:checked + label:before{
        background:#1d1f5a;
    }

    .small-text {
        font-size: 15px !important;
        font-style: italic;
    }
    .note{
        text-align: left;
        font-style: italic;
        text-transform: lowercase;
        font-size: 14px;
        color: darkgray;
    }
    .pay-logo {
        width: 30%;
    }
</style>
@else
<style>
    .btn-style-one .btn-title {
         padding: 9px 40px;
    }
    .pay-section input[type="radio"]{
        opacity: 0;
        position: absolute;
    }
    .pay-section label{
        padding:15px 50px 15px 0;
        border-radius: 10px;
        cursor:pointer;
    }
    .pay-section label:before{
        content:"";
        position: absolute;
        top:20px;
        right: 30px;
        height: 20px;
        width:20px;
        border-radius: 50%;
        background:#ddd;
    }
    .pay-section input[type="radio"]:checked + label{
        border:1px solid #1d1f5a !important;
        color:#1d1f5a !important;
        background:#f3f3f7;
    }
    .pay-section input[type="radio"]:checked + label:before{
        background:#1d1f5a;
    }

    .small-text {
        font-size: 15px !important;
        font-style: italic;
    }
    .note{
        text-align: left;
        font-style: italic;
        text-transform: lowercase;
        font-size: 14px;
        color: darkgray;
    }
    .pay-logo {
        width: 30%;
    }
</style>
@endif
<!-- Page Title -->
<section class="page-title">
    <div class="auto-container">
        <div class="content-box">
            @if (\Session::has('success') or \Session::has('error') )
                <div class="content-wrapper">
                    <div class="title">
                        <h1>{{ __('hyper_pay.checkout.payment_confirmation') }}</h1>
                    </div>
                    <ul class="bread-crumb clearfix">
                        <li>{{ __('hyper_pay.checkout.payment_confirmation') }}</li>
                    </ul>
                    <p>{{ Session::get('error') }}</p>
                </div> 
            @else
                <div class="content-wrapper">
                    <div class="title">
                        <h1>{{ __('hyper_pay.checkout.checkout_title') }}</h1>
                        <p>{{ Session::get('error') }}</p>
                    </div>
                    <!-- <ul class="bread-crumb clearfix">
                        <li>{{ __('hyper_pay.checkout.checkout_title') }}</li>
                    </ul> -->
                </div>
            @endif
        </div>
    </div>
</section>
<!-- Page Title -->

<!-- Pricing Section -->
<section class="pricing-section my-5">
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
                    <div class="col-md-5">
                        <div class="pricing-block">
                            <div class="inner-box border">
                                <div class="top-content">
                                    <div class="row m-0 justify-content-center">
                                        <!-- <div class="category">Basic Pack</div> -->
                                        <div class="price">{{ __('hyper_pay.checkout.summary') }}</div>
                                    </div>
                                </div>
                                <div class="lower-content">
                                    <h5 id="summary_package_name">@if(App::getlocale()=='ar') {{$package_detail->name_ar }} @else {{$package_detail->name }} @endif</h5>
                                    <h4 id="summary_package_desc">@if(App::getlocale()=='ar') {{$package_detail->description_ar }} @else {{$package_detail->description }} @endif</h4>
                                    <ul>
                                        <li class="d-flex justify-content-between"><span>{{ __('hyper_pay.checkout.plan_duration') }}</span><strong id="summary_package_duration">{{ trans('hyper_pay.checkout.subscription_months',['attribute'=>$package_detail->duration]) }}</strong></li>
                                        <li  class="d-flex justify-content-between"><span>{{ __('hyper_pay.checkout.type_of_account') }}</span><strong>
                                            @if(App::getlocale()=='ar') {{$package_detail->account_name_ar }} @else {{$package_detail->account_name }}
                                            @endif
                                        </strong></li>
                                        @if($package_detail->account_type_id == 1)
                                        <li class="d-flex justify-content-between"><span>{{ __('hyper_pay.checkout.member_included') }}</span><strong>{{ $member_no }}</strong></li> 
                                        @endif
                                        <li class="d-flex justify-content-between"><span>{{ __('hyper_pay.checkout.sub_total') }}</span><strong>{{ $total_cost }} {{ __('hyper_pay.checkout.saudi_currency') }}</strong></li>   
                                        <li class="d-flex justify-content-between small-text"><span>{{ __('hyper_pay.checkout.vat') }}({{ $vat_detail->vat_percentage }}%)</span><strong>{{ $total_vat_cost }} {{ __('hyper_pay.checkout.saudi_currency') }}</strong></li>                                             
                                        <li class="d-flex justify-content-between"><span>{{ __('hyper_pay.checkout.total_amt') }}</span><strong>{{ $total_pay_cost }} {{ __('hyper_pay.checkout.saudi_currency') }}</strong>
                                        </li>                                             
                                        
                                    </ul>
                                    <p class="note">{{ __('hyper_pay.checkout.vat_no') }}  {{$vat_detail->vat_no}}</p>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="pricing-block ">
                            <div class="">
                                {{-- <script src="{{ $checkout->getData()->script_url }}"></script>
                                <form
                                    action="{{$checkout->getData()->shopperResultUrl}}"
                                    class="paymentWidgets"
                                    data-brands="VISA MASTER MADA APPLEPAY"
                                ></form> --}}
                                {{-- <div class="hint"><span>*</span> This is a one time payment and it will expire after 3 months</div> --}}
                                <form action="{{ route('user.pay.subscription') }}" method="post">
                                    @csrf
                                    <h5 class="mt-sm-0  mt-4">{{ __('hyper_pay.checkout.select_payment_method') }}</h5>
                                   
                                    <div class="row mt-4">
                                        {{-- <div class="pay-section col-sm-4">
                                        <input type="radio" name="brand" value="APPLEPAY" id="apple" /> 
                                        <label for="apple" class="border w-100">{{ __('hyper_pay.checkout.appple_apy') }}
                                        <img class="pay-logo" src="{{asset('/images/payment/apple-logo.png')}}" />
                                        </label>
                                        </div> --}}
                                        @if($env == 'production')
                                            <div class="pay-section col-sm-4">
                                                <input checked type="radio" name="brand" value="MADA" id="mada" /> 
                                                <label for="mada" class="border w-100">{{ __('hyper_pay.checkout.mada') }} 
                                                <img class="pay-logo" src="{{asset('/images/payment/mada-logo.png')}}" />
                                                </label>
                                            </div>
                                        @else
                                        
                                            <div class="pay-section col-sm-4">
                                                <input checked type="radio" name="brand" value="VISA" id="visa" /> 
                                                <label for="visa" class="border w-100">{{ __('hyper_pay.checkout.visa') }}</label>
                                            </div>
                                        @endif
                                        
                                        
                                    </div>
                                    <div class="crad-detail">
                                        {{-- <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label>Card No</label>
                                                    <input type="text" placeholder="Card No" class="form-control" name="card_number" />
                                                </div>
                                            </div>
                                        </div> --}}
                                        {{-- <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Month</label>
                                                    <input type="text" placeholder="MM" class="form-control" name="expiry_month" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Year</label>
                                                    <input type="text" placeholder="YYYY" class="form-control" name="expiry_year" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>CVV</label>
                                                    <input type="text" placeholder="CVV" class="form-control" name="card_cvv" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label>Holder Name</label>
                                                    <input type="text" class="form-control" name="holder_name" />
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <input type="hidden" id="member_cost" name="member_cost" value="{{ $member_cost }}">
                                    <input type="hidden" id="member_no" name="member_no" value="{{ $member_no }}">
                                    <input type="hidden" name="user_token" value="{{ $user_token }}" />
                                    <input type="hidden" type="radio" name="package_id" id="package_id" value="{{ $package_detail->id }}">
                                    <div class="link-btn">
                                        <button class="theme-btn btn-style-one"><span class="btn-title">{{ __('hyper_pay.checkout.pay_now') }}</span></button>
                                    </div>
                                </form>
                                
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