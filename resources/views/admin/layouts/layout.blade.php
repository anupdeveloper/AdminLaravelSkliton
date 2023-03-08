<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Awaser</title>

    <link rel="stylesheet" href="{{asset('/assets_front/style.css')}}">
    <link rel="shortcut icon" href="{{asset('/assets_admin/images/favicon-32x32.png')}}" type="image/x-icon">
    <link rel="icon" href="{{asset('/assets_admin/images/favicon-32x32.png')}}" type="image/x-icon">


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets_admin/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets_admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('assets_admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">


@if(session('locale')=='ar')
    <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet"
              href="{{asset('/assets_admin/plugins/tempusdominus-bootstrap-4/css/rtl/tempusdominus-bootstrap-4.min.rtl.css')}}">
        <!-- iCheck -->
        <link rel="stylesheet"
              href="{{asset('/assets_admin/plugins/icheck-bootstrap/rtl/icheck-bootstrap.min.rtl.css')}}">
        <!-- JQVMap -->
        <link rel="stylesheet" href="{{asset('/assets_admin/plugins/jqvmap/rtl/jqvmap.min.rtl.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('/assets_admin/dist/css/rtl/adminlte.min.rtl.css')}}">
        <!-- overlayScrollbars -->
        <link rel="stylesheet"
              href="{{asset('/assets_admin/plugins/overlayScrollbars/css/rtl/OverlayScrollbars.min.rtl.css')}}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{asset('/assets_admin/plugins/daterangepicker/daterangepicker.css')}}">
        <!-- summernote -->
        <link rel="stylesheet" href="{{asset('/assets_admin/plugins/summernote/rtl/summernote-bs4.min.rtl.css')}}">

        <link rel="stylesheet" href="{{asset('/assets_admin/ar/rtl.css')}}">
        <style>
            ul.navbar-nav.ml-auto {
                position: absolute;
                left: 23px;
            }
        </style>
@else

    <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet"
              href="{{asset('/assets_admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{asset('/assets_admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
        <!-- JQVMap -->
        <link rel="stylesheet" href="{{asset('/assets_admin/plugins/jqvmap/jqvmap.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('/assets_admin/dist/css/adminlte.min.css')}}">
        <!-- overlayScrollbars -->
        <link rel="stylesheet"
              href="{{asset('/assets_admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{asset('/assets_admin/plugins/daterangepicker/daterangepicker.css')}}">
        <!-- summernote -->
        <link rel="stylesheet" href="{{asset('/assets_admin/plugins/summernote/summernote-bs4.min.css')}}">

    @endif

    <script src="{{ asset('assets_admin/axios/dist/axios.min.js') }}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" type="text/javascript"></script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    @notifyCss

    @stack('links')
    @stack('script-header')
    <style>
        h1.page-title {
            font-size: 15px;
            margin-bottom: 30px;
        }

        .right-btn {
            float: right;
            margin-top: 30px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0 !important;
        }

        a.language-tab {
            display: inline-block;
            padding: 7px;
            color: #000;
            cursor: pointer;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader -->
{{-- <div class="preloader flex-column justify-content-center align-items-center">
  <img class="animation__shake" src="{{asset('assets_admin/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo"
    height="60" width="60">
</div> --}}

<!-- Navbar -->
    <nav {{ session('locale')=='ar' ?'dir=rtl':'' }} class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            {{-- <li class="nav-item d-none d-sm-inline-block">
              <a href="{{asset('assets_admin/index3.html')}}" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
              <a href="#" class="nav-link">Contact</a>
            </li> --}}
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    @if(Auth::check() && Auth::user()->username)
                        @php
                        $notification = \App\Models\Notification::where('user_id', auth()->user()->id)->orderBy('created_at', 'Desc')->get();
                        @endphp
                        <span
                            class="badge badge-danger badge-counter">{{ $notification->count() > 0 ? $notification->count() : '' }}</span>
                    @endif
                </a>
                <!-- Dropdown - Alerts -->
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header"> Notifications</span>
                    @if( Auth::user()->username)
                        @foreach($notification as $key=>$value)
                            <a href="{{asset('users/'.$value->data)}}" class=" dropdown-item">
                                <i class="fas fa-download mr-2"></i> {{$value->data}}
                                <span
                                    class="float-right text-muted text-sm">{{\Carbon\Carbon::parse($value->created_at)->format('M jS, Y h:m a')}}</span>
                            </a>
                            <span class="dropdown-header"></span>
                            <div class="dropdown-divider"></div>
                        @endforeach
                    @endif
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        {{-- <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li> --}}

        <!-- Language translate -->
            {{-- <li class="nav-item">
                @if(App::getLocale() == 'ar')
                    <a href="{{ route('changeLanguage',['locale'=>'en']) }}" role="button" class="language-tab">
                        EN
                    </a>
                @else
                    <a href="{{ route('changeLanguage',['locale'=>'ar']) }}" role="button" class="language-tab">
                        AR
                    </a>
                @endif
            </li> --}}

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.resetpassword') }}">
                    {{ __('api.admin.User.labels.reset_password') }}
                </a>
            </li>

        </ul>
    </nav>

    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="{{asset('/assets_front/img/logo.png')}}" alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Awaser</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{asset('/assets_admin/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2"
                         alt="User Image">
                </div>
                @if(Auth::check() && Auth::user()->username)
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->username }}</a>
                    </div>
                @endif
            </div>

            <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div> --}}

        <!-- Sidebar Menu -->
        @include('admin.layouts.sidebar_menu')
        <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
{{-- <footer class="main-footer">
  <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
  All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 3.1.0
  </div>
</footer> --}}

