@extends('layouts.app_header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
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
    .language-translator {
        display: inline-block;
        float: right;
    }

    .disabled {
        background: #dddddd !important;
        cursor: none !important;
    }
    p.subs-info {
        text-align: center;
        font-size: 13px;
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
                    <!-- <ul class="bread-crumb clearfix">
                        <li>{{ __('hyper_pay.checkout.payment_confirmation') }}</li>
                    </ul> -->
                </div> 
            @else
                <div class="content-wrapper">
                    <div class="title">
                        <h1>{{ __('hyper_pay.checkout.checkout_title') }} </h1>
                        <p>{{ Session::get('error') }}</p>
                    </div>
                    <!-- <ul class="bread-crumb clearfix">
                        <li>{{ __('hyper_pay.checkout.checkout_title') }}</li>
                    </ul> -->
                </div>
            @endif
            {{-- <div class="language-translator">
                <ul class="lang-item">
                    <li>
                        <a href="{{ route('changeLanguage',['locale'=>'en']) }}" class="dropdown-item">ENG</a>
                    </li>
                    <li>
                        <a href="{{ route('changeLanguage',['locale'=>'ar']) }}" class="dropdown-item">ARA</a>
                    </li>
                </ul>
            </div> --}}
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
                        <p class="text-dark">{{ __('hyper_pay.checkout.payment_success_desc') }}</p>
                        <div class="col-md-6 col-sm-10 mx-auto">
                    <div class="row">
                        <div class="col-sm-6">
                            <a target="_blank" href="https://play.google.com/store/apps/details?id=com.awaser" class="btn btn-outline w-100 rounded-pill mb-sm-0 mb-4 border bg-light border"><i class="bi bi-google-play"></i> <span >{{ __('welcome.welcome.playstore')}}</span></a>
                        </div>

                        <div class="col-sm-6">
                            <a target="_blank" href="https://apps.apple.com/us/app/awaser-app/id6444342345" class="btn btn-outline w-100 rounded-pill border bg-light"><i class="bi bi-apple"></i> <span >{{ __('welcome.welcome.appstore')}}</span> </a>
                        </div>
                    </div>
                </div>
                        <div class="row">
<div class="col-md-6 mx-auto">
<div class="link-btn">
                            <a href="example://awaser/TabNavigator" class="theme-btn btn-style-one"><span class="btn-title">{{ __('hyper_pay.checkout.start_with_awaser') }}</span></a>
                        </div>
</div>
</div>
                    </div>
                
                </div>
            </div>
            @php(\Session::put('success-redirect', true))
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
                    @if(count($subscription_list)>0)        
                        @foreach($subscription_list as $package)
                            <div class="pricing-card mb-5 ">
                                <input type="radio" @if($package->status == 0) disabled @endif onclick="select_package(`{{$package}}`,{{$vat_detail->vat_percentage}},{{$total_member_added}},`{{trans('hyper_pay.checkout.months')}}`,`{{ trans('hyper_pay.checkout.saudi_currency') }}`,`{{ trans('hyper_pay.checkout.member') }}`);" name="pricing" id="price-{{ $package->id }}" value="{{ $package->id }}">
                                <label class="pricing-label card shadow bg-white no-border mb-0 @if($package->status == 0) disabled @endif" for="price-{{ $package->id }}">
                                {{ trans('hyper_pay.checkout.package_label',['attribute1'=>$package->duration,'attribute2'=>$package->price]) }}
                                @if($package->status == 0)
                                <p class="subs-info">{{ trans('hyper_pay.checkout.currently_not_avaliable') }}</p>
                                @endif
                                </label>
                                
                                <p class="alert alert-info">@if(App::getlocale()=='ar') {{$package->description_ar }} @else {{$package->description }} @endif</p>
                                <div class="title"><h5>@if(App::getlocale()=='ar') {{$package->name_ar }} @else {{$package->name }} @endif</h5></div>
                            </div>
                        @endforeach
                    @endif
                
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
                                                    <li class="d-flex justify-content-between"><span>{{ __('hyper_pay.checkout.plan_duration') }}</span><strong id="summary_package_duration"></strong></li>
                                                    <li  class="d-flex justify-content-between"><span>{{ __('hyper_pay.checkout.type_of_account') }}</span><strong><span id="summary_package_type"></span></strong></li>
                                                    <li  class="d-flex justify-content-between"><span>{{ __('hyper_pay.checkout.price') }}</span><strong><span id="summary_package_price"></span></strong></li>
                                                    @if($account_detail->name == 'Family' && $total_member_added == '0')
                                                    <li class="d-flex justify-content-between"><span> {{ __('hyper_pay.checkout.member_included') }}</span><strong><span class="sel_member_text">{{ $total_member_added}}</span></strong></li>
                                                    @elseif($account_detail->name == 'Family' && $total_member_added != '0')
                                                    <li class="d-flex justify-content-between"><span> {{ __('hyper_pay.checkout.member_included') }}</span><strong><span class="sel_member_text">{{ $total_member_added}}</span></strong></li>
                                                    @endif
                                                    <li class="d-flex justify-content-between"><span>{{ __('hyper_pay.checkout.sub_total') }}</span><strong><span id="summary_package_amount"></span></strong></li> 
                                                   
                                                    <li class="d-flex justify-content-between small-text"><span>{{ __('hyper_pay.checkout.vat') }}({{ $vat_detail->vat_percentage }}%)</span><strong><span id="vat_amt"></span></strong></li>                                  
                                                    <li class="d-flex justify-content-between"><span>{{ __('hyper_pay.checkout.total_amt') }}</span><strong><span id="total_pay_amount"></span></strong></li>
                                                    <li class="d-flex justify-content-between" style="color: #f279a6"><span style="color: #f279a6;font-size:13px">{{ __('hyper_pay.checkout.subscription-hint') }}</span></li>
                                                </ul>                                               
                                                @if($account_detail->name == 'Family' && $total_member_added == 0)
                                                <div class="form-group">
                                                    <strong>{{ __('hyper_pay.checkout.member_included') }} <span class="sel_member_text">1 {{ __('hyper_pay.checkout.free') }}</span></strong>
                                                    <strong><span id="summary_package_member_no"></span></strong>
                                                    <select id="select_member_addon" class="form-control pricing-select mt-3 mb-4">
                                                        <option value="1">{{ __('hyper_pay.checkout.summary') }}<strong>1 Member</strong> ({{ __('hyper_pay.checkout.free') }})</option>
                                                        
                                                    </select>
                                                </div>
                                                @endif
                                                <form action="{{ route('user.checkout.subscription') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" id="vat_per" name="vat_per" value="{{$vat_detail->vat_percentage}}">
                                                    <input type="hidden" id="member_cost" name="member_cost">
                                                    <input type="hidden" id="package_cost" name="package_cost">
                                                    <input type="hidden" id="member_no" name="member_no">
                                                    <input type="hidden" name="user_token" value="{{ $user_token }}"/>
                                                    <input type="hidden" value="" type="radio" name="package_id" id="package_id">
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
                                                {{-- <p class="note">{{ __('hyper_pay.checkout.vat_no') }}  {{$vat_detail->vat_no}}</p> --}}
                                                {{-- <div class="hint"><span>*</span> {{ __('hyper_pay.checkout.note') }}</div> --}}
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