
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
    <form action="{{  route('admin.page.update',['id'=>$data['id']]) }}" method="POST" enctype="multipart/form-data" >
        @method('POST')
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="category_name">Page Name</label>
                    <input type="text" name="page_name" value="{{ $data->page_name }}" class="form-control">
                    @error('category_name')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="category_name">Page Heading</label>
                    <input type="text" name="page_heading" value="{{ $data->page_heading }}" class="form-control">
                    @error('category_name')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="category_name">Page Content</label>
                    <textarea id="page_content" name="page_content" class="form-control">{{ $data->page_content }}</textarea>
                    @error('category_name')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                
                <button type="submit" class="btn btn-primary">{{ __('api.admin.User.pages.edit.button.update') }}</button>
                
            </div>

        </div>
    </form>

</div>

@endsection

<script>
    CKEDITOR.replace('page_content')
</script>

