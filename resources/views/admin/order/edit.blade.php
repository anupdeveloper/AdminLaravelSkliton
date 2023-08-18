
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
    <form action="{{  route('admin.order.update',['id'=>$data['id']]) }}" method="POST" enctype="multipart/form-data" >
        @method('PATCH')
        @csrf
        <div class="row">

            <div class="col-md-6">
                
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <tr>
                                <td><label>Order ID</label></td><td><span class="label-text">{{$data['order_id']}}</span></td>
                            </tr>
                            <tr>
                                <td><label>Order Date</label></td><td><span class="label-text">{{$data['created_at']}}</span></td>
                            </tr>
                            <tr>
                                <td><label>Order Amount</label></td><td><span class="label-text">{{$data['total_amt']}}</span></td>
                            </tr>
                            <tr>
                                <td><label>Order Status</label></td>
                                <td>
                                    {{-- <span class="label-text">{{$data['order_status']}}</span> --}}
                                    <select class="form-control" name="order_status" id="order_status">
                                        <option value="">--SELECT--</option>
                                        <option @if($data['order_status'] == 'pending') {{ 'selected' }}  @endif value="pending">Pending</option>
                                        <option @if($data['order_status'] == 'dispatch') {{ 'selected' }}  @endif value="dispatch">Dispatch</option>
                                        <option @if($data['order_status'] == 'denied') {{ 'selected' }}  @endif value="denied">Denied</option>
                                        <option @if($data['order_status'] == 'completed') {{ 'selected' }}  @endif value="completed">Completed</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
               
            </div>
            <div class="col-md-6">
                
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <tr>
                                <td><label>Customer Name</label></td><td><span class="label-text">{{$data['name']}}</span></td>
                            </tr>
                            <tr>
                                <td><label>Contact Number</label></td><td><span class="label-text">{{$data['mobile']}}</span></td>
                            </tr>
                            <tr>
                                <td><label>Address</label></td><td><span class="label-text">{{$data['address']}}</span></td>
                            </tr>
                            
                        </table>
                    </div>
                </div>
                
               
            </div>
            <div class="col-md-12">
                
                
                    <div class="col-md-12">
                       <table class="table">
                        <tr>
                            <th>Product Name</th>
                            <th>Product Image</th>
                            <th>Product Price</th>
                            <th>Quantity</th>
                            <th>Sub Total</th>
                        </tr>
                        @if($data['order_detail'])
                            @php
                               $total = 0; 
                            @endphp
                            @foreach ($data['order_detail'] as $item)
                                @php
                                    $total =  $total + $item->product_qty * $item->product_detail->actual_price; 
                                @endphp
                                <tr>
                                    <td>{{ $item->product_detail->product_name }}</td>
                                    <td>
                                        {{-- {{$item->product_images}} --}}
                                        @if(isset($item->product_images[0]))
                                        <img width="40" src="{{asset($item->product_images[0]->image)}}" />
                                        @endif
                                    </td>
                                    <td>{{ $item->product_detail->actual_price }}</td>
                                    <td>{{ $item->product_qty }}</td>
                                    <td>{{ $item->product_qty * $item->product_detail->actual_price  }}</td>
                                </tr> 

                            @endforeach
                            <tr>
                                <th colspan="4"><span style="text-align: right">Total</span></th>
                                
                                <th>{{ $total }}</th>
                            </tr>
                        
                        @endif
                        </table>
                    </div>
                    
                
            </div>
            
            
        </div>
        <div class="row">
            <div class="col-md-12">
                
                <button type="submit" class="btn btn-primary text-center">Update</button>
                
            </div>

        </div>
    </form>

</div>

@endsection

<script>
    //CKEDITOR.replace('description1')
</script>

