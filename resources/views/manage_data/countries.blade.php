@extends('admin_dash.main')
<style type="text/css">
  .a1 {
    width: 37px;
    margin-top: -19px;

  }

  .a2 {

    width: 335px;
    margin-top: -19px;


  }

  .a3 {

    width: 747;
    margin-top: -19px;


  }
</style>
@section('content')
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Manage Data</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">Country</li>
            </ol>
          </nav>
        </div>


        <div class="col-lg-6 col-5 text-right">
          {{-- <a href="#" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#department" id="sideshow">Add
            Department</a> --}}
          {{-- <a href="#" class="btn btn-sm btn-neutral">New</a>
          <a href="#" class="btn btn-sm btn-neutral">Filters</a> --}}
          <div class="row-lg-6 row-5">
            <a href="{{route('countries')}}" class="btn btn-sm btn-neutral"
              style="background-color:#fb6340;color:#fff;">Manage Countries</a>
            <a href="{{route('ethnicity')}}" class="btn btn-sm btn-neutral">Manage Ethnicity</a>
            <a href="{{route('gender')}}" class="btn btn-sm btn-neutral">Gender</a>
            <a href="{{route('report')}}" class="btn btn-sm btn-neutral">Report Reason Type</a>

          </div>
          <!--          <div class="row-lg-6  row-5" style="float: right;">
            <div class="btn-toolbar">
              <div class="btn-group">
                <a href="{{route('add_country_page')}}" class="btn btn-sm btn-neutral">add new country</a>
                <a href="{{route('add_state_page')}}" class="btn btn-sm btn-neutral">add new state</a>
                <a href="{{route('add_city_page')}}" class="btn btn-sm btn-neutral">add new city</a>
                <a href="{{route('add_ethnicity_page')}}" class="btn btn-sm btn-neutral">add new ethnicity</a>
              </div>
            </div>
          </div>-->

          {{-- <a href="#" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#department" id="sideshow">Add
            Department</a> --}}
        </div>

      </div>
    </div>
  </div>
</div>
<div class="container-fluid mt--6">
  <!-- Table -->
  <div class="row">
    <div class="col">
      <div class="card">
        <!-- Card header -->



        <div class="card-body">
          <div class="card-header" style="border-bottom: 1px solid #6073e4 ">
            <div class="row">
              <div class="col-3">
                <button type="button" class="btn btn-default"> <a
                    style="background-color: #fb6340; color:#fff;font-size: 15px;" href="{{route('add_country_page')}}"
                    class="btn btn-sm btn-neutral">Add Country +</a></button>
              </div>
              <div class="col-3">
                <button type="button" class="btn btn-default"> <a
                    style="background-color: #e4bd46;  color:#fff;font-size: 15px;" href="{{route('add_state_page')}}"
                    class="btn btn-sm btn-neutral">Add State +</a></button>
              </div>

              <div class="col-3">
                <button type="button" class="btn btn-default"> <a
                    style="background-color: #e4bd46;  color:#fff;font-size: 15px;" href="{{route('add_city_page')}}"
                    class="btn btn-sm btn-neutral">Add City +</a></button>
              </div>
              <div class="col-3">
                <button type="button" class="btn btn-default"><a
                    style="background-color: #e4bd46;  color:#fff;font-size: 15px;"
                    href="{{route('add_ethnicity_page')}}" class="btn btn-sm btn-neutral">Add Ethnicity +</a></button>
              </div>
              <div class="col-3 py-2">
                <button type="button" class="btn btn-default"><a
                    style="background-color: #e4bd46;  color:#fff;font-size: 15px;"
                    href="{{route('showAddReportform')}}" class="btn btn-sm btn-neutral">Add Rating Question
                    +</a></button>
              </div>
            </div>


          </div>
        </div>


        <div class="table-responsive py-4">
          <table class="table table-flush" id="datatable-basic">
            <thead class="thead-light">
              <tr>
                <th>#</th>
                <th>Country</th>
                <th>State</th>
                <th>City</th>
                <th>Action</th>
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

