
@extends('admin.layouts.layout')

@section('content')
<style>
    hr.bar {
        border-width: 2px;
        margin: 25px 0;
    }
</style>
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

    <form action="{{  route('admin.lead.import') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row" style="align-items: flex-end;">
            <div class="col-md-6">
                <label for="users">Upload Leads</label>
                <input type="file" class="form-control" style="padding: 3px;" name="leads" required />
                <small>upload a xlsx file</small>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-success" name="upload">Upload</button>
            </div>
        </div>
            
    </form>
    <hr class="bar"/>
    <!-- if there are creation errors, they will show here -->
    <form action="{{  route('admin.lead.save') }}" method="POST" enctype="multipart/form-data" >
        @method('POST')
        @csrf
        <div class="row">
            {{-- <div class="col-md-6">
                <div class="form-group">
                <label for="category_name">Category Name</label>
                <select class="form-control" name="category_id" id="category_id">
                    <option value="">--SELECT--</option>
                    @if(isset($categories) && $categories)
                        @foreach($categories as $row)
                            <option value="{{$row->id}}">{{$row->category_name}}</option>
                        @endforeach 
                    @endif
                </select>
                </div>
            </div> --}}
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Customer Name</label>
                    <input type="text" name="name" value="" class="form-control">
                    @error('name')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" value="" class="form-control">
                    @error('phone')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" value="" class="form-control">
                    @error('email')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" value="" class="form-control">
                    @error('address')
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

@endsection

<script>
    //CKEDITOR.replace('description1')
</script>

