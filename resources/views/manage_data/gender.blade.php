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
            <li><a href="{{route('countries')}}">Manage Countries</a></li>
            <li ><a href="{{route('ethnicity')}}">Manage Ethnicity</a></li>
           <li class="active"><a href="{{route('gender')}}">Gender</a></li>
           <li><a href="{{route('report')}}">Report Reason Type</a></li>
           </ul>
         </div>
         </div>
         {{-- close --}}
         {{-- add city country gender report reason --}}
         <div class="row">
          <div class="main_menu_add_tabs">
           <ul class="nav space_in_li xyy">
            <li><a href="{{route('add_country_page')}}">add new country<img src="{{ asset('admin_css/images/add_people.png')}}"></a></li>
            <li><a href="{{route('add_state_page')}}">add new state<img src="{{ asset('admin_css/images/add_people.png')}}"></a></li>
           <li><a href="{{route('add_city_page')}}">add new city<img src="{{ asset('admin_css/images/add_people.png')}}"></a></li>
           <li><a href="{{route('add_ethnicity_page')}}">add new ethnicity<img src="{{ asset('admin_css/images/add_people.png')}}"></a></li>
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
