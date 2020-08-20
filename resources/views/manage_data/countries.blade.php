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
            <li class="active"><a href="{{route('countries')}}">Manage Countries</a></li>
            <li><a href="{{route('ethnicity')}}">Manage Ethnicity</a></li>
           <li><a href="{{route('gender')}}">Gender</a></li>
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
         {{-- table data --}}
         <br>
{{--          <div class="row">
          <div class="col-md-12">
            <div class="card table_cardd class_scroll">
             <div class="card-body p-0">
             <table class="table table-bordered" id="data1">
               <thead>
                <tr>
                  <th><span class="tbl_row">Country NAME</span></th>
                  <th><span class="tbl_row">State Name</span></th>
                  <th><span class="tbl_row">City Names</span></th>
                  <th></th>
                  <th></th>
                 </tr>
                </thead>
                <tbody></tbody>
               </table>
              </div>
             </div>
            </div>
           </div> --}}
        {{--  <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <table id="data1" class="table table-bordered table-hover">
                <thead> --}}
        <div class="row">
        <div class="col-12">
          <div class="card class_scroll ">
            <div class="card-body p-0">
              <table id="data1" class="table table-bordered table-hover">
               <thead>
                <tr>
                  <th><span class="tbl_row">SN.</span></th>
                  <th><span class="tbl_row">Country NAME</span></th>
                  <th><span class="tbl_row">State Name</span></th>
                  <th><span class="tbl_row">City Names</span></th>
                  <th><span class="tbl_row"></span></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
             </div>
           </div>
         </div>
       </div>
          </div>
        </section>

                 {{-- model view city --}}
          <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title text-capitalize" id="businessName"></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                 </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <div id="businessDetails">
                      </div>
                     </div>
                  </div>
                </div>
              </div>
             </div>
            </div>
          </div>
        {{-- end model view city --}}

      </div>
      </div>
    </div>
  @endsection
  @section('script')
  <script type="text/javascript">
  $(document).ready(function(){
  var dataTable = $('#data1').DataTable({
     "searching": false,
     'processing': true,
     'serverSide': true,
    "bFilter": true,
    "bInfo": false,
    "lengthChange": false,
    "bAutoWidth": false,
    'ajax': {
       'url':"{{route('countryList')}}",
       'data': function(data){
        
       }
    },
    'columns': [
        { data: 'SN' } ,
        { data: 'country_name' } ,
        { data: 'state_name' },
        { data: 'city_name' },
        { data: 'view' },
        // { data: 'view' },
    ]
  });
});
</script>
<script type="text/javascript">
  function viewCityModel(id){
    alert(id);
     $.ajax({
          url: "{{ route('viewCityModel') }}/" + id, 
          type: 'get',
          success: function (response) {
          if(response.data.length) {
              $('#businessDetails').html('');
              $.each(response.data, function(key, value){
                let row = `
                <tr>
                  <td> ${response.from++} </td>
                  <td class="text-capitalize"> ${value.business_name} </td>
                  <td></td>
                 </tr>
                `;
                $('#businessDetails').append(row)
              })
                        
            } else {
              let row = `
                <tr>
                  <td colspan="7"> Record not found! </td>
                </tr>
                `;
                $('#businessDetails').html(row);
            }

          
        },
        error: function(err) {
          console.log(err);
        }
      });
  }
</script>
@endsection
