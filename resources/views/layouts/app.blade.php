<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
  <div id="app">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
          <span class="sr-only">Toggle Navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">
        </a>
      </div>
      <div class="collapse navbar-collapse" id="app-navbar-collapse">
        <ul class="nav navbar-nav">&nbsp;</ul>
        <ul class="nav navbar-nav navbar-right">@guest
          @else
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
              {{ Auth::user()->name }} <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </li>
            </ul>
          </li>
          @endguest
        </ul>
      </div>
    </div>
    @yield('content')
  </div>

  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('admin_css/plugins/jquery/jquery.min.js') }}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
  {{-- <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script> --}}

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link type="text/css" rel="stylesheet" href="{{asset('admin_css/css/custom.css')}}">
  <link type="text/css" rel="stylesheet" href="{{asset('admin_css/css/custom_media.css')}}">
</body>

</html>