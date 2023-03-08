<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Untree.co">
	<link rel="shortcut icon" href="{{asset('/assets_admin/images/favicon-32x32.png')}}" type="image/x-icon">
    <link rel="icon" href="{{asset('/assets_admin/images/favicon-32x32.png')}}" type="image/x-icon">


	<meta name="description" content="" />
	<meta name="keywords" content="bootstrap, bootstrap4" />

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Source+Serif+Pro:wght@400;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('/assets_front/home/css/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{asset('/assets_front/home/css/owl.theme.default.min.css')}}">
	<link rel="stylesheet" href="{{asset('/assets_front/home/css/jquery.fancybox.min.css')}}">
	<link rel="stylesheet" href="{{asset('/assets_front/home/fonts/icomoon/style.css')}}">
	<link rel="stylesheet" href="{{asset('/assets_front/home/fonts/flaticon/font/flaticon.css')}}">
	<link rel="stylesheet" href="{{asset('/assets_front/home/css/daterangepicker.css')}}">
	<link rel="stylesheet" href="{{asset('/assets_front/home/css/aos.css')}}">
	@if (App::getLocale()=='en')
        <link rel="stylesheet" href="{{asset('/assets_front/home/css/style-eng.css')}}">
        <link rel="stylesheet" href="{{asset('/assets_front/home/css/bootstrap.min.css')}}">
    @else
        <link rel="stylesheet" href="{{asset('/assets_front/home/css/style.css')}}">
        <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.5.3/css/bootstrap.min.css" integrity="sha384-JvExCACAZcHNJEc7156QaHXTnQL3hQBixvj5RV5buE7vgnNEzzskDtx9NQ4p6BJe" crossorigin="anonymous">
    @endif
	<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />

	<title>{{  env('APP_NAME') }}</title>
</head>

<body>


	<div class="site-mobile-menu site-navbar-target">
		<div class="site-mobile-menu-header">
			<div class="site-mobile-menu-close">
				<span class="icofont-close js-menu-toggle"></span>
			</div>
		</div>
		<div class="site-mobile-menu-body"></div>
	</div>

		<!-- <div class="circle-bg1 animate__animated animate__fadeIn"></div>
		<div class="circle-bg2 animate__animated animate__fadeIn"></div>
		<div class="circle-bg3 animate__animated animate__fadeIn"></div>
		<div class="logo-div  animate__animated animate__bounceIn">
<img src="{{asset('/assets_front/img/logo.png')}}">
{{-- {!! QrCode::size(100)->generate('test'); !!} --}}
</div> -->

<!-- <div class="body-bg"></div> -->
	<div class="login-form d-flex align-items-center">
        <div class="container">
            <?php //print_r(session()->get('signup'));exit; ?>
            @if(!session()->has('signup'))
            <div class="row justify-content-md-center">
                <div class="col-md-5 text-center">
                    <img src="{{asset('/assets_front/img/logo.png')}}">
{{-- {!! QrCode::size(100)->generate('test'); !!} --}}
                    <div class="row">
                        <div class="col-sm-12 mt-3 radius-10 bg-white pt-4 shadow">
                            <div class="title">
                              <h3> {{ __('app.Sign_Up') }} </h3>
                            </div>
                            <form action="{{route('register')}}" class="mt-5" method="post" autocomplete="off">
                            @csrf
                                <div class="form-group border-0 p-0">
                            <div class="input-group direction-ltr">
                              <div class="input-group-prepend">
                                    <span class="input-group-text direction-ltr" id="basic-addon1"> <img src="{{asset('/assets_admin/images/saudi_arabia.png')}}" height="30" width="30"><span class="border-end country-code px-2 direction-ltr">+966</span></span>
                                </div>
                                    <input class="otp form-control direction-ltr" type="text" style="height: 50px;" maxlength=9 style="" placeholder="{{ __('app.Enter_Your_Number') }}" name="mobile" id="mobile"  oninput='digitValidate(this)'>
                                </div>

                                    @error('mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- <hr class="mt-4"> -->
                                <button class='btn btn-primary btn-block mt-4 mb-4 customBtn'>{{ __('app.Continue') }}</button>
                            </form>                            
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="row justify-content-md-center">
                <div class="col-md-5 text-center">
                    <div class="row">
                        <div class="col-sm-12 mt-5 bg-white radius-10 pt-3">
                            <div class="title">
                              <h3>{{ __('app.Verify_Login')}}</h3>
                              <p>{{ __('app.OTP_Code_One')}} <strong>xxx{{substr(session()->get('signup')['mobile'], -4)}}</strong></p>
                              <p>{{ __('app.OTP_Code_Two')}} <strong><span style="color:#f279a6" id="time">60</span></strong</p>
                            </div>
                            <form action="{{route('otp.verify.new.user')}}" class="mt-5" method="post">       
                                <div class="d-flex otp-input justify-content-center  direction-ltr">                     
                                <input class="otp mr-1" type="text" oninput='digitValidate(this)' onkeyup='tabChange(1)' maxlength=1 >
                                <input class="otp mr-1" type="text" oninput='digitValidate(this)' onkeyup='tabChange(2)' maxlength=1 >
                                <input class="otp mr-1" type="text" oninput='digitValidate(this)' onkeyup='tabChange(3)' maxlength=1 >
                                <input class="otp mr-1" type="text" oninput='digitValidate(this)'onkeyup='tabChange(4)' maxlength=1 >
                                </div>
                                @error('mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                @error('otp')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                @if(session()->has('success'))
                                    <span class="text-success">{{ session()->get('success') }}</span>
                                @endif
                                @csrf
                                <input type="hidden" name="otp" id="otp" />
                                <input type="hidden" name="mobile" id="mobile" value="{{session()->get('signup')['mobile']}}" />
                                <input type="hidden" name="user_id" id="user_id" value="{{ session()->get('signup')['otp']['user_id'] }}" />
                                <hr class="mt-4">
                                <p id="resend" style="display:none">{{ __('app.Receive_Code')}} <a href="{{route('otp.resend')}}"  style="color:#f279a6">{{ __('app.Resend_Code')}}</a></p>
                                <button class='btn btn-primary btn-block mt-4 mb-4 customBtn'>{{ __('app.Verify_Code')}}</button>
                            </form>                            
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
	</div>
    <style>
        .form-group {
  border: 1px solid #ced4da;
  padding: 5px;
  border-radius: 6px;
  width: auto;
}
.form-group:focus {
  color: #212529;
    background-color: #fff;
    border-color: #86b7fe;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgb(13 110 253 / 25%);
}
.form-group input {
  display: inline-block;
  width: auto;
  border: none;
}
.form-group input:focus {
  box-shadow: none;
}
    </style>
	<script src="{{asset('/assets_front/home/js/jquery-3.4.1.min.js')}}"></script>
	<script src="{{asset('/assets_front/home/js/popper.min.js')}}"></script>
	<script src="{{asset('/assets_front/home/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('/assets_front/home/js/owl.carousel.min.js')}}"></script>
	<script src="{{asset('/assets_front/home/js/jquery.animateNumber.min.js')}}"></script>
	<script src="{{asset('/assets_front/home/js/jquery.waypoints.min.js')}}"></script>
	<script src="{{asset('/assets_front/home/js/jquery.fancybox.min.js')}}"></script>
	<script src="{{asset('/assets_front/home/js/aos.js')}}"></script>
	<script src="{{asset('/assets_front/home/js/moment.min.js')}}"></script>
	<script src="{{asset('/assets_front/home/js/daterangepicker.js')}}"></script>

	<script src="{{asset('/assets_front/home/js/typed.js')}}"></script>
    

	<script>
		let digitValidate = function(ele){
            console.log(ele.value);
            ele.value = ele.value.replace(/[^0-9]/g,'');
        }

        let tabChange = function(val){
            let ele = document.querySelectorAll('input');
            if(ele[val-1].value != ''){
                ele[val].focus();
                if(val == 4)
                {
                    var otp = ele[val-4].value+ele[val-3].value+ele[val-2].value+ele[val-1].value
                    $("#otp").val(otp);
                }
            }else if(ele[val-1].value == ''){
                ele[val-2].focus();
                if(val == 4)
                {
                    var otp = ele[val-4].value+ele[val-3].value+ele[val-2].value+ele[val-1].value
                    $("#otp").val(otp);
                }
            }
        }

        var counter = 60;
        var interval = setInterval(function() {
            counter--;
            // Display 'counter' wherever you want to display it.
            if (counter <= 0) {
                $('#time').text(0);
                clearInterval(interval);
                $('#resend').show();  
                return;
            }else{
                $('#resend').hide();
                $('#time').text(counter);
            //console.log("Timer --> " + counter);
            }
        }, 1000);

        /*
        $(document).ready(function() {
            $("#signup_form").validate({
                rules: {
                    mobile : {
                        required: true,
                    },
                },
                messages : {
                    mobile: {
                        required : "This is required"
                    },
                }
            });
        });
        */
       
	</script>

	<script src="{{asset('/assets_front/home/js/custom.js')}}"></script>

</body>

</html>
