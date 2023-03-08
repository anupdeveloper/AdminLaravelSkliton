
@extends('admin.layouts.layout')

@section('content')

<div class="container">






    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="card-header">
                        <h2>{{ __('admin_dashboard.admin.MasterPopupMessage.pages.view.labels.view_masterpopupmessage') }}</h2>
                    </div>
                    <table class="table table-sm">
                        <tr>
<th>{{ __('admin_dashboard.admin.MasterPopupMessage.labels.group_name') }}</th>
				
<td>{{$master_popup_message->group_name??''}}</td>
				
</tr>
<tr>
<th>{{ __('admin_dashboard.admin.MasterPopupMessage.labels.message_value_en') }}</th>
				
<td>{{$master_popup_message->message_value_en??''}}</td>
				
</tr>
<tr>
<th>{{ __('admin_dashboard.admin.MasterPopupMessage.labels.message_value_ar') }}</th>
				
<td>{{$master_popup_message->message_value_ar??''}}</td>
				
</tr>

                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="jumbotron text-center">

        <p>

        </p>
    </div>

</div>

@endsection

