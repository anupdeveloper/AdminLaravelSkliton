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
    <!-- <link rel="stylesheet" href="{{asset('/assets_front/home/css/style.css')}}"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://ZulNs.github.io/w3css/w3.css">
    @if (App::getLocale()=='en')
        <link rel="stylesheet" href="{{asset('/assets_front/home/css/style-eng.css')}}">
        <link rel="stylesheet" href="{{asset('/assets_front/home/css/bootstrap.min.css')}}">
    @else
        <link rel="stylesheet" href="{{asset('/assets_front/home/css/style.css')}}">
        <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.5.3/css/bootstrap.min.css" integrity="sha384-JvExCACAZcHNJEc7156QaHXTnQL3hQBixvj5RV5buE7vgnNEzzskDtx9NQ4p6BJe" crossorigin="anonymous">
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <title>{{  env('APP_NAME') }}</title>
    <style>
        body {
            direction: ltr;
        }

        /*.form-control,
        .custom-select {
            text-align: left;
        }*/

        form input[type=radio] {
            width: auto !important;
            height: auto !important;
        }

        .zulns-datepicker {
            z-index: 999;
        }
        select option{
            z-index: -1;
        }
    </style>
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
    <div class="login-form d-flex align-items-center hints-section">
        
        
        <div class="container">
            @if(session()->has('login_success'))
            <div class="row justify-content-md-center">
                <div class="col-sm-12 col-md-10">
                    <div class="row">
                        <div class="col-sm-10 mx-auto bg-white pt-3 px-2 px-md-4 pt-md-5 mt-5 radius-10" style="margin-bottom: 200px;">
                            <h3 class="title mt-0 text-dark text-center">
                            {{ __('app.Sign_Up') }}
                            </h3>
                            <form action="{{route('set_user_info')}}" class="mt-5" method="post" autocomplete="off">
                            </h3>                            
                                @csrf
                                <div class="form-group no-radio">
                                    <h5>{{ __('app.Select_Account_Type')}} <small class="required">*</small></h5>
                                    <div class="form-check form-check-inline hint-btn1" data-toggle="tooltip" data-placement="top" title="{{__('app.Account_Type_Modal_Three')}}">
                                            <input type="radio" class="form-check-input position-static" name="account_type_id" id="individual" value="2" @if(old('account_type_id') == 2) checked @endif @if(old('account_type_id') == 1) @else checked @endif>
                                        <label class="form-check-label border py-2 px-4 radius-10" for="individual"> <i class="bi bi-person mr-2"></i> {{ __('app.Individual')}}
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline hint-btn2" data-toggle="tooltip" data-placement="top" title="{{__('app.Account_Type_Modal_Two')}}">
                                            <input type="radio" class="form-check-input" name="account_type_id" id="family" value="1" @if(old('account_type_id') == 1) checked @endif>
                                        <label class="form-check-label border py-2 px-4 radius-10" for="family"><i class="bi bi-people mr-2"></i> {{ __('app.Family')}}
                                        </label>
                                    </div>
                                   <a href="javascript:void(0);" class="demo-again color-1" data-toggle="tooltip" data-placement="top" title="{{__('app.Account_Type')}}"> <i class="bi bi-info-circle-fill"></i> </a>
                                </div>
                                @error('account_type_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror

                                @if(!old('account_type_id'))
                                <div class="position-relative">
                                <div class="overlay-hints"></div>
                                    <div class="radius-10 border bg-white hint-message hint3 px-3 py-2">
                                        <h5 class="mt-3"><i class="bi bi-info-circle"></i> {{__('app.Account_Type')}} :</h5>
                                        <p class="mb-0">{{__('app.Account_Type_Modal_One')}}</p>
                                        <div class="d-flex justify-content-end">
                                            <a href="javascript:void(0);" class="border px-4 py-2 rounded-pill d-inline-block next3 next-hint mt-2 mb-2"> {{__('app.Next')}} <i class="bi bi-chevron-double-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="radius-10 border bg-white hint-message hint1 px-3 py-2">
                                        <p class="mb-0">{{__('app.Account_Type_Modal_Three')}}</p>
                                        <div class="d-flex justify-content-end">
                                            <a href="javascript:void(0);" class="border px-4 py-2 rounded-pill d-inline-block next1 next-hint mt-2 mb-2"> {{__('app.Next')}}<i class="bi bi-chevron-double-right"></i></a>
                                        </div>
                                    </div>

                                    <div class="radius-10 border bg-white hint-message hint2 px-3 py-2">
                                        <p class="mb-0">{{__('app.Account_Type_Modal_Two')}}</p>
                                        <div class="d-flex justify-content-end">
                                            <a href="javascript:void(0);" class="border px-4 py-2 rounded-pill d-inline-block next2 next-hint mt-2 mb-2r">{{__('app.Ok_Got_It!')}} <i class="bi bi-chevron-double-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="row">
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" id="name_txt">{{ __('app.Your_Name')}} <small class="required">*</small></label>
                                    <label for="name" id="name_f_txt" style="display:none">{{ __('app.Family_Name')}} <small class="required">*</small></label>
                                    <div class="input-icon">
                                    <i class="bi bi-person mr-2"></i>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('app.Enter_Your_Name')}}" value="{{ old('name') }}" placeholder="Enter your name" maxlength="20">
                                    </div>
                                    <span class="text-dark"><small>{{ __('app.Your_Name_Note')}}</small></span><br>
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>                                
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">{{ __('app.Your_UserName')}} <small class="required">*</small></label>
                                    <div class="input-icon">
                                    <i class="bi bi-person mr-2"></i>
                                    <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" placeholder="@ {{ __('app.Enter_Your_UserName')}}"  maxlength="20">
                                    </div>
                                    <span class="text-dark"><small>{{ __('app.Your_UserName_Note')}}</small></span><br>
                                    @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>                                
                                </div>
                                <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">{{ __('app.Your_Email')}} <small class="required">*</small></label>
                                    <div class="input-icon">
                                        <i class="bi bi-envelope"></i>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="{{ __('app.Enter_Your_Email')}}" value="{{ old('email') }}">
                                </div>
                                <!-- <span class="text-dark"><small>{{ __('app.Your_Name_Note')}}</small></span><br> -->
                                <span class="text-dark" id="e_text" style="display:none"><small></small></span><br>
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>                                
                                </div>
                            </div>

                                <div class="row" id="dob_div" @if(old('account_type_id') == 1) style="display:none" @else @endif>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gregDate">{{ __('app.Your_DOB')}} <small>({{ __('app.Gregorian')}})</small> <small class="required">*</small></label>
                                            <!-- <input type="text" name="dob" id="gregDate" onclick="pickDate(event)" class="form-control"> -->
                                        <div class="input-icon">
                                        <i class="bi bi-calendar"></i>
                                            <input type="text" name="dob" id="gregDate" onclick="pickDate(event)" class="form-control" placeholder="{{ __('app.Gregorian')}}" value="{{ old('dob') }}">
                                        </div>
                                        <span class="text-dark"><small>{{ __('app.Age_Public')}}</small></span>
                                        <span class="text-danger dob" style="display:none"></span>
                                        <span class="text-dark dob_correct" style="display:none"></span>
                                        <br>
                                        @error('dob')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        </div>                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="hijrDate">{{ __('app.Hijri')}}</label>
                                    <div class="input-icon">
                                        <i class="bi bi-calendar"></i>
                                            <input type="text" name="hijrDate" id="hijrDate" onclick="pickDate(event)" class="form-control" placeholder="{{ __('app.Hijri')}}" value="{{ old('hijrDate') }}">
                                        </div>
                                        </div>
                                        @error('hijrDate')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group" id="gender_div" @if(old('account_type_id') == 1) style="display:none" @else style="display:block" @endif>
                                    <label for="gender">{{ __('app.Your_Gender')}} <small class="required">*</small></label>
                                    <select class="form-control selectpicker" id="gender" name="gender" required>
                                        <option>{{ __('app.Gender')}}</option>
                                        <option value="male" @if(old('gender') == 'male') selected @endif>{{ __('app.Male')}}</option>
                                        <option value="female" @if(old('gender') == 'female') selected @endif>{{ __('app.Female')}}</option>
                                    </select>
                                    @error('gender')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                

                                <div class="">
                                    <div class="form-check form-check-inline">
                                            <!-- <input type="checkbox" class="form-check-input position-static" id="terms" value="2"> -->
                                        <label class="form-check-label rounded" for="terms">
                                        @if (App::getLocale()=='en')
                                            By clicking finish up registration you agree to our <a target="_blank" href="{{URL::to('/terms-conditions')}}">Terms & Conditions</a>
                                        @else
                                            بالنقر على إكمال التسجيل فإنك توافق على <a target="_blank" href="{{URL::to('/terms-conditions')}}">الشروط والأحكام</a>
                                        @endif
                                        </label>
                                    </div>
                                </div>
                                <button class='btn btn-primary btn-block mt-4 mb-4 customBtn'>{{ __('app.Finish_Up_Registeration')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="row justify-content-md-center">
                <div class="col-md-4 text-center">
                    <div class="row bg-white">
                        <p>Please try registering from the start</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <input type="hidden" id="Family_Members_Age" value="{{ __('app.Family_Members_Age')}}" />
    <input type="hidden" id="Years_Old_Error" value="{{ __('app.Years_Old_Error')}}" />
    <input type="hidden" id="Years_Old_Error_Sub" value="{{ __('app.Years_Old_Error_Sub')}}" />
    <input type="hidden" id="Years_Old" value="{{ __('app.Years_Old')}}" />
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
    <script src="https://ZulNs.github.io/HijriDate.js/hijri-date.js"></script>
    <script src="https://ZulNs.github.io/Datepicker.js/datepicker.js"></script>
    <script type="text/javascript">
        
        $(document).ready(function(){
            $(".hint2").hide();
             $(".hint1").hide();
             $(".next3").click(function(){
            $(".hint-btn1").addClass("hint-highlite");
            $(".hint3").fadeOut();
            $(".hint1").fadeIn();
           });
             $(".demo-again").click(function(){
            $(".hint3").fadeIn();
            $(".overlay-hints").fadeIn();
           });
           $(".next1").click(function(){
            $(".hint-btn1").removeClass("hint-highlite");
            $(".hint-btn2").addClass("hint-highlite");
            $(".hint1").hide();
            $(".hint2").fadeIn();
           });
           $(".next2").click(function(){
            $(".hint-btn2").removeClass("hint-highlite");
            $(".hint-btn1").removeClass("hint-highlite");
            $(".hint2").fadeOut();
            $(".overlay-hints").fadeOut();
            $(".loign-form").removeClass("hints-section");
           });
       });
    </script>
    <script>
        let digitValidate = function(ele) {
            console.log(ele.value);
            ele.value = ele.value.replace(/[^0-9]/g, '');
        }

        let tabChange = function(val) {
            let ele = document.querySelectorAll('input');
            if (ele[val - 1].value != '') {
                ele[val].focus();
                if (val == 4) {
                    var otp = ele[val - 4].value + ele[val - 3].value + ele[val - 2].value + ele[val - 1].value
                    $("#otp").val(otp);
                }
            } else if (ele[val - 1].value == '') {
                ele[val - 2].focus();
                if (val == 4) {
                    var otp = ele[val - 4].value + ele[val - 3].value + ele[val - 2].value + ele[val - 1].value
                    $("#otp").val(otp);
                }
            }
        }

        'use strict';
        let picker = new Datepicker();
        picker.setFullYear(1990)
        picker.setMonth(0)
        picker.setTheme(4)
        picker.setLanguage('<?=App::getLocale()?>')
        let pickElm = picker.getElement();
        let pLeft = 200;
        let pWidth = 300;
        pickElm.style.position = 'absolute';
        pickElm.style.left = pLeft + 'px';
        pickElm.style.top = '172px';
        picker.attachTo(document.body);

        picker.onPicked = function() {
            let elgd = document.getElementById('gregDate');
            let elhd = document.getElementById('hijrDate');
            if (picker.getPickedDate() instanceof Date) {
                const date = new Date(picker.getPickedDate());

                ageMS = Date.parse(Date()) - Date.parse(date);
                age = new Date();
                age.setTime(ageMS);
                ageYear = age.getFullYear() - 1970;
                if(ageYear < 18)
                {
                    var Years_Old_Error_Sub = $("#Years_Old_Error_Sub").val();
                    var Years_Old_Error = $("#Years_Old_Error").val();
                    var Years_Old_Error = Years_Old_Error.replace("00", ageYear);
                    const age_text = '<br><strong>'+Years_Old_Error+'</strong><p><small>'+Years_Old_Error_Sub+'</small</p>';
                    $('.dob').show();
                    $('.dob').html(age_text);
                    $('.dob_correct').hide();
                    elgd.value = null;
                }
                else
                {
                    elgd.value = date.getFullYear() + '-' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate()));
                    $('.dob').hide();
                    var Years_Old = $("#Years_Old").val();
                    var Years_Old = Years_Old.replace("00", ageYear);
                    const age_text = '<br><strong>'+Years_Old+'</strong>';
                    $('.dob_correct').show();
                    $('.dob_correct').html(age_text);
                }                
                elhd.value = picker.getOppositePickedDate().getDateString()
            } else {
                elhd.value = picker.getPickedDate().getDateString();
                //elgd.value = picker.getOppositePickedDate().getDateString();
                const date = new Date(picker.getOppositePickedDate());
                ageMS = Date.parse(Date()) - Date.parse(date);
                age = new Date();
                age.setTime(ageMS);
                ageYear = age.getFullYear() - 1970;
                if(ageYear < 18)
                {
                    var Years_Old_Error_Sub = $("#Years_Old_Error_Sub").val();
                    var Years_Old_Error = $("#Years_Old_Error").val();
                    var Years_Old_Error = Years_Old_Error.replace("00", ageYear);
                    const age_text = '<br><strong>'+Years_Old_Error+'</strong><p><small>'+Years_Old_Error_Sub+'</small</p>';
                    $('.dob').show();
                    $('.dob_correct').hide();
                    $('.dob').html(age_text);
                    elgd.value = null;
                }
                else
                {
                    elgd.value = date.getFullYear() + '-' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate()));
                    $('.dob').hide();
                    var Years_Old = $("#Years_Old").val();
                    var Years_Old = Years_Old.replace("00", ageYear);
                    const age_text = '<br><strong>'+Years_Old+'</strong>';
                    $('.dob_correct').show();
                    $('.dob_correct').html(age_text);
                }                
            }
        };

        function openSidebar() {
            document.getElementById("mySidebar").style.display = "block"
        }

        function closeSidebar() {
            document.getElementById("mySidebar").style.display = "none"
        }

        function dropdown(el) {
            if (el.className.indexOf('expanded') == -1) {
                el.className = el.className.replace('collapsed', 'expanded');
            } else {
                el.className = el.className.replace('expanded', 'collapsed');
            }
        }

        function selectLang(el) {
            el.children[0].checked = true;
            picker.setLanguage(el.children[0].value)
        }

        function setFirstDay(fd) {
            picker.setFirstDayOfWeek(fd)
        }

        function setYear() {
            let el = document.getElementById('valYear');
            picker.setFullYear(el.value)
        }

        function setMonth() {
            let el = document.getElementById('valMonth');
            picker.setMonth(el.value)
        }

        function updateWidth(el) {
            pWidth = parseInt(el.value);
            if (!fixWidth()) {
                document.getElementById('valWidth').value = pWidth;
                picker.setWidth(pWidth)
            }
        }

        function pickDate(ev) {
            ev = ev || window.event;
            let el = ev.target || ev.srcElement;
            pLeft = ev.pageX;
            fixWidth();
            pickElm.style.top = ev.pageY + 'px';
            picker.setHijriMode(el.id == 'hijrDate');
            picker.show();
            el.blur()
        }

        function gotoToday() {
            picker.today()
        }

        function setTheme() {
            let el = document.getElementById('txtTheme');
            let n = parseInt(el.value);
            if (!isNaN(n)) picker.setTheme(n);
            else picker.setTheme(el.value)
        }

        function newTheme() {
            picker.setTheme()
        }

        function fixWidth() {
            let docWidth = document.body.offsetWidth;
            let isFixed = false;
            if (pLeft + pWidth > docWidth) pLeft = docWidth - pWidth;
            if (docWidth >= 992 && pLeft < 200) pLeft = 200;
            else if (docWidth < 992 && pLeft < 0) pLeft = 0;
            if (pLeft + pWidth > docWidth) {
                pWidth = docWidth - pLeft;
                picker.setWidth(pWidth);
                document.getElementById('valWidth').value = pWidth;
                document.getElementById('sliderWidth').value = pWidth;
                isFixed = true
            }
            pickElm.style.left = pLeft + 'px';
            return isFixed
        }
    </script>

    <script src="{{asset('/assets_front/home/js/custom.js')}}"></script>
    <script type="text/javascript">
        $(document).mouseup(function(e) 
        {
            var container = $(".zulns-datepicker");

            if (!container.is(e.target) && container.has(e.target).length === 0) 
            {
                container.addClass("w3-hide");
                container.find(".w3-white").html("");
            }
        });

        $('#name').keyup(function(event){
            let res = /^[\u0621-\u064Aa-zA-Z0-9 ]+$/.test($(this).val());
            var key = event.key;
            if(!res)
            {
                var val = toEnglishNumber($(this).val())
                $(this).val(val)
            }
        });

        function toEnglishNumber(strNum) {
            var ar = '٠١٢٣٤٥٦٧٨٩'.split('');
            var en = '0123456789'.split('');
            strNum = strNum.replace(/[٠١٢٣٤٥٦٧٨٩]/g, x => en[ar.indexOf(x)]);
            //strNum = strNum.replace(/[^\d]/g, '');
            return strNum;
        }

        $('#username').keyup(function(){
            let res = /^[a-zA-Z0-9@]+$/.test($(this).val());
            if(!res)
            {
                $(this).val('');
            } else {
                    //alert($(this).val().charAt(0));
                    if($(this).val().charAt(0) != '@') {
                        $(this).val( '@' + $(this).val()  );
                    }
            }
            
        });

        $('#email').keyup(function(){
            if($(this).val() != null) {
                let res = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test($(this).val());
                if(!res)
                {
                    console.log('failed')
                    $('#email').css('border-color', 'red');
                } else {
                    console.log('success')
                    $('#email').css('border-color', '');
                }
            }
            
        });

        $("input[name='account_type_id']").change(function(){
        if( $(this).is(":checked") ){
            var val = $(this).val();
            if(val==1)
            {
                var Family_Members_Age = $('#Family_Members_Age').val();
                $('#e_text').show();
                $('#e_text').html("<small>"+Family_Members_Age+"</small>");
                $("#gender_div").hide();
                $("#dob_div").hide();
                $("#name_txt").hide();
                $("#name_f_txt").show();
            }
            else
            {
                $("#gender_div").show();
                $("#dob_div").show();
                $('#e_text').hide();
                $("#name_txt").show();
                $("#name_f_txt").hide();
            }
        }
    });
    </script>
    <style>
        small.required{
            color:red;
        }
        .w3-text-red, .w3-hover-text-red:hover
        {
            color: #000!important;
        }

        .w3-light-grey, .w3-hover-light-grey:hover, .w3-light-gray, .w3-hover-light-gray:hover {
            color: #000!important;
            background-color: #f1f1f1!important;
        }

        .w3-hover-text-red:hover
        {
            background-color: #616161!important;
        }
        .w3-red, .w3-hover-red:hover {
            color: #fff!important;
            background-color: #616161!important;
        }
    </style>
</body>

</html>