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

	<title>{{  env('APP_NAME') }}</title>
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
		<div class="animate__animated animate__bounceIn text-center position-relative" style="z-index: 999;"><img src="{{asset('/assets_front/img/logo.png')}}"></div>
		<div class="body-bg"></div>

		<div class="container bg-white radius-10 py-5 px-4 shadow" style="position: relative;z-index: 999; margin: 50px auto 200px auto;border-radius: 10px;text-align: right;direction: rtl;">
		<h2 class="mb-5">?????????? ??? ???????????? ????????????????</h2>
		<p>??????????: ?????????? "??????????" ???? ?????????? ?????????? ?????????????? ???????? ?????????? ???????????????????? ???? ???????????????? ???????????????? ?????????????? ???????????????? ???????????? ???? ?????? ???????????? .?????? ?????????????? ?????????? ?????????? ?????????? ???????????? ???????????????????? ???? ?????????????? ?????????????? ?????????????????? ?????????? ?????????????? ?????? ????????????????????  ???????? ?????????? ???????????? ???????????????? ?????? ???????????????? ???????????????? ??????????????. ?????????????? ?????????????????? ???????????????? ???????? ???????????????? ?????? ???????????? ????????????????. </p>
		<h4>?????????????? ??????????????????:</h4>
		<ul>
			<li>???????? ???????????????? ???????? ???????? ???????????? ???????????????? ?????????? "??????????"?? ???????? ?????? ???????? ???????? ???????????????? ?????? ???????? ????????. </li>
			<li>???? ?????? ???????????????? ?????? ?????????? ???? ???????? ?????????????? ???????? ???????????????? ???? ?????? ?????? ?????? ?????? ??????. </li>
			<li>
			?????????? ?????????? (?????? ?????????????? ??????????????) ?????????? ?????????????? ?????????????? ???????? ???????? ?????? ???????????? ???????????? ?????????????? ?????? ?????????? ???? ?????????? ???????????????? ?????? ???????? ?????????? ???????????????? ?????? ??????.
			</li>
		</ul>
		<h4>??????????????????: </h4>
		<ul>
			<li>?????????? "??????????" ???????? ???????? ???????????????? ???? ???? ???????? ???????????? ?????? ???????? ???????????????? ???? ?????? ?????????????? ????????????????????. ?????????? ?????????? ???????????????? ?????????????? ?????????? ???????????????? ?????????????? ?????????????????? ?????? ?????????? "??????????" ?????????????? ?????????????? ?????????????? ???? ?????? ?????????? ?????????????? ????????????????. </li>
			<li>?????????? ???????????????? ???????????????? ???????? ???????????????? ???????? ???????? ?????????????????? ???????????? ???????? ?????????????? ?????????????????? ???????????????????? ???????????????? ???? ?????? ???????????? ???????? ?????? ?????????? "??????????" ?????????? ???????????????? ???????? ????????????.</li>
			<li>?????????? "??????????" ???????? ???????? ?????????????? ?????????????????? ???????????? ???? ?????? ???????????? ???????? ???? ?????????? ?????????????? </li>
		</ul>
		<h4>?????????????????? ????????????????: ?????????? ???????????????? ???????? ???????? ?????? ???????? ?????????? ???????? ???????????? ???????????????? ???????? ???????? ???????????? ???? ??????????:</h4>
		<ul>
			<li>?????????????? ???????????????????? ???????????????? ?????? ???????? ???? ?????????? ???? ???????????? ???????????? ???? ?????????????? ?????????????? ???? ???????????? ???? ?????? ?????? ???? ?????????????????? ???????????????? ????????????????. </li>
			<li>
			?????????????? ?????????? ?????????????? ?????????????? ???????? ?????????????? ???????????????? ?????? ??????????????. </li>
			<li>
			?????????? ???????? ???????????? ???? ???????????? ???????? ???????????? ???? ???????????? ???? ?????????????? ???? ?????? ????????????????. </li>
			<li>
			?????? ?????????????? ???????????? ?????? ???????????????????? ?????? ?????????? ???? ?????????????? ???? ?????? ???????????? ?????? ?????????????????? ??????????????. 
			?????????? ???????????? ?????????????? ?????????????? ???? ?????????????????? ???????????? ?????????????? ?????????????? ?????????? ???????? ???? ???????? ??????????.
			</li>
		</ul>
		<h4>?????????????????? ??????????????????:</h4>
		<ul>
			<li>"??????????" ???????? ???????????? ???? ???? ?????????? ???? ?????????????? ???????? ?????????????? ???? ?????? ????????????????????. </li>
			<li>
			?????? ???????????? ?????? ???? ?????????? ???? ???????? ???? ?????????? ???????? ???????? ???? ?????????? ?????????? ???? ?????????? ?????? ?????? ???????????? ?????????? ???????????????????? ???? ???????? ???? ?????? ?????????? ?????? ?????????? ?????????????? ???? ???????? ?????????? ???????????? ???????????????? ????????????????. </li>
			<li>
			???? ???????? "??????????" ???? ???????????? ???? ???????????? ???? ???? ?????? ???????? ?????????????? ???????????? ?????????????? ???? ?????????? ????????????????????. 
			</li>
		</ul>
		<h4>????????????????:</h4>
		<ul>
			<li>???????? "??????????" ???????? ???????? ?????????????? ?????????????????????? ?????????????? ???????? ???????????? ???????? ?????????????? ???????? ???????? ???? ???????? ???????? ???????? ?????? ?????????? ?????????????????? ????????????. </li>
			<li>
			?????? ???????????????? ?????????????? ???????????????????? ?????????? ???????????? ?????????????? ???????????? ???????? ???????????? ?????? ???????????? ???????????????????? ?????? ???? "??????????" ???? ???????? ?????? ?????????? ???????????????????? ???????????????? ???????????? ???? ?????????????? ???? ???????????? ???? ???????? ?????? ???????? ???? ???????????? ???? ?????? ?????? ???? ???????? ???? ???? ?????????? ????????. 
			</li>
		</ul>
		<h4>?????????? ???????????? ????????????: </h4>
		<ul>
			<li>?????????? "??????????" ?????????? ???????????? ???? ?????????? ???????????? ???????????????? ???? ???? ?????? ?????????? ???????????? ?????????????????? ???????? ?????? ?????????????? ???? ???????? ??????????????. </li>
			<li>
			???????????? ?????????????? ?????????????????? ?????????????? ?????? ?????????? ?????????????? ???????????? ???????????????? ?????????????? ???? ???????????????? ?????????????????? ?????? ???????????? ?????????????? ???? ???????????? ???????????????? ?????? ??????????. 
			</li>
		</ul>
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
