@extends('layouts.app_header')

@section('content')
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
<!-- Page Title -->
<section class="page-title">
    <div class="auto-container">
        <div class="content-box">
            @if (\Session::has('success') or \Session::has('error') )
                <div class="content-wrapper">
                    <div class="title">
                        <h1>{{ trans('hyper_pay.checkout.payment_link_expired',[],$default_language) }}</h1>
                    </div>
                    <!-- <ul class="bread-crumb clearfix">
                        <li>{{ trans('hyper_pay.checkout.payment_link_expired',[],$default_language) }}</li>
                    </ul> -->
                </div> 
            @else
                <div class="content-wrapper">
                    <div class="title">
                        <h1>{{ trans('hyper_pay.checkout.payment_link_expired',[],$default_language) }}</h1>
                    </div>
                    <!-- <ul class="bread-crumb clearfix">
                        <li>{{ trans('hyper_pay.checkout.payment_link_expired',[],$default_language) }}</li>
                    </ul> -->
                </div> 
            @endif
        </div>
    </div>
</section>
<!-- Page Title -->

@endsection