
@extends('admin.layouts.layout')

@section('content')
<div class="container">


    <h1>{{ __('admin_dashboard.admin.MasterPopupMessage.pages.add.labels.create_a_masterpopupmessage') }}</h1>

    <!-- if there are creation errors, they will show here -->
    <form action="{{ route('admin.master-popup-message.store') }}" method="POST" enctype="multipart/form-data">
        {{@csrf_field()}}
        <div class="row">

                
<div class="col-lg-12">
    <div class="form-group">
        <label for="group_name">{{ __('admin_dashboard.admin.MasterPopupMessage.labels.group_name') }}</label>
        <input type="text" class="form-control" name="group_name" id="group_name" value="{{Request::old('group_name')}}">
        @error('group_name')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="message_value_en">{{ __('admin_dashboard.admin.MasterPopupMessage.labels.message_value_en') }}</label>
        <input type="text" class="form-control" name="message_value_en" id="message_value_en" value="{{Request::old('message_value_en')}}">
        @error('message_value_en')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <label for="message_value_ar">{{ __('admin_dashboard.admin.MasterPopupMessage.labels.message_value_ar') }}</label>
        <input type="text" class="form-control" name="message_value_ar" id="message_value_ar" value="{{Request::old('message_value_ar')}}">
        @error('message_value_ar')
        <div><small class="text-danger">{{$message}}</small></div>
        @enderror
    </div>
</div>

            
            <div class="col-lg-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Add</button>
                </div>
            </div>

        </div>
    </form>

</div>

@endsection

<script>
    // CKEDITOR.replace('description1')
</script>

