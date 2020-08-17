@extends('admin_dash.main')
 @section('content')
    <div class="col-sm-12">
     <div class="content-wrapper custom-content-wrapper">
      <div class="below_content_clss">
        <section class="content home_conntent">
          <div class="container-fluid">
            {{-- main header for show list --}}
          <div class="row">
          <div class="main_menu_three_tabs">
           <ul class="nav nav-tabs abc">
            <li class="active" onclick="booking_data(1)"><a data-toggle="tab"  href="#menu1">Manage Countries</a></li>
            <li onclick="booking_data(2)"><a data-toggle="tab" href="#menu1">Manage Ethnicity</a></li>
           <li onclick="booking_data(3)"><a data-toggle="tab" href="#menu1">Gender</a></li>
           <li onclick="booking_data(3)"><a data-toggle="tab" href="#menu1">Report Reason Type</a></li>
           </ul>
         </div>
         </div>
         {{-- close --}}
         {{-- add city country gender report reason --}}
         <div class="row">
          <div class="main_menu_add_tabs">
           <ul class="nav space_in_li xyy">
            <li><a href="{{route('add_country_page')}}">Manage Countries<img src="{{ asset('admin_css/images/add_people.png')}}"></a></li>
            <li><a href="#">Manage Ethnicity<img src="{{ asset('admin_css/images/add_people.png')}}"></a></li>
           <li><a href="#">Gender<img src="{{ asset('admin_css/images/add_people.png')}}"></a></li>
           <li><a href="#">Report Reason Type<img src="{{ asset('admin_css/images/add_people.png')}}"></a></li>
          </ul>
          </div>
         </div>
         {{-- close --}}
          </div>
        </section>
      </div>
      </div>
    </div>
  @endsection
  @section('script')
@endsection
