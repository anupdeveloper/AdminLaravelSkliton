
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
    <form action="{{  route('admin.workorder.save') }}" method="POST" enctype="multipart/form-data" >
        @method('POST')
        @csrf
        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label for="assign_technician">WorkOrder Type</label>
                    <select onchange="work_order_type($this->val())" class="form-control" name="work_order_type" id="work_order_type">
                        <option value="">--SELECT--</option>
                        <option value="normal">NORMAL</option>
                        <option value="complaint">COMPLAINT</option>
                    </select>
                    @error('assign_technician')
                    <div><small class="text-danger">{{$message}}</small></div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
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
                <label for="category_name">Category</label>
                <select class="form-control" name="category" id="category">
                    <option value="">--SELECT--</option>
                    @if(isset($categories) && $categories)
                        @foreach($categories as $row)
                            <option  value="{{$row->id}}">{{$row->category_name}}</option>
                        @endforeach 
                    @endif
                </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="technician_id">Assign Technician</label>
                    <select class="form-control" name="technician_id" id="technician_id">
                        <option value="">--SELECT--</option>
                        @if(isset($technicians) && $technicians)
                            @foreach($technicians as $row)
                                <option value="{{$row->id}}">{{$row->name}}</option>
                            @endforeach 
                        @endif
                    </select>
                    @error('technician_id')
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
                                <option value="{{$row}}">{{$row}}</option>
                            @endforeach 
                        @endif
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

<script>
    //CKEDITOR.replace('description1')
    function work_order_type(val)
    {
        alert(val)
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
    
</script>