{{-- model view city --}}
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-capitalize" id="businessName"> City List</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <div>
                <table class="table table-bordered table-hover">
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
<div class="modal fade" id="EditCitymodel1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="width:100%">
      <div class="modal-header">
        <h4 class="modal-title text-capitalize" id="businessName"> Edit City </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <!--<div class="table-responsive">-->
            <div class="">
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
                <div class="row">
                  <div class="col-2">
                    <span class="tbl_row">SN.</span>
                  </div>
                  <div class="col-7">
                    <span class="tbl_row">City Name</span>
                  </div>
                  <div class="col-3">
                    <span class="tbl_row">Action</span>
                  </div>
                </div>
                <!--              <form action="http://localhost/gold_badge/public/manage_data/editCityModelView" method="GET">
                   2 
                  <input type="hidden" value="2" name="city_id">
                  <lable>ddsf</lable>
                  <input type="text" class="input_tag" value="gorakhpur" name="city_name">
                  <button type="submit" class="btn btn-secondary">Save</button>
                  </form>-->
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
<div class="modal fade" id="viewDepartmentModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="width:150%">
      <div class="modal-header">
        <h4 class="modal-title text-capitalize" id="businessName">Country Department List</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <div>
                <table class="table table-bordered table-hover">
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
@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
  var dataTable = $('#datatable-basic').DataTable({
    language: {
      searchPlaceholder: "Country , State Name",
      paginate: {
          previous: '<i class="fas fa-angle-left"></i>',
          next:     '<i class="fas fa-angle-right"></i>'
      },
      aria: {
          paginate: {
              previous: 'Previous',
              next:     'Next'
          }
      }
  },
     "searching": true,
     'processing': true,
     'serverSide': true,
     "bFilter": true,
     "bInfo": true,
     "lengthChange": true,
     "bAutoWidth": true,
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
                 
                   <div class="row">
                   <div class="col-2">
          ${++i} 
                  <input type="hidden" value="${value.id}" name="city_id">
                          </div>
                      <div class="col-7">
                  <input type="text" class="input_tag" value="${value.city_name}" name="city_name">
                      </div>
                      <div class="col-3">
                  <button type="submit" class="btn btn-secondary">Save</button>
                      </div>
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
          </tr>
          <tr>
             <td> 2 </td>
             <td class="text-capitalize"> India</td>
             <td class="text-capitalize">UP</td>
             <td class="text-capitalize">Varanasi</td>
             <td class="text-capitalize">Rating 4</td>
             <td class="text-capitalize">120 reviews</td>
             <td class="text-capitalize">10 badges</td>
          </tr>
          <tr>
             <td> 3 </td>
             <td class="text-capitalize"> India</td>
             <td class="text-capitalize">UP</td>
             <td class="text-capitalize">Varanasi</td>
             <td class="text-capitalize">Rating 4</td>
             <td class="text-capitalize">120 reviews</td>
             <td class="text-capitalize">10 badges</td>
          </tr>
          <tr>
             <td> 4 </td>
             <td class="text-capitalize"> India</td>
             <td class="text-capitalize">UP</td>
             <td class="text-capitalize">Varanasi</td>
             <td class="text-capitalize">Rating 4</td>
             <td class="text-capitalize">120 reviews</td>
             <td class="text-capitalize">10 badges</td>
          </tr>
          <tr>
             <td> 5 </td>
             <td class="text-capitalize"> India</td>
             <td class="text-capitalize">UP</td>
             <td class="text-capitalize">Varanasi</td>
             <td class="text-capitalize">Rating 4</td>
             <td class="text-capitalize">120 reviews</td>
             <td class="text-capitalize">10 badges</td>
          </tr>
          <tr>
             <td> 6 </td>
             <td class="text-capitalize"> India</td>
             <td class="text-capitalize">UP</td>
             <td class="text-capitalize">Varanasi</td>
             <td class="text-capitalize">Rating 4</td>
             <td class="text-capitalize">120 reviews</td>
             <td class="text-capitalize">10 badges</td>
          </tr>

        `;
        $('#viewDepartment').append(row)
        $('#viewDepartmentModel').modal('show');
      }
</script>
@endsection