
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

    span.inline-btn {
        cursor: pointer;
        position: absolute;
        top: 36px;
        right: 22px;
        padding: 2px;
        border: 1px solid green;
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
    <form action="{{  route('admin.workorder.save') }}" method="POST" enctype="multipart/form-data" >
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
                                <option value="{{$row->id}}">{{$row->username}}</option>
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
                    <label for="work_order_type">WorkOrder Type</label>
                    <select class="form-control" onchange="get_work_order_type(this.value);" name="work_order_type" id="work_order_type">
                        <option value="">--SELECT--</option>
                        <option value="normal">NORMAL</option>
                        <option @if(isset($selected_ticket)) selected @endif value="complaint">COMPLAINT</option>
                    </select>
                    @error('work_order_type')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 ref_no" id="ref_no" style="display:none;" >
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="assign_technician">Reference No</label>
                            <select onchange="get_ticket_detail()" class="form-control" name="ticket_id" id="ticket_ref_id">
                                <option value="">--SELECT--</option>
                                @if(isset($tickets) && $tickets)
                                    @foreach($tickets as $row)
                                        <option @if(isset($selected_ticket) && $selected_ticket == $row->id ) selected @endif title="{{$row->title}}" description="{{$row->description}}" value="{{$row->id}}">{{$row->ticket_no}}</option>
                                    @endforeach 
                                @endif
                            </select>
                            @error('assign_technician')
                            <div><small class="text-danger">{{$message}}</small></div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <span class="inline-btn"><a href="{{route('admin.ticket.add')}}"> Add Ticket</a></span>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="user_id">Customer</label>
                            <select class="form-control" name="user_id" id="user_id">
                                <option value="">--SELECT--</option>
                                @if(isset($customers) && $customers)
                                    @foreach($customers as $row)
                                        <option value="{{$row->id}}">{{$row->username}} [<span class="badge badge-info">{{strtoupper(str_replace('_',' ',$row->user_type))}}]</span></option>
                                    @endforeach 
                                @endif
                            </select>
                            @error('user_id')
                            <div><small class="text-danger">{{$message}}</small></div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <span class="inline-btn"><a href="{{route('admin.user.create')}}"> Add Customer</a></span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" value="" class="form-control">
                    @error('title')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" value="" class="form-control"></textarea>
                    @error('description')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control" name="category" id="category">
                    <option value="">--SELECT--</option>
                    @if(isset($categories) && $categories)
                        @foreach($categories as $row)
                            <option  value="{{$row->id}}">{{$row->category_name}}</option>
                        @endforeach 
                    @endif
                </select>
                @error('category')
                <div><small class="text-danger">{{$message}}</small></div>
                @enderror
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" name="status" id="status">
                        <option value="">--SELECT--</option>
                        @if(isset($statuses) && $statuses)
                            @foreach($statuses as $row)
                                <option value="{{$row->name}}">{{$row->name}}</option>
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
                    <label for="slot_id">Select Slot</label>
                    <select class="form-control" name="slot_id" id="slot_id">
                        <option value="">--SELECT--</option>
                        
                    </select>
                    @error('slot_id')
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

@if(isset($selected_ticket)) 
    <script>
        get_work_order_type('complaint');
    </script>
@endif


<script>
    $('.ref_no').hide();
    $(document).ready(function(){
        get_work_order_type('complaint');
        get_ticket_detail();
    });
    
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

