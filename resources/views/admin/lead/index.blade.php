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

        .nowrap {
            text-wrap: nowrap;
        }

        select.form-control {
            font-size: 5;
            padding: 2px;
            font-size: 13px;
            height: 28px;
        }

        input.btn.btn-primary {
            height: 28px;
            padding: 1px 10px;
            font-size: 13px;
        }

        .col-md-10.offset-1.adv-filter label {
            font-size: 11px;
             
        }
        .advance-filter {
            
        margin: 0px;
        padding: 0px;

            
        }
        .col-md-2.search-btn {
            margin-top: 30px;
        }
        .col-md-12.adv-filter label {
            font-size: 14px;
            font-weight: 400;
        }
        label {
            display: inline-block;
            margin-bottom: 0px;
        }
        h2.heading {
            font-weight: 500;
        }
        .col-md-2.filter-tab {
            padding-left: 14px;
            margin-right: -25px;
        }
        .col-md-2.search-btn {
            margin-top: 24px;
        }
        table th, tr {
            word-wrap: normal;
            text-overflow: ellipsis;
            white-space: pre;
            /* display: -webkit-box; */
        }
        .col-md-12.adv-filter {
            padding: 0;
        }
        button.btn.btn-tab {
            background-color: lightblue;
            color: #000;
            padding: 5px 10px;
            font-size: 14px;
        }
        .active {
            background-color: blueviolet !important;
            color: #fff !important;
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

        
        <div class="actions-btn">
            <a class="btn btn-primary sm-btn" href="{{route("admin.lead.add")}}" >Add New</a>
        </div>
        <br>
        {{-- <div>
            <h2 class="heading">Lead Type</h2>
            <button value="new" class="btn btn-tab lead_type active">New</button>
            <button value="followup" class="btn btn-tab lead_type" >Follow Up</button>
        </div> --}}
        <br>
        {{-- <div id="product_type_block" style="display: none;">
            <h2 class="heading">Category</h2>
            <button value="chimeny" class="btn btn-tab product_type active">Chimney</button>
            <button value="water-purifier" class="btn btn-tab product_type" >Water Purifier</button>
        </div> --}}
        <br>
        @if(request('type'))
        <div class="col-md-12 adv-filter">
            <h2 class="heading">Filter</h2>
            <form id="filter-form" name="filter-form" action="{{route('admin.lead.getdata')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="filter" id="filter" name="filter" />
                <input type="hidden" value="new" id="lead_type" name="lead_type" />
                <input type="hidden" value="chimney" id="product_type" name="product_type" />
                <div class="row">
                    <div class="col-md-2 filter-tab">
                        <label>Select Telecaller</label>
                        <select class="form-control" id="tele_caller" name="tele_caller">
                            <option value="">Select telecaller</option>
                            @if($tele_callers)
                                @foreach($tele_callers as $row)
                                <option value="{{ $row->id }}">{{ $row->username }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-2 filter-tab">
                        <label>Use Status</label>
                        <select class="form-control" id="use_status" name="use_status">
                            <option value="">Select Status</option>
                            <option value="In Use">In Use</option>
                            <option value="Not Use">Not Use</option>
                        </select>
                    </div>
                    <div class="col-md-2 filter-tab">
                        <label>Paid Status</label>
                        <select class="form-control" name="waterpurifier_status" id="waterpurifier_status">
                            <option value="">Select Status</option>
                            <option value="Paid With Us">Paid With Us</option>
                            <option value="Paid With Other">Paid With Other</option>
                        </select>
                    </div>
                    <div class="col-md-2 filter-tab">
                        <label>AMC Status</label>
                        <select class="form-control" name="waterpurifier_status" id="waterpurifier_status">
                            <option value="">Select Status</option>
                            <option value="AMC With Us">AMC With Us</option>
                            <option value="AMC With Other">AMC With Other</option>
                        </select>
                    </div>
                    <div class="col-md-2 search-btn">
                        <input class="btn btn-primary" type="submit" name="search" value="Search" />
                    </div>
                </div>
            </form>
        </div>
        @endif
        <div class="col-md-12 adv-filter">
            <h2 class="heading">Assign</h2>
            <form id="assign-form" name="assign-form" action="{{route('admin.lead.assignleads')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="leads_selected" name="leads_selected" />
                <div class="row">
                    <div class="col-md-4">
                        <select required class="form-control" name="tele_caller">
                            <option value="">select telecaller</option>
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
            </form>
        </div> 
        <br>
        <div class="table-responsive">
            
            <table id="userMGMT" class="table table-bordered  data-table">
                <thead>
                <tr>
                    <th width="20px">SelectAll <input type="checkbox" class="check-all" name="selectall" /></th>
                    <th>Customer Detail</th>
                    <th>Use Status</th>
                    <th>AMC Status</th>
                    <th>Paid Status</th>
                    <th>Feedback</th>
                    <th>DateTime</th>
                    <th>Address</th>
                    <th>Tele Caller/Phone</th>
                    <th class='notexport nowrap' width="100px">Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            
        </div>
        <div class="advance-filter">
            
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

        $('.lead_type').click(function (){

            var lead_type = $(this).val();
            $('#lead_type').val(lead_type);
            if(lead_type == 'followup') {
                $('#product_type_block').show();
            } else {
                $('#product_type_block').hide();
            }

            $("#filter-form").submit();
        });

        
        $('.product_type').click(function (){

            var product_type = $(this).val();
            $('#product_type').val(product_type);

            $("#filter-form").submit();
        });
        
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


        

        
        var oTable;

        

        $(function () {

                
                oTable = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                "stateSave": true,
                ajax: {
                    url: "{{ route('admin.lead.getdata') }}",
                    data: function (d) {
                        d.filter = $('#filter').val();
                        d.lead_type = $('#lead_type').val();
                        d.product_type = $('#product_type').val();
                        d.tele_caller = $('#tele_caller').val();
                        //d.has_chimney = $('#has_chimney').val();
                        //d.in_use_chimney = $('#in_use_chimney').val();
                        //d.has_water_purifier = $('#has_water_purifier').val();
                        //d.in_use_waterpurifier = $('#in_use_waterpurifier').val();
                        d.waterpurifier_status = $('#waterpurifier_status').val();
                        d.chimney_status = $('#chimney_status').val();
                        
                    }
                },
                columns: [
                    {data: 'select_ck_box', name: 'select_ck_box', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    
                    {data: 'chimney_status', name: 'chimney_status'},
                    {data: 'waterpurifier_status', name: 'waterpurifier_status'},
                    {data: 'status', name: 'status'},
                    {data: 'feedback', name: 'feedback'},
                    {data: 'datetime', name: 'datetime'},
                    {data: 'address', name: 'address'},
                    {data: 'assigned_to', name: 'assigned_to'},
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

                pageLength: 5,
                lengthMenu: [[5, 10, 20, 50, -1], [5, 10, 20, 50, 'all']],
                lengthChange: true,
            });

            $('#search_form').on('submit', function (e) {
                oTable.draw();
                e.preventDefault();
            });

            


        });

        $("#filter-form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var actionUrl = form.attr('action');
            //alert(actionUrl)
            $.ajax({
                datatype: "json",
                type: "GET",
                url: actionUrl,
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {
                    //alert(data); // show response from the php script.
                    //location.reload();
                    oTable.draw();
                }
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
                url: "{{ route('admin.lead.assignleads') }}",
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

            //alert(id)
            if (confirm('Are you sure?')) {
                // ajax call to delete this user
                $.ajax({
                    headers:
                        {
                            'X-CSRF-TOKEN':
                                $('meta[name="csrf-token"]').attr('content')
                        },
                    type: "post",
                    url: "{{ route('admin.lead.destroy') }}",
                    data:
                        {
                            id: id
                        },
                    cache: false,
                    datatype: "json",
                    success: function (data) {
                        $('#' + id).hide();
                        alertify.set('notifier', 'position', 'top-center');
                        alertify.success('You have successfully deleted this lead!!');
                        
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
