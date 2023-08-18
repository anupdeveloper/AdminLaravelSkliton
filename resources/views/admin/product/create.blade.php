
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
    <form action="{{  route('admin.product.save') }}" method="POST" enctype="multipart/form-data" >
        @method('POST')
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                <label for="category_name">Category Name</label>
                <select onchange="category_change(this.value);" class="form-control" name="category_id" id="category_id">
                    <option value="">--SELECT--</option>
                    @if(isset($categories) && $categories)
                        @foreach($categories as $row)
                            <option value="{{$row->id}}">{{$row->category_name}}</option>
                        @endforeach 
                    @endif
                </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" name="product_name" value="" class="form-control">
                    @error('product_name')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="product_name">Product Description</label>
                    <textarea name="product_desc" class="form-control"></textarea>
                    @error('product_name')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="actual_price">Actual Price</label>
                    <input type="text" name="actual_price" value="" class="form-control">
                    @error('actual_price')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sale_price">Sale Price</label>
                    <input type="text" name="sale_price" value="" class="form-control">
                    @error('sale_price')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div id="amc_block" style="display: none" >
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_of_service">No Of Service</label>
                            <input type="text" name="no_of_service" value="" class="form-control">
                            @error('no_of_service')
                            <div><small class="text-danger">{{$message}}</small></div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price_per_service">Price Per Service</label>
                            <input type="text" name="price_per_service" value="" class="form-control">
                            @error('price_per_service')
                            <div><small class="text-danger">{{$message}}</small></div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="category_name">Upload Image</label>
                    <input type="file" name="image1" value="" class="form-control">
                    <small>Best view image size (723 X 747)</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="category_name">Upload Image</label>
                    <input type="file" name="image2" value="" class="form-control">
                    <small>Best view image size (723 X 747)</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="category_name">Upload Image</label>
                    <input type="file" name="image3" value="" class="form-control">
                    <small>Best view image size (723 X 747)</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="category_name">Upload Image</label>
                    <input type="file" name="image4" value="" class="form-control">
                    <small>Best view image size (723 X 747)</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="category_name">Upload Image</label>
                    <input type="file" name="image5" value="" class="form-control">
                    <small>Best view image size (723 X 747)</small>
                </div>
            </div>
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
    function category_change(val)
    {
        //alert('hhh')
        //val = 'normaluu';
        if(val == '5') {
            $('#amc_block').show();
        } else {
            $('#amc_block').hide();
        }
    }
</script>

