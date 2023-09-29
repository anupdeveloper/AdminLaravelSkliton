
@extends('admin.layouts.layout')

@section('content')
<style>
    ul.slots li {
        display: inline-block;
        padding: 10px;
        border: 1px solid;
        margin: 1px;
    }

    .avaliable {
        background-color: green
    }
    .booked {
        background-color: chocolate
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


    <!-- if there are creation errors, they will show here -->
    <form action="{{  route('admin.workorder.update',['id'=>$data['id']]) }}" method="POST" enctype="multipart/form-data" >
        @method('POST')
        @csrf
        <div class="row">
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="technician_id">Select Technician</label>
                    <select onchange="getSlots(this.value)" class="form-control" name="technician_id" id="technician_id">
                        <option value="">--SELECT--</option>
                        @if(isset($technicians) && $technicians)
                            @foreach($technicians as $row)
                                <option @if($data->technician_id == $row->id) selected @endif value="{{$row->id}}">{{$row->name}}</option>
                            @endforeach 
                        @endif
                    </select>
                    @error('technician_id')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
        </div>
        <div>
            <h2>Avaliable Slots</h2>
            <div id="dis_slots">

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="assign_technician">WorkOrder Type</label>
                    <select class="form-control" onchange="get_work_order_type(this.value);" name="work_order_type" id="work_order_type">
                        <option value="">--SELECT--</option>
                        <option  @if($data->work_order_type == 'normal') selected @endif value="normal">NORMAL</option>
                        <option @if($data->work_order_type == 'complaint') selected @endif value="complaint">COMPLAINT</option>
                    </select>
                    @error('assign_technician')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 ref_no" id="ref_no" style="display:none;" >
                <div class="form-group">
                    <label for="assign_technician">Reference No</label>
                    <select onchange="get_ticket_detail()" class="form-control" name="ticket_id" id="ticket_ref_id">
                        <option value="">--SELECT--</option>
                        @if(isset($tickets) && $tickets)
                            @foreach($tickets as $row)
                                <option title="{{$row->title}}" description="{{$row->description}}" value="{{$row->id}}">{{$row->ticket_no}}</option>
                            @endforeach 
                        @endif
                    </select>
                    @error('assign_technician')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="user_id">Customer</label>
                    <select class="form-control" name="user_id" id="user_id">
                        <option value="">--SELECT--</option>
                        @if(isset($customers) && $customers)
                            @foreach($customers as $row)
                                <option @if($data->user_id == $row->id) selected @endif value="{{$row->id}}">{{$row->name}}</option>
                            @endforeach 
                        @endif
                    </select>
                    @error('user_id')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" value="{{$data->title}}" class="form-control">
                    @error('title')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" value="" class="form-control">{{$data->description}}</textarea>
                    @error('description')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="category_name">Category</label>
                <select class="form-control" name="category" id="category">
                    <option value="">--SELECT--</option>
                    @if(isset($categories) && $categories)
                        @foreach($categories as $row)
                            <option @if($data->category == $row->id) selected @endif value="{{$row->id}}">{{$row->category_name}}</option>
                        @endforeach 
                    @endif
                </select>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" name="status" id="status">
                        <option value="">--SELECT--</option>
                        @if(isset($statuses) && $statuses)
                            @foreach($statuses as $row)
                                <option @if($data->status == $row->name) selected @endif value="{{$row->name}}">{{$row->name}}</option>
                            @endforeach 
                        @endif
                    </select>
                    @error('status')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="status">Select Slot</label>
                    <select class="form-control" name="slot_id" id="slot_id">
                        <option value="">--SELECT--</option>
                        <option selected value="{{$data->technician_assign_detail->slot_detail->id}}">{{$data->technician_assign_detail->slot_detail->slot_time}}</option>
                    </select>
                    @error('status')
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    $('.ref_no').hide();

    //CKEDITOR.replace('description1')
    function get_work_order_type(val)
    {
        //alert('hhh')
        //val = 'normaluu';
        if(val === 'normal') {
            $('#ref_no').hide();
        } else {
            $('#ref_no').show();
        }
    }

    function get_ticket_detail()
    {
        var element = $('#ticket_ref_id').find('option:selected'); 
        var title = element.attr("title"); 
        var description = element.attr("description"); 
        console.log(title)
        $('#title').val(title); 
        $('#description').val(description); 
    }

    function getSlots(val)
    {
        //alert(val)
            $.ajax({
                headers:
                    {
                        'X-CSRF-TOKEN':
                            $('meta[name="csrf-token"]').attr('content')
                    },
                type: "post",
                url: "{{ route('admin.workorder.userslots') }}",
                data:
                    {
                        technician_id: val
                    },
                dataType: "json",     
                cache: false,
                success: function (data) {
                    //alert(data.list)
                    $('#dis_slots').html(data.list)
                    var $el = $("#slot_id");
                    $el.empty(); // remove old options
                    $.each(data.res, function(key,value) {
                    if(value.is_slot_booked == false) {
                        $el.append($("<option></option>")
                        .attr("value", value.id).text(value.slot_name + '(' +value.slot_time + ') Avaliable'));
                    }
                    
                    });
                }
            });
    }
    
    
</script>

