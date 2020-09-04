<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>Gold Badge</title>
  <!-- Favicon -->
  <link rel="icon" href="{{asset('admin_new/assets/img/brand/favicon.png')}}" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="{{asset('admin_new/assets/vendor/nucleo/css/nucleo.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('admin_new/assets/vendor/fortawesome/fontawesome-free/css/all.min.css')}}"
    type="text/css">
  
   <!-- summernote -->
   <link rel="stylesheet" href="{{ asset('admin_new/assets/css/summernote-bs4.css') }}">
   
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{asset('admin_new/assets/css/argon.css?v=1.2.0')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('admin_new/assets/vendor/nucleo/css/nucleo.css')}}" type="text/css">
 
  <script src="{{asset('admin_new/assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}"></script>
  <!-- Page plugins -->
  <link rel="stylesheet"
    href="{{asset('admin_new/assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet"
    href="{{asset('admin_new/assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}">
  <link rel="stylesheet"
    href="{{asset('admin_new/assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}">
  <!-- Google Tag Manager -->
  <script>
    (function (w, d, s, l, i) {
              w[l] = w[l] || [];
              w[l].push({
                  'gtm.start': new Date().getTime(),
                  event: 'gtm.js'
              });
              var f = d.getElementsByTagName(s)[0],
                  j = d.createElement(s),
                  dl = l != 'dataLayer' ? '&l=' + l : '';
              j.async = true;
              j.src =
                  'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
              f.parentNode.insertBefore(j, f);
          })(window, document, 'script', 'dataLayer', 'GTM-NKDMSK6');
  </script>
  <!-- End Google Tag Manager -->
  <style>
      .navbar-vertical.navbar-expand-xs .navbar-nav > .nav-item > .nav-link.active {
          background: #e2b52dd1 !important;
      }
      .userDetailsColor{
          color: #8898aa;
      }
      </style>
</head>

<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0"
      style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  @include('admin_dash.sidebar')
  <div class="main-content" id="panel">
    <!-- Topnav -->
    @include('admin_dash.header')
    @yield('content')
    {{-- @include('admin_dash.footer') --}}
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{asset('admin_new/assets/vendor/jquery/dist/jquery.min.js')}}">
  </script>
  <script src="{{asset('admin_new/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('admin_new/assets/vendor/js-cookie/js.cookie.js')}}"></script>
  <script src="{{asset('admin_new/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js')}}"></script>
  <script src="{{asset('admin_new/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')}}"></script>
  <!-- Optional JS -->
  <script src="{{asset('admin_new/assets/vendor/chart.js/dist/Chart.min.js')}}"></script>
  <script src="{{asset('admin_new/assets/vendor/chart.js/dist/Chart.extension.js')}}"></script>
  <script src="{{asset('admin_new/assets/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('admin_new/assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{asset('admin_new/assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
  <script src="{{asset('admin_new/assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
   <!-- Datepicker -->
   <script src="{{asset('admin_new/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

   <script src="{{ asset('admin_new/assets/js/summernote-bs4.min.js') }}"></script>
   
  <script src="{{asset('admin_new/assets/vendor/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
  <script src="{{asset('admin_new/assets/vendor/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
  <script src="{{asset('admin_new/assets/vendor/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
  <script src="{{asset('admin_new/assets/vendor/datatables.net-select/js/dataTables.select.min.js')}}"></script>
  <!-- Argon JS -->
  <script src="{{asset('admin_new/assets/js/argon.min.js?v=1.2.0')}}"></script>
  {{--  --}}

  <!-- Optional JS -->

  <!-- Argon JS -->
  <script src="{{asset('admin_new/assets/js/argon.js?v=1.2.0')}}"></script>
 <script>
  $(function () {
    // Summernote
    $('.textarea').summernote()
  })
</script>
  @yield('script')
</body>

</html>