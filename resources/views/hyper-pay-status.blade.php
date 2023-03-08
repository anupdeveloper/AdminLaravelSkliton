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
                        <p>{{ Session::get('error') }}</p>
                        <div class="link-btn">
                            <a href="{{ $subscryption_pay }}" class="theme-btn btn-style-one"><span class="btn-title">{{ __('hyper_pay.checkout.try_again') }}</span></a>
                        </div>
                    </div>
                
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
<!-- Page Title -->


@endsection