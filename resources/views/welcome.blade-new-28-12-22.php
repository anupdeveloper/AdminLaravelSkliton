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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
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

	<title>{{ env('APP_NAME') }}</title>
</head>

<body class="f16">


	<div class="site-mobile-menu site-navbar-target">
		<div class="site-mobile-menu-header">
			<div class="site-mobile-menu-close">
				<span class="icofont-close js-menu-toggle"></span>
			</div>
		</div>
		<div class="site-mobile-menu-body"></div>
	</div>

		<div class="circle-bg1 animate__animated animate__fadeIn"></div>
		<div class="circle-bg2 animate__animated animate__fadeIn"></div>
		<div class="circle-bg3 animate__animated animate__fadeIn"></div>
		<div class="logo-div  animate__animated animate__bounceIn">
<img src="{{asset('/assets_front/img/logo.png')}}">
{{-- {!! QrCode::size(100)->generate('test'); !!} --}}
</div>

<div class="body-bg"></div>
	<div class="hero">
		<div class="container">
			<div class="row text-right">
				<div class="col-lg-7">
					<div class="intro-wrap">
						<h1 class="mb-5">
							<!-- <span class="typed-words"></span> --> 
							<span class="d-block mt-4">{{ __('welcome.welcome.title')}} </span>
						</h1>

						<p class=" animate__animated animate__fadeInUp">{{ __('welcome.welcome.content_0')}}</p>
						<p class=" animate__animated animate__fadeInUp">{{ __('welcome.welcome.content_1')}}</p>
						<p class="dark-bg  animate__animated animate__fadeInUp bld">{{ __('welcome.welcome.content_2')}}</p>
						 <p class="dark-bg">{{ __('welcome.welcome.point_1')}} <a href="{{route('signup')}}" class="color-3"> {{ __('welcome.welcome.signuptxt')}} </a></p>
						 <p class="dark-bg">{{ __('welcome.welcome.point_2')}}</p> 
					</div>
				</div>
				<div class="col-lg-5">
					<div class="slide-img animate__animated animate__fadeInUp">
						<img src="{{asset('/assets_front/home/images/app-screen-2.png')}}" alt="Image" class="img-fluid active">
					</div>
				</div>
			</div>
		</div>
	</div>


	<section class="download-section">
		<div class="container">
			<div class="download-app text-center shadow	">
				<h2 class="mb-5"> {{ __('welcome.welcome.storeheading')}} </h2>
				<div class="col-md-5 mx-auto">
					<div class="row">
						<div class="col-sm-6">
							<a target="_blank" href="https://play.google.com/store/apps/details?id=com.awaser" class="btn btn-outline w-100 rounded mb-sm-0 mb-4"><i class="fa-brands fa-google-play"></i> <span >{{ __('welcome.welcome.playstore')}}</span></a>
						</div>

						<div class="col-sm-6">
							<a target="_blank" href="https://apps.apple.com/us/app/awaser-app/id6444342345" class="btn btn-outline w-100 rounded"><i class="fa-brands fa-app-store-ios"></i> <span >{{ __('welcome.welcome.appstore')}}</span> </a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<!--
	<section class="features-section">
		<div class="container text-center">
				<h2 class="mb-5">الميزات</h2>
            <div class="owl-single owl-carousel no-nav">
              <div class="testimonial mx-auto px-3">
              	<img src="{{asset('/assets_front/home/images/feature-1.jpg')}}" class="shadow rounded">
              </div>

              <div class="testimonial mx-auto px-3">
                <img src="{{asset('/assets_front/home/images/feature-2.jpg')}}" class="shadow rounded">
              </div>

              <div class="testimonial mx-auto px-3">
                <img src="{{asset('/assets_front/home/images/feature-3.jpg')}}" class="shadow rounded">
              </div>

            </div>
		</div>
	</section>
