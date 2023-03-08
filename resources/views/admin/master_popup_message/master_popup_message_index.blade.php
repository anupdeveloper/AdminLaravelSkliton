
@extends('admin.layouts.layout')

@section('content')



<div class="container">

    {{-- <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('admin.master-popup-message.create') }}" class="btn btn-primary">{{ __('admin_dashboard.admin.MasterPopupMessage.pages.list.button.add') }}</a>
        </div>
    </div> --}}


    <h1 class="page-title">{{ __('admin_dashboard.admin.MasterPopupMessage.pages.list.labels.all_the_masterpopupmessage') }}</h1>

    <!-- will be used to show any messages -->
   {{-- @if (Session::has('message'))
        <div class="alert alert-info">{ Session::get('message') }</div>
    @endif --}}

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>{{ __('admin_dashboard.admin.MasterPopupMessage.labels.group_name') }}</th>
				<th>{{ __('admin_dashboard.admin.MasterPopupMessage.labels.message_value_en') }}</th>
				<th>{{ __('admin_dashboard.admin.MasterPopupMessage.labels.message_value_ar') }}</th>
				

                <th width="15%">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($master_popup_message_list as $master_popup_message)
                <tr>
                <td>{{$master_popup_message->group_name.'/'.$master_popup_message->key_name??''}}</td>
				<td>{{$master_popup_message->message_value_en??''}}</td>
				<td>{{$master_popup_message->message_value_ar??''}}</td>
				


                    <td>


                        <a class="btn btn-small btn-success btn-sm" href="{{ route('admin.master-popup-message.show',['id'=>$master_popup_message->id]) }}">{{ __('admin_dashboard.admin.MasterPopupMessage.pages.list.button.view') }}</a>
                        <a class="btn btn-small btn-info btn-sm"
                           href="{{ route('admin.master-popup-message.edit',['id'=>$master_popup_message->id])  }}">{{ __('admin_dashboard.admin.MasterPopupMessage.pages.list.button.edit') }}</a>


                        {{--   @if(isset($master_popup_message->is_active) && $master_popup_message->is_active)
                            <a class="btn btn-sm btn-warning" href="{{ route('admin.master-popup-message.enb-disb',['id'=>$master_popup_message->id])  }}">Activated</a>
                        @else
                            <a class="btn btn-sm btn-secondary" href="{{ route('admin.master-popup-message.enb-disb',['id'=>$master_popup_message->id])  }}">Deactivated</a>
                        @endif
                         --}}
                            

                        {{-- <form style="display: inline-block" action="{{ route('admin.master-popup-message.destroy',['id'=>$master_popup_message->id])  }}"
                              method="post">
                            @method('DELETE')@csrf
                            <button onclick="return confirm('are u sure?')" class="btn btn-danger btn-sm" type="submit">
                                {{ __('admin_dashboard.admin.MasterPopupMessage.pages.list.button.delete') }}
                            </button>
                        </form> --}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection

<script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
<script>
    $('.table').dataTable({
        // columnDefs:[{type:'date','targets':[0]}],
        "columnDefs" : [{"targets":0, "type":"date-eu"}],
        order:[[0,'desc']]
    })
</script>