<!-- Control Sidebar -->
{{-- <aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside> --}}
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<!-- jQuery -->
<script src="{{asset('/assets_admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('/assets_admin/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('/assets_admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- DataTables  & Plugins -->
<script src="{{ asset('/assets_admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets_admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets_admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('/assets_admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets_admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/assets_admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets_admin/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('/assets_admin/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('/assets_admin/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('/assets_admin/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/assets_admin/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('/assets_admin/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>


@stack('scripts')

<!-- ChartJS -->
<script src="{{asset('/assets_admin/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<!-- <script src="{{asset('/assets_admin/plugins/sparklines/sparkline.js')}}"></script> -->
<!-- JQVMap -->
<script src="{{asset('/assets_admin/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('/assets_admin/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('/assets_admin/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('/assets_admin/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('/assets_admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script
    src="{{asset('/assets_admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('/assets_admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('/assets_admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/assets_admin/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('/assets_admin/dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('/assets_admin/dist/js/pages/dashboard.js')}}"></script>


{{-- alertify begin --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css"
      integrity="sha512-IXuoq1aFd2wXs4NqGskwX2Vb+I8UJ+tGJEu/Dc0zwLNKeQ7CW3Sr6v0yU3z5OQWe3eScVIkER4J9L7byrgR/fA=="
      crossorigin="anonymous" referrerpolicy="no-referrer"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"
        integrity="sha512-JnjG+Wt53GspUQXQhc+c4j8SBERsgJAoHeehagKHlxQN+MtCCmFDghX9/AcbkkNRZptyZU4zC8utK59M5L45Iw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

{{--
<link rel="stylesheet" type="text/css" href="{{asset('flip_assets/alertifyjs/css/alertify.min.css')}}"> --}}
{{--
<script src="{{asset('flip_assets/alertifyjs/alertify.min.js')}}"></script> --}}

@if (Session::has('success'))
    <script>
        alertify.set('notifier', 'position', 'top-center');
        alertify.success('{{ Session::get('success') }}');
    </script>
@elseif(Session::has('message'))
    <script>
        alertify.set('notifier', 'position', 'top-center');
        alertify.warning('{{ Session::get('message') }}');
    </script>
@endif

{{-- alertify end --}}





@stack('script-footer')


<script>
    window.onload = function () {
        let url = location.href
        url = url.match(/https?:\/\/[a-z\.\:0-9]+\/[a-z\-]+\/[a-z\-]+/)[0]
        // console.log('url_arr',url_arr);
        let sidebar_anchors = document.querySelector('div[class="os-content"]')
        console.log('windoe onload');

        let anchor = sidebar_anchors.querySelector(`a[href^="${url}"]`)
        // console.log('anchor',anchor);

        if (anchor) {
            anchor.setAttribute('class', 'nav-link active')
            parent_li = anchor.parentElement.parentElement

            if (parent_li && parent_li.classList.contains('nav-treeview')) {
                console.log('nav-tree');
                parent_li = parent_li.parentElement
            } else {
                parent_li = null
            }
            console.log('parent_li', parent_li);
            parent_li_a = parent_li.querySelector('a[href="#"]')
            console.log('parent_li_a', parent_li_a);
            if (parent_li_a) {
                parent_li.setAttribute('class', 'nav-item menu-is-opening menu-open')

                console.log('parent_li_a', parent_li_a);
                if (parent_li_a) {
                    parent_li_a.setAttribute('class', 'nav-link active')

                }
            }
        }
    }


    // class Session{
    //   session_name=null
    //   constructor(session_name){
    //     this.session_name=session_name
    //     sessionStorage.setItem(session_name,[])
    //   }

    //   add=(item)=>{
    //       let items= sessionStorage.getItem(this.session_name)
    //       items.push(item)
    //       sessionStorage.setItem(this.session_name,)
    //   }
    //   exists=(item)=>{
    //     let items= sessionStorage.getItem(this.session_name)
    //     return items.find((itm)=>{
    //       return itm===item
    //     })
    //   }

    // }


    // const handleAnchorOnclick=(e,anchor)=>{
    //   e.preventDefault();
    //   console.log(anchor);
    //   const session=new Session('anchors')
    //   session.add(anchor)
    //   console.log(session.exists(anchor));


    // }

    // window.onload=function (){
    //   let sidebar_anchors_div=document.querySelector('div[class="os-content"]')
    //   let anchors=sidebar_anchors_div.querySelectorAll('a')
    //   // console.log(anchors.length);

    //   if(anchors.length){
    //     [...anchors].map(anchor=>{
    //       // console.log(anchor);
    //       anchor.onclick=(e)=>{
    //         handleAnchorOnclick(e,anchor)
    //       }
    //     })
    //   }

    // }


</script>
<x:notify-messages/>
@notifyJs
</body>

</html>
