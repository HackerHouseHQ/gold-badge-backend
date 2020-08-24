 <html>
   <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GOLD BADGE|Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('admin_css/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('admin_css/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('admin_css/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('admin_css/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_css/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_css/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_css/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_css/plugins/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_css/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_css/plugins/daterange/daterange.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_css/plugins/css/datepicker.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('admin_css/css/media.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('admin_css/css/bootstrap.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('admin_css/css/style.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('admin_css/css/custom.css')}}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <link rel="/stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="{{ asset('admin_css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet"/>
   </head>
   <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
          @include('admin_dash.sidebar')
          @yield('content')
          @include('admin_dash.footer')
        </div>
        <script src="{{ asset('admin_css/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <script>
          $.widget.bridge('uibutton', $.ui.button)
        </script>
        <script src="{{ asset('admin_css/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('admin_css/plugins/chart.js/Chart.js') }}"></script>
        <script src="{{ asset('admin_css/plugins/sparklines/sparkline.js') }}"></script>
        <script src="{{ asset('admin_css/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
        <script src="{{ asset('admin_css/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
        <script src="{{ asset('admin_css/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
        <script src="{{ asset('admin_css/plugins/moment/moment.min.js') }}"></script>
        <script src="{{ asset('admin_css/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <script src="{{ asset('admin_css/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
        <script src="{{ asset('admin_css/plugins/summernote/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('admin_css/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <script src="{{ asset('admin_css/dist/js/adminlte.js') }}"></script>
        <script src="{{ asset('admin_css/dist/js/pages/dashboard.js') }}"></script>
        <script src="{{ asset('admin_css/dist/js/demo.js') }}"></script>
        <script src="{{ asset('admin_css/dist/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('admin_css/plugins/datatables/jquery.dataTables.js')}}"></script>
        <script src="{{ asset('admin_css/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
        <script src="{{ asset('admin_css/dist/js/pages/dashboard3.js')}}"></script>
        <script src="{{ asset('admin_css/dist/sweetalert/sweetalert.min.js') }}"></script>
        <script src="{{ asset('admin_css/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
        <script src="{{ asset('admin_css/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
        <!-- bs-custom-file-input -->
     @yield('script')
   </body>
 </html>
