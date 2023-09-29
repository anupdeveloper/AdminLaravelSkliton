
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
    <form action="{{  route('admin.staff.store') }}" method="POST" enctype="multipart/form-data" >
        @method('POST')
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                <label for="user_type">User Type</label>
                <select class="form-control" name="user_type" id="user_type">
                    <option value="">--SELECT--</option>
                    @if(isset($user_types) && $user_types)
                        @foreach($user_types as $row)
                            <option @if(old('user_type') == $row) selected  @endif value="{{$row}}">{{strtoupper(str_replace('_',' ',$row))}}</option>
                        @endforeach 
                    @endif
                </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{old('name')}}" class="form-control">
                    @error('name')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="mobile">Phone</label>
                    <input type="text" name="mobile" value="{{old('mobile')}}" class="form-control">
                    @error('mobile')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" value="{{old('email')}}" class="form-control">
                    @error('email')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" value="{{old('username')}}" class="form-control">
                    @error('username')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" value="{{old('address')}}" class="form-control">
                    @error('address')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" name="password" value="" class="form-control">
                    @error('password')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="form-group">
                    <label for="username">Confirm Password</label>
                    <input type="text" name="username" value="" class="form-control">
                    @error('username')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div> --}}
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

@endsection

<script>
    //CKEDITOR.replace('description1')
</script>

