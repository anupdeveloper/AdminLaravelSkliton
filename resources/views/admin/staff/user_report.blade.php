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
            <h1 class="m-0">User Reports List</h1>
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
    
    

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Reported By</th>
                    <th>Reported Date</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($user_report_list as $user)
                
                    <tr>
                        <td><a target="_balnk" href="{{ route('admin.user.show', ['id' => $user->request_id]) }}">{{ App\Helper\Helper::getName($user->request_id); }}</a></td>
                        <td>{{ $user->reported_date }}</td>
                        
                        <td>{{ $user->reason_en }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
        $('#country').select2({
            placeholder: "--Nationality--",
            allowClear: true
        });

        $('#residence_country').select2({
            placeholder: "--Residence Country--",
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
