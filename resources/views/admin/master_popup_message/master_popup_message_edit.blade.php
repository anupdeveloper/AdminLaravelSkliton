@extends('admin.layouts.layout')

@section('content')
    <div class="container">


        <h1>{{ __('admin_dashboard.admin.MasterPopupMessage.pages.edit.labels.edit_a_masterpopupmessage') }}</h1>

        <!-- if there are creation errors, they will show here -->
        <form id="form" action="{{ route('admin.master-popup-message.update', ['id' => $master_popup_message['id']]) }}" method="POST"
            enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="row">


                <div class="col-lg-12">
                    <div class="form-group">
                        <label
                            for="group_name">{{ __('admin_dashboard.admin.MasterPopupMessage.labels.group_name') }}</label>
                        <input readonly type="text" class="form-control" name="group_name" id="group_name"
                            value="{{ $master_popup_message->group_name ?? '' }}">
                        @error('group_name')
                            <div><small class="text-danger">{{ $message }}</small></div>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label
                            for="message_value_en">{{ __('admin_dashboard.admin.MasterPopupMessage.labels.message_value_en') }}</label>
                        <input type="text" class="form-control" name="message_value_en" id="message_value_en" value="{{$master_popup_message->message_value_en??''}}">
                        <div  id="message_value_en"></div>
                        @error('message_value_en')
                            <div><small class="text-danger">{{ $message }}</small></div>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label
                            for="message_value_ar">{{ __('admin_dashboard.admin.MasterPopupMessage.labels.message_value_ar') }}</label>
                        <input type="text" class="form-control" name="message_value_ar" id="message_value_ar" value="{{$master_popup_message->message_value_ar??''}}">
                        <div id="message_value_ar"></div>
                        @error('message_value_ar')
                            <div><small class="text-danger">{{ $message }}</small></div>
                        @enderror
                    </div>
                </div>

                <div class="col-lg- mt-5">
                    <div class="form-group">
                        <button type="submit"
                            class="btn btn-primary">{{ __('admin_dashboard.admin.MasterPopupMessage.pages.edit.button.update') }}</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection
@push('script-header')
    <link rel="stylesheet" href="{{ asset('assets_admin/jsoneditor/dist/jsoneditor.min.css') }}">
    <script src="{{ asset('assets_admin/jsoneditor/dist/jsoneditor.min.js') }}"></script>

    <script>
         
    </script>


@endpush
@push('script-footer')
    <script>
        var value_en=JSON.parse('{!! $master_popup_message->message_value_en !!}')
        var value_ar=JSON.parse('{!! $master_popup_message->message_value_ar !!}')

       

        let message_value_en = document.getElementById('message_value_en')
        let message_value_ar = document.getElementById('message_value_ar')
        let form = document.getElementById('form')


        let options = {
            mainMenuBar:false,
            navigationBar:false,
        }

        var editor = new JSONEditor(message_value_en, options);
        var editor_ar = new JSONEditor(message_value_ar, options);
        editor.set(value_en)
        editor_ar.set(value_ar)

        // form.onsubmit=(e)=>{
        //     e.preventDefault()
        //     let fd=new FormData(form)
        //     fd.append('message_value_en',JSON.stringify(editor.get()))
        //     fd.append('message_value_ar',JSON.stringify(editor_ar.get()))
        //     // console.log([...fd]);
        //     axios.post(form.action,fd)
        //     .then(res=>{
        //         console.log(res.data);
        //         if(res.data.success){
        //             alertify.set('notifier','position', 'top-center');
        //             alertify.success('Updated Successfully'); 
        //             $(location).attr('href','/admin/master-popup-message')
        //         }
        //     })
        //     .catch(err=>{})

        // }


    </script>
@endpush
<script>
    //CKEDITOR.replace('description1')
</script>