-->

	<div class="untree_co-section" style="direction: rtl;text-align: right;" style="">
		<!-- <img src="images/features-line.png" class="features-line"> -->
    <div class="container">
      <div class="row mb-5 justify-content-center">
        <div class="col-lg-6 text-center">
          <h2 class="section-title text-center mb-3">{{ __('welcome.welcome.feature_13')}}  </h2>
          
        </div>
      </div>
      <div class="row">
      	 
        

      <div class="col-lg-4">
      	 <div class="feature-1">
      	 	<span class="number">1</span>
            <div class="">
              <p class="mb-0">{{ __('welcome.welcome.feature_1')}} </p>
            </div>
          </div>
           <div class="feature-1">
      	 	<span class="number">2</span>
            <div class="align-self-center">
              <p class="mb-0">{{ __('welcome.welcome.feature_2')}} </p>
            </div>
          </div>
          <div class="feature-1">
      	 	<span class="number">3</span>
            <div class="">
              <p class="mb-0">{{ __('welcome.welcome.feature_3')}}</p>
            </div>
          </div>
          <div class="feature-1">
      	 	<span class="number">4</span>
            <div class="">
              <p class="mb-0">{{ __('welcome.welcome.feature_4')}}</p>
            </div>
          </div>
      </div>

        <div class="col-lg-4">
          <div class="h-100"><div class="frame h-100"><div class="feature-img-bg h-100" >
          	<img src="{{asset('/assets_front/home/images/app-screen-2.png')}}" class="w-100">
          </div>
      	</div>
      	</div>
      </div>

      <div class="col-lg-4">
          <div class="feature-1">
      	 	<span class="number">5</span>
            <div class="">
              <p class="mb-0">{{ __('welcome.welcome.feature_5')}} </p>
            </div>
          </div>
          <div class="feature-1">
      	 	<span class="number">6</span>
            <div class="">
              <p class="mb-0">{{ __('welcome.welcome.feature_6')}} </p>
            </div>
          </div>
          <div class="feature-1">
      	 	<span class="number">7</span>
            <div class="">
              <p class="mb-0">{{ __('welcome.welcome.feature_7')}}</p>
            </div>
          </div>

      </div>



      <div class="col-lg-8 mx-auto mt-5">
      	<p class="bg-light text-center p-3 rounded shadow ">
		  {{ __('welcome.welcome.feature_8')}}
      	</p>
      	<h4 class="text-center">{{ __('welcome.welcome.feature_9')}}</h4>
      </div>

	  


      </div>
	  <div class="ftr"> <span>{{ __('welcome.welcome.contactus')}}</span>  : <a href="mailto:info@awaser.sa"></a> info@awaser.sa</div>
    </div>
  </div>
<div class="language"> <a href="{{ URL::to('/language/en') }}" class="eng">English</a>  <a href="{{ URL::to('/language/ar') }}" class="ar">عربي</a> </div>

<div class="signup"> <a href="{{route('signup')}}"> {{ __('welcome.welcome.signuptxt')}} </a> </div>

	<div id="overlayer"></div>
	<div class="loader">
		<div class="spinner-border" role="status">
			<span class="sr-only">Loading...</span>
		</div>
	</div>

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
		$(function() {
			var slides = $('.slides'),
			images = slides.find('img');

			images.each(function(i) {
				$(this).attr('data-id', i + 1);
			})

			var typed = new Typed('.typed-words', {
				strings: ["{{ __('welcome.welcome.soon')}}"],
				typeSpeed: 80,
				backSpeed: 80,
				backDelay: 4000,
				startDelay: 1000,
				loop: true,
				showCursor: true,
				preStringTyped: (arrayPos, self) => {
					arrayPos++;
					console.log(arrayPos);
					$('.slides img').removeClass('active');
					$('.slides img[data-id="'+arrayPos+'"]').addClass('active');
				}

			});
		})
	</script>

	<script src="{{asset('/assets_front/home/js/custom.js')}}"></script>

</body>

</html>
