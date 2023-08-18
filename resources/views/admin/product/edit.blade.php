
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
    <form action="{{  route('admin.product.update',['id'=>$data['id']]) }}" method="POST" enctype="multipart/form-data" >
        @method('PATCH')
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                <label for="category_name">Category Name</label>
                <select onchange="category_change(this.value);" class="form-control" name="category_id" id="category_id">
                    <option value="">--SELECT--</option>
                    @if(isset($categories) && $categories)
                        @foreach($categories as $row)
                            <option @if($row->id == $data['category_id']) {{ 'selected' }} @endif value="{{$row->id}}">{{$row->category_name}}</option>
                        @endforeach 
                    @endif
                </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" name="product_name" value="{{ $data['product_name'] }}" class="form-control">
                    @error('product_name')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="product_name">Product Description</label>
                    <textarea name="product_desc" class="form-control">{{ $data['product_desc'] }}</textarea>
                    @error('product_name')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="actual_price">Actual Price</label>
                    <input type="text" name="actual_price" value="{{ $data['actual_price'] }}" class="form-control">
                    @error('actual_price')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sale_price">Sale Price</label>
                    <input type="text" name="sale_price" value="{{ $data['sale_price'] }}" class="form-control">
                    @error('sale_price')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div id="amc_block" @if($data['category_id'] == 5) style="display: block" @else style="display: none" @endif  >
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_of_service">No Of Service</label>
                            <input type="text" name="no_of_service" value="{{ $data['no_of_service'] }}" class="form-control">
                            @error('no_of_service')
                            <div><small class="text-danger">{{$message}}</small></div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price_per_service">Price Per Service</label>
                            <input type="text" name="price_per_service" value="{{ $data['price_per_service'] }}" class="form-control">
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
                    <input type="file"  name="image1" value="" class="form-control">
                    <input type="hidden" name="old_image1" value="{{isset($data->product_images[0]) ? $data->product_images[0]->image : ''}}" />
                    <input type="hidden" name="old_thumbimage1" value="{{isset($data->product_images[0]) ? $data->product_images[0]->thumbimage : ''}}" />
                    <small>Best view image size (723 X 747)</small>
                </div>
                @if(isset($data->product_images[0]->thumbimage))
                    <img width="40" src="{{asset($data->product_images[0]->thumbimage)}}" />
                @endif
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="category_name">Upload Image</label>
                    <input type="file"  name="image2" value="" class="form-control">
                    <input type="hidden" name="old_image2" value="{{isset($data->product_images[1])?$data->product_images[1]->image:''}}" />
                    <input type="hidden" name="old_thumbimage2" value="{{isset($data->product_images[1]) ? $data->product_images[1]->thumbimage : ''}}" />
                    <small>Best view image size (723 X 747)</small>
                </div>
                @if(isset($data->product_images[1]->thumbimage))
                    <img width="40" src="{{asset($data->product_images[1]->thumbimage)}}" />
                @endif
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="category_name">Upload Image</label>
                    <input type="file"  name="image3" value="" class="form-control">
                    <input type="hidden" name="old_image3" value="{{ isset($data->product_images[2])?$data->product_images[2]->image : ''}}" />
                    <input type="hidden" name="old_thumbimage3" value="{{ isset($data->product_images[2])?$data->product_images[2]->thumbimage : ''}}" />
                    <small>Best view image size (723 X 747)</small>
                </div>
                @if(isset($data->product_images[2]->thumbimage))
                    <img width="40" src="{{asset($data->product_images[2]->thumbimage)}}" />
                @endif
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="category_name">Upload Image</label>
                    <input type="file"  name="image4" value="" class="form-control">
                    <input type="hidden" name="old_image3" value="{{ isset($data->product_images[3])?$data->product_images[3]->image : ''}}" />
                    <input type="hidden" name="old_thumbimage3" value="{{ isset($data->product_images[3])?$data->product_images[3]->thumbimage : ''}}" />
                    <small>Best view image size (723 X 747)</small>
                </div>
                @if(isset($data->product_images[3]->thumbimage))
                    <img width="40" src="{{asset($data->product_images[3]->thumbimage)}}" />
                @endif
            </div>
           
            <div class="col-md-6">
                <div class="form-group">
                    <label for="category_name">Upload Image</label>
                    <input type="file"  name="image5" value="" class="form-control">
                    <input type="hidden" name="old_image3" value="{{ isset($data->product_images[4])?$data->product_images[4]->image : ''}}" />
                    <input type="hidden" name="old_thumbimage3" value="{{ isset($data->product_images[4])?$data->product_images[4]->thumbimage : ''}}" />
                    <small>Best view image size (723 X 747)</small>
                </div>
                @if(isset($data->product_images[4]->thumbimage))
                    <img width="40" src="{{asset($data->product_images[4]->thumbimage)}}" />
                @endif
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
                
                <button type="submit" class="btn btn-primary">Update</button>
                
            </div>

        </div>
    </form>

</div>

@endsection

<script>
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

