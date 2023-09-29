
@extends('admin.layouts.layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">{{ $page_title }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        {{-- <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard v1</li>
        </ol> --}}
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="container-fluid">


    <!-- if there are creation errors, they will show here -->
    <form action="{{  route('admin.user.update',['id'=>$data['id']]) }}" method="POST" enctype="multipart/form-data" >
        @method('PATCH')
        @csrf
        <div class="row">
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{ old('name', $data->name) }}" class="form-control">
                    @error('name')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="mobile">Phone</label>
                    <input type="text" name="mobile" value="{{ old('mobile', $data->mobile) }}" class="form-control">
                    @error('mobile')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="alt_mobile">Alt. Phone</label>
                    <input type="text" name="alt_mobile" value="{{ old('alt_mobile', $data->customer_detail->alt_mobile) }}" class="form-control">
                    @error('alt_mobile')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" value="{{ old('email', $data->email) }}" class="form-control">
                    @error('email')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="user_type">User Type</label>
                <select class="form-control" name="user_type" id="user_type">
                    <option value="">--SELECT--</option>
                    @if(isset($user_types) && $user_types)
                        @foreach($user_types as $row)
                            <option @if($row == $data['user_type']) {{ 'selected' }} @endif value="{{$row}}">{{strtoupper(str_replace('_',' ',$row))}}</option>
                        @endforeach 
                    @endif
                </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="user_type">Product Type</label>
                <select class="form-control" name="product_type" id="product_type">
                    <option value="">--SELECT--</option>
                    @if(isset($product_type) && $product_type)
                        @foreach($product_type as $row)
                            <option @if($data->customer_detail->product_type == $row) selected  @endif value="{{$row}}">{{strtoupper(str_replace('_',' ',$row))}}</option>
                        @endforeach 
                    @endif
                </select>
                </div>
            </div>
            <div class="col-md-6 amc_module">
                <div class="form-group">
                <label for="user_type">AMC Duration</label>
                <select class="form-control" name="amc_duration" id="amc_duration">
                    <option value="">--SELECT--</option>
                    @if(isset($amc_duration) && $amc_duration)
                        @foreach($amc_duration as $row)
                            <option @if($data->customer_detail->amc_duration == $row) selected  @endif value="{{$row}}">{{strtoupper(str_replace('_',' ',$row))}} Years</option>
                        @endforeach 
                    @endif
                </select>
                </div>
            </div>
            <div class="col-md-6 amc_module">
                <div class="form-group">
                <label for="user_type">No. Of Service</label>
                <select class="form-control" name="amc_no_services" id="amc_no_services">
                    <option value="">--SELECT--</option>
                    
                    @for($i = 1; $i<7; $i++)
                        <option @if($data->customer_detail->no_services == $i) selected  @endif value="{{$i}}">{{strtoupper(str_replace('_',' ',$i))}}</option>
                    @endfor 
                    
                </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="model_taken">Model Taken</label>
                    <input type="text" name="model_taken" value="{{$data->customer_detail->model_taken}}" class="form-control">
                    @error('model_taken')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="username">UserName</label>
                    <input type="text" name="username" readonly value="{{$data['username']}}" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" value="{{$data['address']}}" class="form-control">
                    @error('address')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password">Update Password</label>
                    <input type="text" name="password" value="{{$data['password']}}" class="form-control">
                    @error('password')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="form-group">
                    <label for="category_name">Upload Image</label>
                    <input type="file" multiple name="image[]" value="" class="form-control">
                   
                </div>
            </div> --}}
            {{-- <div class="col-md-6">
                <div class="form-group">
                    <label for="category_name">Category Name</label>
                    <input type="text" name="category_name" value="" class="form-control">
                    @error('category_name')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div> --}}
        </div>
        <div class="row">
            <div class="col-md-6">
                
                <button type="submit" class="btn btn-primary">Save</button>
                
            </div>

        </div>
    </form>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    @if($data['user_type'] != 'amc_user')
    $('.amc_module').hide();
    @endif
   
    $("#user_type").on('change', function(){   
        if($(this).val() == 'amc_user') {
            $("#amc_duration").prop('required',true);
            $("#amc_no_services").prop('required',true);
            $('.amc_module').show();

        } else {
            $("#amc_duration").prop('required',false);
            $("#amc_no_services").prop('required',false);
            $('.amc_module').hide();
        }
    });
</script>
@endsection

<script>
    //CKEDITOR.replace('description1')
</script>

