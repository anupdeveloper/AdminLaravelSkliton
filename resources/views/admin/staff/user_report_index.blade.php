@extends('admin.layouts.layout')

@section('content')
    <style>
        .advance-filter {
            margin: 30px 20;
        }
        .search-tbn {
            float: right;
            margin-top: -58px;
        }
        .mt-20 {
            margin-top: 20px;
        }

        .table-responsive {
            margin: 30px 0; 
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
            }

            .switch input { 
            opacity: 0;
            width: 0;
            height: 0;
            }

            .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            }

            .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            }

            input:checked + .slider {
            background-color: #2196F3;
            }

            input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
            }

            input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
            }

            /* Rounded sliders */
            .slider.round {
            border-radius: 34px;
            }

.slider.round:before {
  border-radius: 50%;
}
    </style>

    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">{{ __('api.admin.User.title') }}</h1>
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
    
    <div class="advance-filter">
        <form action="{{ route('user.report.list') }}" method="get">
            @csrf
            <div class="row">
            <select class="form-control sel col-md-2 select2" id="account_type" name="account_type">
                <option value="">--{{ __('api.admin.User.labels.account_type_id') }}--</option>
                <option @if(isset($_REQUEST['account_type']) && $_REQUEST['account_type'] == 1) selected @endif value="1">Family</option>
                <option @if(isset($_REQUEST['account_type']) && $_REQUEST['account_type'] == 2) selected @endif value="2">Individual</option>
            </select>
            <select class="form-control sel col-md-2" id="gender" name="gender">
                <option value="">--{{ __('api.admin.User.labels.gender') }}--</option>
                <option @if(isset($_REQUEST['gender']) && $_REQUEST['gender'] == 'male') selected @endif value="male">Male</option>
                <option @if(isset($_REQUEST['gender']) && $_REQUEST['gender'] == 'female') selected @endif value="female">Female</option>
            </select>
            <select class="form-control sel col-md-2" id="height" name="height">
                <option value="">--{{ __('api.admin.User.labels.height') }}--</option>
                @for($i = $master_heights->height_min; $i < $master_heights->height_max ; $i=$master_heights->step + $i)
                    <option @if(isset($_REQUEST['height']) && $_REQUEST['height'] == '{{ $i }}-{{$i + $master_heights->step}} cm') selected @endif value="{{ $i }}-{{$i + $master_heights->step}} cm">{{ $i }}-{{$i + $master_heights->step}} cm</option>
                @endfor
               
            </select>
            <input class="form-control sel col-md-2" id="age" value="{{ isset($_REQUEST['age']) ? $_REQUEST['age'] : ''  }}"  name="age" type="date">
               
            <select multiple class="form-control sel col-md-3 select2" id="country" name="country[]" >
                <option value="">--{{ __('api.admin.User.labels.nationality_id') }}--</option>
                @foreach($country_list as $row)
                    <option @if(isset($_REQUEST['country']) && in_array($row->id,$_REQUEST['country'])) selected @endif value="{{ $row->id }}">{{ $row->name }}</option>
                @endforeach
            </select>
            <select multiple class="form-control sel col-md-3 select2" id="residence_country" name="residence_country[]" >
                <option value="">--{{ __('api.admin.User.labels.residence_nationality') }}--</option>
                @foreach($country_list as $row)
                    <option @if(isset($_REQUEST['residence_country']) && in_array($row->id,$_REQUEST['residence_country'])) selected @endif value="{{ $row->id }}">{{ $row->name }}</option>
                @endforeach
            </select>
            
            <select class="form-control sel col-md-2 select2"  id="region" name="region">
                <option value="">--{{ __('api.admin.User.labels.region_id') }}--</option>
                @foreach($region_list as $row)
                    <option @if(isset($_REQUEST['region']) && $_REQUEST['region'] == $row->id) selected @endif value="{{ $row->id }}">{{ $row->name }}</option>
                @endforeach
            </select>
            <select class="form-control sel col-md-2 select2" name="family_origin">
                <option value="">--{{ __('api.admin.User.labels.family_origin') }}--</option>
                @foreach($family_origin_list as $row)
                    <option @if(isset($_REQUEST['family_origin']) && $_REQUEST['family_origin'] == $row->id) selected @endif value="{{ $row->id }}">{{ $row->name_en }}</option>
                @endforeach
            </select>

            <select class="form-control sel col-md-3 select2"  id="previsously_married" name="previsously_married">
                <option value="">--{{ __('api.admin.User.labels.previsously_married') }}--</option>
                <option @if(isset($_REQUEST['previsously_married']) && $_REQUEST['previsously_married'] == 'yes') selected @endif value="yes">Yes</option>
                <option @if(isset($_REQUEST['previsously_married']) && $_REQUEST['previsously_married'] == 'no') selected @endif value="no">No</option>
            </select>

            <select class="form-control sel col-md-3 select2"  id="currently_married" name="currently_married">
                <option value="">--{{ __('api.admin.User.labels.currently_married') }}--</option>
                <option @if(isset($_REQUEST['currently_married']) && $_REQUEST['currently_married'] == 'yes') selected @endif value="yes">Yes</option>
                <option @if(isset($_REQUEST['currently_married']) && $_REQUEST['currently_married'] == 'no') selected @endif value="no">no</option>
            </select>

            <select class="form-control sel col-md-3 select2"  id="no_of_children" name="no_of_children">
                <option value="">--{{ __('api.admin.User.labels.no_of_children') }}--</option>
                @foreach($children_list as $child)
                    <option value="{{ $child->id }}">{{ $child->children_number_en }}</option>
                @endforeach
            </select>

            <select class="form-control sel col-md-3"  id="skin_color" name="skin_color">
                <option value="">--{{ __('api.admin.User.labels.skin_color') }}--</option>
                @foreach($skin_color as $color)
                    <option  @if(isset($_REQUEST['skin_color']) && $_REQUEST['skin_color'] == $color->id) selected @endif value="{{ $color->id }}">{{ $color->name_en }}</option>
                @endforeach
            </select>

            <select  class="form-control sel col-md-2" id="education" name="education">
                <option value="">--{{ __('api.admin.User.labels.education') }}--</option>
                @foreach($education_list as $row)
                    <option @if(isset($_REQUEST['education']) && $_REQUEST['education'] == $row->id) selected @endif value="{{ $row->id }}">{{ $row->name_en }}</option>
                @endforeach
            </select>

            <select  class="form-control sel col-md-2" id="occupation" name="occupation">
                <option value="">--{{ __('api.admin.User.labels.occupation') }}--</option>
                @foreach($occupation_list as $row)
                    <option @if(isset($_REQUEST['occupation']) && $_REQUEST['occupation'] == $row->id) selected @endif value="{{ $row->id }}">{{ $row->name_en }}</option>
                @endforeach
            </select>

            <select class="form-control sel col-md-3"  id="smoking" name="smoking">
                <option value="">--{{ __('api.admin.User.labels.smoking') }}--</option>
                <option @if(isset($_REQUEST['smoking']) && $_REQUEST['smoking'] == 'yes') selected @endif value="yes">Yes</option>
                <option @if(isset($_REQUEST['smoking']) && $_REQUEST['smoking'] == 'sometimes') selected @endif value="sometimes">sometimes</option>
                <option @if(isset($_REQUEST['smoking']) && $_REQUEST['smoking'] == 'no') selected @endif value="no">no</option>
            </select>

            <select class="form-control sel col-md-2 select2" id="city" name="city">
                <option value="">--{{ __('api.admin.User.labels.city') }}--</option>
                @foreach($cities_list as $row)
                    <option @if(isset($_REQUEST['city']) && $_REQUEST['city'] == $row->id) selected @endif value="{{ $row->id }}">{{ $row->name }}</option>
                @endforeach
            </select>
        
            
            <select  class="form-control sel col-md-2 select2" name="tribal">
                <option value="">--{{ __('api.admin.User.labels.tribal') }}--</option>
                @foreach($tribes_list as $row)
                    <option  @if(isset($_REQUEST['tribal']) && $_REQUEST['tribal'] == $row->id) selected @endif value="{{ $row->id }}">{{ $row->name_en }}</option>
                @endforeach
            </select>
            <select class="form-control sel col-md-2 select2" name="sect">
                <option value="">--{{ __('api.admin.User.labels.sect') }}--</option>
                @foreach($sect_list as $row)
                    <option @if(isset($_REQUEST['sect']) && $_REQUEST['sect'] == $row->id) selected @endif value="{{ $row->id }}">{{ $row->name_en }}</option>
                @endforeach
            </select>
            
            
            <div class="col-md-12">
                <div class="search-tbn">
                    <input class="form-control btn btn-primary btn mt-20" type="submit" name="advance_search" value="{{ __('api.admin.User.labels.search') }}">
                </div>
            </div>
            </div>
            
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th >{{ __('api.admin.User.labels.name') }}</th>
                    <th>{{ __('api.admin.User.labels.account_type_id') }}</th>
                    
                    <th>{{ __('api.admin.User.labels.email') }}</th>
                    <th>{{ __('api.admin.User.labels.mobile') }}</th>
                    
                    <th>{{ __('api.admin.User.labels.nationality_id') }}</th>
                    
                    <th>{{ __('api.admin.User.labels.region_id') }}</th>
                    <th>{{ __('api.admin.User.labels.city_id') }}</th>
                    <th>{{ __('api.admin.User.labels.profile_completed') }}</th>
                    <th>{{ __('api.admin.User.labels.subscription_status') }}</th>
                    
                    <th>{{ __('api.admin.User.labels.currently_married') }}</th>
                    <th>{{ __('api.admin.User.labels.report_count') }}</th>
                    <th>{{ __('api.admin.User.labels.send_noti') }}<th>
                    <th width="100%">{{ __('api.admin.common.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user_list as $user)
                @php
                    $subscription = App\Helper\Helper::get_latest_subscription($user->id);
                    //dd($subscription);
                @endphp
                    <tr>
                        <td>{{ $user->account_type->name == "Family" ? $user->name : $user->user_default_info->name }}</td>
                        <td>{{ $user->account_type->name ?? '' }}</td>
                        
                        <td>{{ $user->email ?? '' }}</td>
                        <td>{{ $user->mobile ?? '' }}</td>
                        
                        
                        <td>{{ $user->nationality_detail->name ?? '' }}</td>
                        
                        <td>{{ $user->region_detail->name ?? '' }}</td>
                        <td>{{ $user->city_detail->name ?? '' }}</td>
                        <td>{{ $user->is_completed ? 'Yes' : 'No'  }}</td>
                        <td>{{  $subscription ? $subscription->status : '--'  }}</td>
                        
                        <td>{{ $user->user_default_info->currently_married ?? '' }}</td>
                        <td>
                            @php 
                               $report_count = App\Helper\Helper::report_count($user->id);
                            @endphp
                            @if($report_count >0)
                            <a  target="_blank" href="{{ route('user.report',$user->id) }}"><span class="badge badge-danger">{{ __('api.admin.User.labels.view_reports') }}({{ $report_count }})</span></a>
                            @else
                                --
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-small btn-success btn-sm" onclick="send_notification({{ $user->id }})">{{ __('api.admin.User.labels.send_noti') }}</a>
                        </td>
                        <td>
                            
                            <label class="switch">
                                <input id="account_blocked-{{ $user->id }}" onChange="account_blocked({{ $user->id }});" name="account_blocked" type="checkbox" @if($user->account_blocked==0) checked @endif>
                                <span class="slider round"></span>
                            </label>
                            
                        </td>
                        <td width="100%">


                            
                            <a class="btn btn-small btn-info btn-sm"
                                href="{{ route('admin.user.edit', ['id' => $user->id]) }}"><i class="fas fa-pencil-alt"></i></a>


                            {{-- @if (isset($user->is_active) && $user->is_active)
                                <i class='fas fa-lock-close'></i>
                            @else
                                <i class='fas fa-lock-open'></i>
                            @endif --}}


                            <form style="display: inline-block"
                                action="{{ route('admin.user.destroy', ['id' => $user->id]) }}" method="post">
                                @method('DELETE')@csrf
                                <button onclick="return confirm('are u sure?')" class="btn btn-danger btn-sm"
                                    type="submit">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>
                            @if(isset($user->account_type->id) && $user->account_type->id==1)
                            <a class="btn btn-small btn-warning btn-sm"
                                href="{{ route('admin.user-family.index', ['family_head_user_id' => $user->id]) }}"><i class="fa fa-users" aria-hidden="true"></i></a>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="{{  route('admin.user.send.notification') }}" method="POST" enctype="multipart/form-data" >
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Send Notification</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
                @csrf
                <input type="hidden" id="user_ids" name="user_ids" />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Title in english</label>
                            <input required class="form-control" name="notification_title_en" id="notification_title_en">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Title in arabic</label>
                            <input required class="form-control" name="notification_title_ar" id="notification_title_ar">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Notification in english</label>
                            <textarea required class="form-control" name="notification_en" id="notification_en"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Notification in arabic</label>
                            <textarea required class="form-control" name="notification_ar" id="notification_ar"></textarea>
                        </div>
                    </div>
                </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Send</button>
        </div>
        </form>
      </div>
    </div>
</div>  

@endsection

@push('script-footer')
    <script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .select2-container--default .select2-dropdown .select2-search__field:focus, .select2-container--default .select2-search--inline .select2-search__field:focus {
            outline: 0;
            border: 0px solid #80bdff !important
            ;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color:#495057  !important;
        }
        .select2-container--default .select2-selection--multiple {
            background-color: white;
            border: 1px solid #ced4da !important;
            padding-bottom: 11px;
           
        }
    </style>
    <script>

        function account_blocked(user_id) {
            //alert(user_id)
            var account_blocked = 1;
            if ($('#account_blocked-' + user_id).is(':checked')) {
                //alert('cked')
                account_blocked = 0;
            } else {
                //alert('not cked')
                account_blocked = 1;
            }
            //var account_blocked = $("#account_blocked").val();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "post",
                url: "{{ route('admin.user.block_user') }}",
                data: { account_blocked:account_blocked,user_id:user_id },
                cache: false,
                datatype:"json",
                success: function(data){
                   alertify.set('notifier', 'position', 'top-center');
                   if(account_blocked==0) {
                        //alert('You have successfully activate the acccount!!')
                        alertify.success('You have successfully activate the acccount!!'); 
                   } else{
                        alertify.success('You have successfully deactivate the acccount!!'); 
                   }
                   location.reload()
                }
            });
        }

        function send_notification(user_id) {
            if(user_id != '') {
                $(".select-ids").prop("checked", false);
                $('#sel-' + user_id).prop("checked", true);
            }
        

            var user_ids = $(".select-ids:checkbox:checked").map(function(){
                return $(this).val();
            }).get();
                $('#user_ids').val(user_ids)
            $('#exampleModal').modal('show');
        }   

        $('#country').select2({
            placeholder: "--{{ __('api.admin.User.labels.nationality_id') }}--",
            allowClear: true
        });

        $('#residence_country').select2({
            placeholder: "--{{ __('api.admin.User.labels.residence_nationality') }}--",
            allowClear: true
        });

        $('#country').on('change', function() {
            if($(this).val() == '195') {
                $('#region, #city').show();
            } else {
                $('#region, #city').hide();
            }
            
        })

       
        //$('#country').select2().val($selected_countries).trigger('change'); 

        $('#account_type').on('change', function() {
            if($(this).val() == '2') {
                $('#marital_status, #education').show();
            } else {
                $('#marital_status, #education').hide();
            }
        })

        var table = $('.table').DataTable({
            pageLength : 5,
            lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
            dom: 'Bftip',
            buttons: [
                //'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        })

        
        
        
    </script>
@endpush
@push('script-header')
    <script src="{{ asset('assets_admin/ckeditor/ckeditor.js') }}"></script>
@endpush
@push('script-footer')
    <script>
        CKEDITOR.replace('notification_en')
        CKEDITOR.replace('notification_ar')
    </script>
@endpush
