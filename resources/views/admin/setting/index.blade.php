@extends('admin.layouts.layout')
@section('content')
    <style>
        .advance-filter {
            /* margin: 30px 20px; */
            display: inline-block;
            width: 60%;
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

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0 !important;
        }

        .notify {
            z-index: 1000000;
            margin-top: 5%;
        }

        .mt10 {
            margin-top: 10px
        }

        .actions-btn {
            display: inline-block;
            float: right;
            padding-bottom: 20px;
        }
    </style>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $page_title }}</h1>

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">

        <div class="advance-filter">
            {{-- <form id="assign-form" name="assign-form" action="{{route('admin.workorder.assignworkorders')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="leads_selected" name="leads_selected" />
                <div class="row">
                    <div class="col-md-4">
                        <select required class="form-control" name="tele_caller">
                            <option value="">select technician</option>
                            @if($tele_callers)
                                @foreach($tele_callers as $row)
                                <option value="{{ $row->id }}">{{ $row->username }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input class="btn btn-primary" type="submit" name="asign" value="Assign" />
                    </div>
                </div>
            </form> --}}
        </div>
        <div class="actions-btn">
            <a class="btn btn-primary sm-btn" href="{{route("admin.setting.add")}}" >Add New</a>
        </div>
        
        <div class="table-responsive">
            <table id="userMGMT" class="table table-bordered  data-table">
                <thead>
                <tr>
                    <th>Slot Name</th>
                    <th>Slot Time</th>
                    <th class='notexport' width="100px">Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>



@endsection

@push('script-footer')
    <script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .select2-container--default .select2-dropdown .select2-search__field:focus, .select2-container--default .select2-search--inline .select2-search__field:focus {
            outline: 0;
            border: 0px solid #80bdff !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: #495057 !important;
        }

        .select2-container--default .select2-selection--multiple {
            background-color: white;
            border: 1px solid #ced4da !important;
            padding-bottom: 11px;

        }
    </style>
    <script>

        
       $('.check-all').click(function() {
            if($('.check-all').is(':checked'))
            {
                $('.not-assigned').prop('checked', true);
                //assign in a text field
                var selected_leads_arr = $(".lead-ckbox:checked").map(function(){
                    return $(this).val();
                }).toArray();
                console.log(selected_leads_arr)
                $('#leads_selected').val(selected_leads_arr)
            }
            else
            {
                $('.not-assigned').prop('checked', false);
                $('#leads_selected').val('')
            }
               
        });


        

        


        $(function () {

            var oTable = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                "stateSave": true,
                ajax: {
                    url: "{{ route('admin.setting.getdata') }}",
                    data: function (d) {
                        d.search = $('#search').val();
                    }
                },
                columns: [

                    {data: 'slot_name', name: 'slot_name'},
                    {data: 'slot_time', name: 'slot_time'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                
                //dom: 'Blrtip',
                buttons: [
                    {
                        text: 'Export Records',
                        className: 'btn btn-default',
                        action: function (e, dt, button, config) {
                            $.ajax({
                                method: "post",
                                headers:
                                    {
                                        'X-CSRF-TOKEN':
                                            $('meta[name="csrf-token"]').attr('content')
                                    },
                                url: "{{route('admin.users.export')}}",
                                data:
                                    {
                                        
                                        // d.tribal = $('#tribal').val();

                                    },
                                success: function (response) {
                                    if (response.status === 200) {
                                        alertify.success('User Export Started!!');
                                        setTimeout(function () {
                                            location.reload()
                                            // console.log(response);
                                            // var a = document.createElement("a");
                                            // a.href = window.location.href+'/'+response.file;
                                            // a.download = response.file;
                                            // document.body.appendChild(a);
                                            // a.click();
                                            // a.remove();
                                        }, 10000);
                                    }

                                }
                            });
                        }
                    },
                ],

                pageLength: 10,
                lengthMenu: [[10, 20, 50, -1], [10, 20, 50, 'all']],
                lengthChange: true,
            });

            $('#search_form').on('submit', function (e) {
                oTable.draw();
                e.preventDefault();
            });


        });

        $("#assign-form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var actionUrl = form.attr('action');
            //alert(actionUrl)
            $.ajax({
                datatype: "json",
                type: "POST",
                url: "{{ route('admin.workorder.assignworkorders') }}",
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {
                    //alert(data); // show response from the php script.
                    location.reload();
                }
            });
        });

    
        function assign_lead(id)
        {
            // if($('#leads_selected').val() != null) {
            //     var all_selected_leads = $('#leads_selected').val().split(',');
            // } else {
            //     var all_selected_leads = [];
            // }
            
            // if($('#lead-ckbox-' + id).is(':checked'))
            // {
            //     if(!all_selected_leads.includes(id)) {
            //         all_selected_leads.push(id);
            //         $('#leads_selected').val(all_selected_leads)
            //     }
                
            // }
            // else
            // {

            //     if(all_selected_leads.includes(id)) {
            //         all_selected_leads.push(id);
            //         $('#leads_selected').val(all_selected_leads)
            //     } else {
            //         $('#leads_selected').val(all_selected_leads)
            //     }
            // }
            var selected_leads_arr = $(".lead-ckbox:checked").map(function(){
                    return $(this).val();
            }).toArray();
            console.log(selected_leads_arr)
            $('#leads_selected').val(selected_leads_arr)
        }

        function delete_row(id) {

            if (confirm('Are you sure?')) {
                // ajax call to delete this user
                $.ajax({
                    headers:
                        {
                            'X-CSRF-TOKEN':
                                $('meta[name="csrf-token"]').attr('content')
                        },
                    type: "post",
                    url: "{{ route('admin.setting.destroy') }}",
                    data:
                        {
                            id: id
                        },
                    cache: false,
                    datatype: "json",
                    success: function (data) {
                        $('#' + id).hide();
                        alertify.set('notifier', 'position', 'top-center');
                        alertify.success('You have successfully deleted this Slot!!');
                        
                    }
                });
            }
        }


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
