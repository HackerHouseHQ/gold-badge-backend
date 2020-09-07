@extends('admin_dash.main')
<style type="text/css">
  .a1{
    width: 37px;
      margin-top: -19px;

  }
  .a2{
       
    width: 335px;
    margin-top: -19px;


  }
  .a3{
       
    width: 747;
    margin-top: -19px;


  }
   
</style>
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
               
                  <div class="card-body">
               <input class="form-control form-control-sm" id="search" type="text" placeholder="Search  Country">
             </div>
        <div class="row">
        <div class="col-12">
          <div class="card class_scroll ">
            <div class="card-body p-0">
              <table id="data1" class="table table-bordered table-hover">
               <thead>
                <tr>
                  <th><span class="tbl_row">#</span></th>
                  <th><span class="tbl_row">Country</span></th>
                  <th><span class="tbl_row">State</span></th>
                  <th><span class="tbl_row">City</span></th>
                  <th><span class="tbl_row">Action</span></th>
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
                      <div>
                        <table  class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th><span class="tbl_row">SN.</span></th>
                              <th> <span class="tbl_row">City Name</span> </th>
                            </tr>
                          </thead>
                          <tbody id="businessDetails">
                            
                          </tbody>
                        </table>
                      </div>
                     </div>
                  </div>
                </div>
              </div>
             </div>
            </div>
          </div>
        {{-- end model view city --}}
        {{-- model Edit city --}}
          <div class="modal fade" id="EditCitymodel1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content" style="width:113%">
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
                      <div>
                        {{-- <form action="{{route('editCityModelView')}}" method ="GET"> --}}
                      {{--   <table  class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th><span class="tbl_row">SN.</span></th>
                              <th> <span class="tbl_row">City Name</span> </th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody id="EditCity">
                            
                          </tbody>
                         
                        </table> --}}
                              <div class="a1">
                                 <span class="tbl_row">SN.</span>
                              </div>
                              <div class="a2">
                                <span class="tbl_row">City Name</span> 
                              </div>
                              <div class="a3">
                                <span class="tbl_row">Action</span> 
                              </div>
                              <br>
                               <div id="EditCity"></div>
                          
                      {{-- </form> --}}

                         
                      </div>
                     </div>
                  </div>
                </div>
              </div>
             </div>
            </div>
          </div>
        {{-- end model Edit city --}}
         {{-- model view department --}}
          <div class="modal fade" id="viewDepartmentModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content" style="width:150%">
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
                      <div>
                        <table  class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th><span class="tbl_row">SN.</span></th>
                              <th> <span class="tbl_row">Department Name</span> </th>
                              <th> <span class="tbl_row">State</span> </th>
                              <th> <span class="tbl_row">City</span> </th>
                              <th> <span class="tbl_row">Avg Rating</span> </th>
                              <th> <span class="tbl_row">Reviews</span> </th>
                              <th> <span class="tbl_row">No. of badges</span> </th>
                            </tr>
                          </thead>
                          <tbody id="viewDepartment">
                            
                          </tbody>
                         
                        </table>
              

                         
                      </div>
                     </div>
                  </div>
                </div>
              </div>
             </div>
            </div>
          </div>
        {{-- end model view department --}}

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
        var search = $('#search').val();
          data.search = search;
        
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
  $('#search').keyup(function(){
     dataTable.draw();
  });
});
</script>
<script type="text/javascript">
  function viewCityModel1(id){
    // alert(id);
     $.ajax({
          url: "{{ route('viewCityModel') }}/" + id, 
          type: 'get',
          success: function (response) {
            console.log(response);
          if(response) {
              $('#businessDetails').html('');
              var i = 0;
              $.each(response, function(key, value){
                let row = `
                <tr>
                  <td> ${++i} </td>
                  <td class="text-capitalize">${value.city_name}</td>
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
             $('#exampleModalCenter').modal('show');
        },
        error: function(err) {
          console.log(err);
        }
      });
  }  

    function EditCityModel1(id){
    // alert(id);
     $.ajax({
          url: "{{ route('viewCityModel') }}/" + id, 
          type: 'get',
          success: function (response) {
            console.log(response);
          if(response) {
              $('#EditCity').html('');
              var i = 0;
              $.each(response, function(key, value){
                let row = `
                
                    <form action="{{route('editCityModelView')}}" method ="GET">
                   ${++i} 
                  <input type="hidden" value="${value.id}" name="city_id">
                  <input type="text" class="input_tag" value="${value.city_name}" name="city_name">
                  <button type="submit" class="btn btn-secondary">Save</button>
                  </form>
                
                `;
                $('#EditCity').append(row)
              })
            } else {
              let row = `
                <tr>
                  <td colspan="7"> Record not found! </td>
                </tr>
                `;
                $('#EditCity').html(row);
            }
             $('#EditCitymodel1').modal('show');
        },
        error: function(err) {
          console.log(err);
        }
      });
  }
   function viewDepartmentModel1(id){
    // alert(id);
      $('#viewDepartment').html('');
        var i = 0;
        let row = `
          <tr>
             <td> 1 </td>
             <td class="text-capitalize"> India</td>
             <td class="text-capitalize">UP</td>
             <td class="text-capitalize">Varanasi</td>
             <td class="text-capitalize">Rating 4</td>
             <td class="text-capitalize">120 reviews</td>
             <td class="text-capitalize">10 badges</td>
             <td></td>
          </tr>
          <tr>
             <td> 2 </td>
             <td class="text-capitalize"> India</td>
             <td class="text-capitalize">UP</td>
             <td class="text-capitalize">Varanasi</td>
             <td class="text-capitalize">Rating 4</td>
             <td class="text-capitalize">120 reviews</td>
             <td class="text-capitalize">10 badges</td>
             <td></td>
          </tr>
          <tr>
             <td> 3 </td>
             <td class="text-capitalize"> India</td>
             <td class="text-capitalize">UP</td>
             <td class="text-capitalize">Varanasi</td>
             <td class="text-capitalize">Rating 4</td>
             <td class="text-capitalize">120 reviews</td>
             <td class="text-capitalize">10 badges</td>
             <td></td>
          </tr>
          <tr>
             <td> 4 </td>
             <td class="text-capitalize"> India</td>
             <td class="text-capitalize">UP</td>
             <td class="text-capitalize">Varanasi</td>
             <td class="text-capitalize">Rating 4</td>
             <td class="text-capitalize">120 reviews</td>
             <td class="text-capitalize">10 badges</td>
             <td></td>
          </tr>
          <tr>
             <td> 5 </td>
             <td class="text-capitalize"> India</td>
             <td class="text-capitalize">UP</td>
             <td class="text-capitalize">Varanasi</td>
             <td class="text-capitalize">Rating 4</td>
             <td class="text-capitalize">120 reviews</td>
             <td class="text-capitalize">10 badges</td>
             <td></td>
          </tr>
          <tr>
             <td> 6 </td>
             <td class="text-capitalize"> India</td>
             <td class="text-capitalize">UP</td>
             <td class="text-capitalize">Varanasi</td>
             <td class="text-capitalize">Rating 4</td>
             <td class="text-capitalize">120 reviews</td>
             <td class="text-capitalize">10 badges</td>
             <td></td>
          </tr>

        `;
        $('#viewDepartment').append(row)
        $('#viewDepartmentModel').modal('show');
      }
</script>
@endsection
