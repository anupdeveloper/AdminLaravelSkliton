@extends('layouts.app_header')

@section('content')
<style>
    .btn-style-one .btn-title {
         padding: 9px 40px;
    }
    .note{
        text-align: left;
        font-style: italic;
        text-transform: lowercase;
        font-size: 14px;
        color: darkgray;
    }
</style>
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
                </div> 
            @else
                <div class="content-wrapper">
                    <div class="title">
                        <h1>{{ __('hyper_pay.checkout.checkout_title') }}</h1>
                        <p>{{ Session::get('error') }}</p>
                    </div>
                    <ul class="bread-crumb clearfix">
                        <li>{{ __('hyper_pay.checkout.checkout_title') }}</li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</section>
<!-- Page Title -->

<!-- Pricing Section -->
{{-- {{dd(collect(request()->segments())->last())}} --}}
<section class="pricing-section">
    <div class="auto-container">
                    
        <div class="pricing-content">
            <!-- Tab panes -->
            @if (\Session::has('success'))
            <div class="row">
                <div class="col-md-12 text-center d-flex align-items-center justify-content-center" style="min-height: 200px;">
                    <div class="payment-message success">
                        <span class="success-icon icon mb-5 rounded-circle"><i class="bi bi-check2"></i></span> 

                        <h2 class="fw-bold">{{ __('hyper_pay.checkout.payment_success') }}</h2>

                        <div class="link-btn">
                            <a href="example://awaser/TabNavigator" class="theme-btn btn-style-one"><span class="btn-title">{{ __('hyper_pay.checkout.start_with_awaser') }}</span></a>
                        </div>
                    </div>
                
                </div>
            </div>
            @elseif(\Session::has('error'))
            <div class="row">
                <div class="col-md-12 text-center d-flex align-items-center justify-content-center" style="min-height: 200px;">
                    <div class="payment-message failure">
                        <span class="success-icon icon mb-5 rounded-circle"><i class="bi bi-x-lg"></i></span> 

                        <h2 class="fw-bold">{{ __('hyper_pay.checkout.payment_failed') }}</h2>

                        <div class="link-btn">
                            <a href="{{ route('get_subscripton',collect(request()->segments())->last()) }}" class="theme-btn btn-style-one"><span class="btn-title">{{ __('hyper_pay.checkout.try_again') }}</span></a>
                        </div>
                    </div>
                
                </div>
            </div>
            @else
                <div class="row">
                    <div class="col-md-8">
                    {{-- {{ $total_member_added }}     --}}
                          
                        @if($total_member_added<4 && isset($subscription_detail))
                            <div class="pricing-card mb-5">
                                <input type="radio" onclick="select_member_addon(1,{{$subscription_detail}},`{{ trans('hyper_pay.checkout.saudi_currency') }}`);" name="member_addon" id="member_addon_1" value="1">
                                <label class="pricing-label card shadow bg-white no-border mb-0" for="member_addon_1">1 {{ __('hyper_pay.checkout.member') }} ( 1X{{$subscription_detail->member_cost}} ) {{ trans('hyper_pay.checkout.saudi_currency') }} </label>
                                <p class="alert alert-info">1 {{ __('hyper_pay.checkout.member') }} ( 1X{{$subscription_detail->member_cost}} ) {{ trans('hyper_pay.checkout.saudi_currency') }}</p>
                                <div class="title"><h5>1 {{ __('hyper_pay.checkout.member') }} ( 1X{{$subscription_detail->member_cost}} ) {{ trans('hyper_pay.checkout.saudi_currency') }}</h5></div>
                            </div>
                        @endif
                        @if($total_member_added<3 && isset($subscription_detail))
                            <div class="pricing-card mb-5">
                                <input type="radio" onclick="select_member_addon(2,{{$subscription_detail}},`{{ trans('hyper_pay.checkout.saudi_currency') }}`);" name="member_addon" id="member_addon_2" value="2">
                                <label class="pricing-label card shadow bg-white no-border mb-0" for="member_addon_2">2 {{ __('hyper_pay.checkout.member') }} ( 2X{{$subscription_detail->member_cost}} ) {{ trans('hyper_pay.checkout.saudi_currency') }} </label>
                                <p class="alert alert-info">2 {{ __('hyper_pay.checkout.member') }} ( 2X{{$subscription_detail->member_cost}} ) {{ trans('hyper_pay.checkout.saudi_currency') }}</p>
                                <div class="title"><h5>2 {{ __('hyper_pay.checkout.member') }} ( 2X{{$subscription_detail->member_cost}} ) {{ trans('hyper_pay.checkout.saudi_currency') }}</h5></div>
                            </div>
                        @endif
                        @if($total_member_added<2 && isset($subscription_detail))
                            <div class="pricing-card mb-5">
                                <input type="radio" onclick="select_member_addon(3,{{$subscription_detail}},`{{ trans('hyper_pay.checkout.saudi_currency') }}`);" name="member_addon" id="member_addon_3" value="3">
                                <label class="pricing-label card shadow bg-white no-border mb-0" for="member_addon_3">3 {{ __('hyper_pay.checkout.member') }} ( 3X{{$subscription_detail->member_cost}} ) {{ trans('hyper_pay.checkout.saudi_currency') }} </label>
                                <p class="alert alert-info">3 {{ __('hyper_pay.checkout.member') }} ( 3X{{$subscription_detail->member_cost}}) {{ trans('hyper_pay.checkout.saudi_currency') }}</p>
                                <div class="title"><h5>3 {{ __('hyper_pay.checkout.member') }} ( 3X{{$subscription_detail->member_cost}} ) {{ trans('hyper_pay.checkout.saudi_currency') }}</h5></div>
                            </div>
                        @endif

                        {{-- @if($total_member_added<1)
                            <div class="pricing-card mb-5">
                                <input type="radio" onclick="select_member_addon(3,{{$subscription_detail->member_cost}});" name="member_addon" id="member_addon_4" value="3">
                                <label class="pricing-label card shadow bg-white no-border mb-0" for="member_addon_3">4 Member ( 3X{{$subscription_detail->member_cost}} ) SAR </label>
                                <p class="alert alert-info">4 Member ( 3X{{$subscription_detail->member_cost}}) SAR</p>
                                <div class="title"><h5>4 Member ( 3X{{$subscription_detail->member_cost}} ) SAR</h5></div>
                            </div>
                        @endif --}}
                      
                
                </div>
                <div class="col-md-4">
                    <div class="pricing-block" style="display:none;">
                                        <div class="inner-box border">
                                            <div class="top-content">
                                                <div class="row m-0 justify-content-center">
                                                    <!-- <div class="category">Basic Pack</div> -->
                                                    <div class="price">{{ __('hyper_pay.checkout.summary') }}</div>
                                                </div>
                                            </div>
                                            <div class="lower-content">
                                                <h5 id="summary_package_name"></h5>
                                            <h4 id="summary_package_desc"></h4>
                                                <ul>
                                                    <li class="d-flex justify-content-between"><span>{{ __('hyper_pay.checkout.member_included') }}</span><strong id="summary_member_add_on"></strong>
                                                    </li>
                                                    <li class="d-flex justify-content-between"><span>{{ __('hyper_pay.checkout.sub_total') }}</span><strong><span id="summary_sub_amount"></span></strong></li> 
                                                    <li class="d-flex justify-content-between small-text"><span>{{ __('hyper_pay.checkout.vat') }}({{ $vat_detail->vat_percentage }}%)</span><strong><span id="vat_amt"></span></strong></li> 
                                                    <li class="d-flex justify-content-between"><span>{{ __('hyper_pay.checkout.total_amt') }}</span><strong><span id="summary_total_pay_amount"></span></strong></li>                                             
                                                </ul>
                                               
                                                <form action="{{ route('add_member_checkout') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" id="member_cost" name="member_cost">
                                                    <input type="hidden" id="member_add_on" name="member_add_on">
                                                    <input type="hidden" name="user_token" value="{{ $user_token }}"/>
                                                    <div class="link-btn">
                                                        <button class="theme-btn btn-style-one"><span class="btn-title">{{ __('hyper_pay.checkout.procced_to_checkout') }}</span></button>
                                                    </div>
                                                </form>
                                                
                                                {{-- <script src="{{ $checkout->getData()->script_url }}"></script>
                                                <form
                                                    action="{{$checkout->getData()->shopperResultUrl}}"
                                                    class="paymentWidgets"
                                                    data-brands="VISA MASTER MADA APPLEPAY"
                                                ></form> --}}
                                                {{-- <p class="note">{{ __('hyper_pay.checkout.vat_no') }} {{$vat_detail->vat_no}}</p> --}}
                                                {{-- <div class="hint"><span>*</span>{{ __('hyper_pay.checkout.note') }} {{$vat_detail->vat_no}} </div> --}}
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