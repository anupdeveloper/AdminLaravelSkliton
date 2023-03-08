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
    <link rel="stylesheet" href="{{asset('/assets_front/home/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets_front/home/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets_front/home/css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets_front/home/css/jquery.fancybox.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets_front/home/fonts/icomoon/style.css')}}">
    <link rel="stylesheet" href="{{asset('/assets_front/home/fonts/flaticon/font/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('/assets_front/home/css/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{asset('/assets_front/home/css/aos.css')}}">
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
    <script src="{{asset('/assets_front/home/js/jquery-3.4.1.min.js')}}"></script>
    <title>Awaser</title>
    <style>
        body {
            direction: ltr;
        }

        /*.form-control,
        .custom-select {
            text-align: left;
        }*/
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
    </div> 
    <div class="body-bg"></div>
-->

    
    <div class="login-form" style="max-height: 100%;">
        <div class="container">
            @if(session()->has('login_success'))
            <div class="row justify-content-md-center">
                <div class="col-sm-12 col-md-10">
                    <div class="row">
                        <div class="col-sm-10 mx-auto radius-10 bg-white py-3 px-2 px-md-4 py-md-5 my-5">
                            <div class="text-center">
                            <!-- <img src="{{asset('/assets_front/img/logo.png')}}"> -->
                            <h2 class="title mt-0 text-dark">
                                Registration
                            </h2>
                        </div>
                            <form action="{{route('submit_complete_registration')}}" class="mt-3" method="post" autocomplete="off" id="complete_registration" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="nationality">Nationality</label>
                                    <select class="form-control selectpicker" id="nationality" name="nationality_id" required>
                                        <option value="">Select Nationality</option>
                                        @foreach ($countries as $key => $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <select class="form-control selectpicker" id="country" name="resident_country_id" required>
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $key => $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="region">Region</label>
                                    <select class="form-control selectpicker" id="region" name="region_id" required>
                                        <option value="">Select Country</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <select class="form-control selectpicker" id="city" name="city" required>
                                        <option value="">Select Region</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="bio">Bio</label>
                                    <textarea class="form-control" id="bio" name="bio" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="family_country">Family Country</label>
                                    <select class="form-control selectpicker" id="family_country" name="family_origin_id" required>
                                        <option value="">Select Family Counrty</option>
                                        @foreach ($countries as $key => $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="family_region">Family Region</label>
                                    <select class="form-control selectpicker" id="family_region" name="family_region" required>
                                        <option value="">Select Family Country</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="family_city">Family City</label>
                                    <select class="form-control selectpicker" id="family_city" name="family_city" required>
                                        <option value="">Select Family Region</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="currently_married">Currently Married</label>
                                    <select class="form-control selectpicker" id="currently_married" name="currently_married" required>
                                        <option value="">Select Current Marital Status</option>
                                        <option value="0">Not Married</option>
                                        <option value="1">Married</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="marital_status">Married Previously</label>
                                    <select class="form-control selectpicker" id="marital_status" name="married_previously" required>
                                        <option value="">Select Previous Marital Status</option>
                                        <option value="0">Not Married</option>
                                        <option value="1">Married</option>
                                    </select>
                                </div>
                                <div class="form-group" style="display: none;">
                                    <label for="children_number">Children Number</label>
                                    <select class="form-control selectpicker" id="children_number" name="children_id">
                                        <option value="0">No Children</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="height">Height(CM)</label>
                                    <input type="number" class="form-control height" id="height" name="height" placeholder="Height" required>
                                </div>
                                <div class="form-group">
                                    <label for="skin_color">Skin Color</label>
                                    <select class="form-control selectpicker" id="skin_color" name="skin_color_id" required>
                                        <option value="">Select Skin Color</option>
                                        @foreach ($skinColors as $key => $value)
                                        <option value="{{$value->id}}">{{$value->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="body_appearance">Body Appearance</label>
                                    <textarea class="form-control" id="body_appearance" name="body_appearance" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="educational_background">Educational Background</label>
                                    <select class="form-control selectpicker" id="educational_background" name="education_id" required>
                                        <option value="">Select Educational Background</option>
                                        @foreach ($educationBackgrounds as $key => $value)
                                        <option value="{{$value->id}}">{{$value->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="work_type">Work Type</label>
                                    <select class="form-control selectpicker" id="work_type" name="work_id" required>
                                        <option value="">Select Work Type</option>
                                        @foreach ($workTypes as $key => $value)
                                        <option value="{{$value->id}}">{{$value->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sect">Sect</label>
                                    <select class="form-control selectpicker" id="sect" name="do_you_allow_talking_before_marriage" required>
                                        <option value="">Select Sect</option>
                                        @foreach ($sects as $key => $value)
                                        <option value="{{$value->id}}">{{$value->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="smoking_habit">Smoking Habit</label>
                                    <select class="form-control selectpicker" id="smoking_habit" name="smoking" required>
                                        <option value="">Select Smoking Habit</option>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                        <option value="2">Sometimes</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tribe_status">Tribal Status</label>
                                    <select class="form-control selectpicker" id="tribe_status" name="is_your_family_tribal" required>
                                        <option value="">Select Tribal Status</option>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                                <div class="form-group" style="display: none;">
                                    <label for="tribe_id">Tribal Group</label>
                                    <select class="form-control selectpicker" id="tribe_id" name="tribe_id">
                                        <option value="">Select Tribal</option>
                                        @foreach ($tribes as $key => $value)
                                        <option value="{{$value->id}}">{{$value->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="care_tribal">Care for Tribal</label>
                                    <select class="form-control selectpicker" id="care_tribal" name="care_tribal" required>
                                        <option value="">Select Care for Tribal</option>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="hijab_type">Necessary Hijab Type</label>
                                    <select class="form-control selectpicker" id="hijab_type" name="hijab_type_id" required>
                                        <option value="">Select Hijaab Type</option>
                                        @foreach ($hijabTypes as $key => $value)
                                        <option value="{{$value->id}}">{{$value->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span>Personality Dimension</span>
                                @foreach ($personalityDimensions as $key => $value)
                                <div class="form-group">
                                    <label>{{$value->left_title_en}}</label>
                                    <input type="number" max="5" class="form-control" name="personality_dimensions[{{$value->id}}]">
                                </div>
                                @endforeach
                                <div class="form-group">
                                    <label for="pictures">Pictures</label>
                                    <input type="file" class="form-control" name="pictures[]" multiple accept="image/*">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block mt-5 mb-4 w-100">Submit</button>
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
    <script src="{{asset('/assets_front/home/js/custom.js')}}"></script>
    <script src="{{asset('/assets_front/dev/js/registration.js')}}"></script>
</body>

</html>