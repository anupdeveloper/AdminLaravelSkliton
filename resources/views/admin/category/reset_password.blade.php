
@extends('admin.layouts.layout')

@section('content')
<div class="container">


    <h1>{{ __('api.admin.User.labels.reset_password') }}</h1>

    <!-- if there are creation errors, they will show here -->
    <form action="{{ route('admin.resetpassword') }}" method="POST" enctype="multipart/form-data">
        {{@csrf_field()}}
        <div class="row">

                


            <div class="col-lg-12">
                <div class="form-group">
                    <label for="email">{{ __('api.admin.User.labels.password') }}</label>
                    <input type="text" class="form-control" name="password" id="email" value="{{Request::old('password')}}">
                    @error('email')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>

            {{-- <div class="col-lg-12">
                <div class="form-group">
                    <label for="mobile">{{ __('api.admin.User.labels.mobile') }}</label>
                    <input type="text" class="form-control" name="mobile" id="mobile" value="{{Request::old('mobile')}}">
                    @error('mobile')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>

 --}}


            
            <div class="col-lg-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Reset password</button>
                </div>
            </div>

        </div>
    </form>

</div>

@endsection

<script>
    // CKEDITOR.replace('description1')
</script>

