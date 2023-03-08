@push('links')
      <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('assets_admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets_admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets_admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endpush

@push('scripts')
<!-- DataTables  & Plugins -->
<script src="{{asset('assets_admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets_admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets_admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets_admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets_admin/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets_admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets_admin/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('assets_admin/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('assets_admin/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{asset('assets_admin/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets_admin/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets_admin/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

@endpush