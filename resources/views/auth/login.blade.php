@extends('layouts.app_login')

@section('content')
<style>
    .align-center {
        margin: 0 auto;
    }
</style>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <div class="logo-box">
                <div class="logo"><a href="#"><img src="{{asset('/assets_front/img/logo.png')}}" alt=""></a></div>
            </div>
        </div>
    
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Admin login</p>
                @if($errors->any())
                    <div class="alert alert-danger">{{$errors->first()}}</div>
                @endif
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <form action="{{ route('ck_login') }}" method="post">
                    @csrf()
                        <div class="input-group mb-3">
                            <input name="email" type="email" class="form-control" placeholder="Email">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                        </div>
                        <div class="input-group mb-3">
                            <input name="password" type="password" class="form-control" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember">
                                    <label for="remember">
                                    Remember Me
                                    </label>
                                </div>
                            </div> --}}
                        
                        <div class="col-4 align-center">
                            <button type="submit" class=" btn btn-primary btn-block">Sign In</button>
                        </div>
                    
                    </div>
                </form>
                <!--div class="social-auth-links text-center mb-3">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-primary">
                    <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                    <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                    </a>
                </div-->
            
                {{-- <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p> --}}
                
            </div>
        
        </div>
    </div>
@endsection
