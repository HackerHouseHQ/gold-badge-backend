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

  .modal-body.custom_modal_body {
    padding-bottom: 0px;
  }

  .modal-header.custom_modal_header {
    padding-bottom: 0px;
  }
</style>
@section('content')
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-sm-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Manage Data</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">Country</li>
            </ol>
          </nav>
        </div>


        <div class="col-sm-6 col-5 text-right">
            <a href="{{route('countries')}}" class="btn btn-sm btn-neutral  mb-1"
              style="background-color:#fb6340;color:#fff;">Manage Countries</a>
            <a href="{{route('ethnicity')}}" class="btn btn-sm btn-neutral mb-1">Manage Ethnicity</a>
            <a href="{{route('gender')}}" class="btn btn-sm btn-neutral mb-1">Gender</a>
            <a href="{{route('report')}}" class="btn btn-sm btn-neutral mb-1">Report Reason Type</a>
            <a href="{{route('report-message')}}" class="btn btn-sm btn-neutral mb-1">Report</a>
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
              <div class="col-sm-3">
                <button type="button" class="btn btn-default"> <a
                    style="background-color: #fb6340; color:#fff;font-size: 15px;" href="{{route('add_country_page')}}"
                    class="btn btn-sm btn-neutral">Add Country +</a></button>
              </div>
              <div class="col-sm-3">
                <button type="button" class="btn btn-default"> <a
                    style="background-color: #e4bd46;  color:#fff;font-size: 15px;" href="{{route('add_state_page')}}"
                    class="btn btn-sm btn-neutral">Add State +</a></button>
              </div>

              <div class="col-sm-3">
                <button type="button" class="btn btn-default"> <a
                    style="background-color: #e4bd46;  color:#fff;font-size: 15px;" href="{{route('add_city_page')}}"
                    class="btn btn-sm btn-neutral">Add City +</a></button>
              </div>
              <div class="col-sm-3">
                <button type="button" class="btn btn-default"><a
                    style="background-color: #e4bd46;  color:#fff;font-size: 15px;"
                    href="{{route('add_ethnicity_page')}}" class="btn btn-sm btn-neutral">Add Ethnicity +</a></button>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-3 py-2">
                <button type="button" class="btn btn-default"><a
                    style="background-color: #e4bd46;  color:#fff;font-size: 15px;"
                    href="{{route('showAddReportform')}}" class="btn btn-sm btn-neutral">Add Rating Question
                    +</a></button>
              </div>
              <div class="col-sm-3 py-2">
                <button type="button" class="btn btn-default"><a
                    style="background-color: #e4bd46;;  color:#fff;font-size: 15px;"
                    href="{{route('add_report_message_page')}}" class="btn btn-sm btn-neutral">Add
                    Report +</a></button>
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
      <div class="modal-header custom_modal_header">
        <h4 class="modal-title text-capitalize" id="businessName"> City List</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12" id="noData">
            {{-- <div class="table-responsive">
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
            </div> --}}
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
      <div class="modal-header custom_modal_header">
        <h4 class="modal-title text-capitalize" id="businessName"> Edit City </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="">
              <div>
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
                <br>
                <div id="EditCity"></div>
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
      <div class="modal-header custom_modal_header">
        <h4 class="modal-title text-capitalize" id="businessName">Country Department List</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
        <div class="row">
          <div class="col-md-12" id="viewDepartment">

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- end model view department --}}
{{-- model Edit country --}}
<div class="modal fade" id="EditCountrymodel1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="width:100%">
      <div class="modal-header custom_modal_header">
        <h4 class="modal-title text-capitalize">Edit Country</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body custom_modal_body">
        <div class="row">
          <div class="col-md-12">
            <!--<div class="table-responsive">-->
            <div class="">
              <div>
                <form action="{{route('editCountry')}}" method="POST">
                  @csrf

                  <div class="row">


                    <input type="hidden" value="" name="country_id" id="country_id">

                    <div class="col-9">
                      <input type="text" class="form-control" value="" name="country_name" id="country_name">
                    </div>
                    <div class="col-3">
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- end model Edit country --}}
<div class="modal fade" id="EditStatemodel1" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header custom_modal_header">
        <h4 class="modal-title text-capitalize">Edit State</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body custom_modal_body">
        <form action="{{route('editState')}}" method="POST">
          @csrf

          <div class="row">


            <input type="hidden" value="" name="state_id" id="state_id">

            <div class="col-9">
              <input type="text" class="form-control" value="" name="state_name" id="state_name">
            </div>
            <div class="col-2">
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function() {
    var dataTable = $('#datatable-basic').DataTable({
      language: {
        searchPlaceholder: "Country , State Name",
        "emptyTable": "No data found.",
        paginate: {
          previous: '<i class="fas fa-angle-left"></i>',
          next: '<i class="fas fa-angle-right"></i>'
        },
        aria: {
          paginate: {
            previous: 'Previous',
            next: 'Next'
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
        'url': "{{route('countryList')}}",
        'data': function(data) {


        }
      },
      'columns': [{
          data: 'SN'
        },
        {
          data: 'country_name'
        },
        {
          data: 'state_name'
        },
        {
          data: 'city_name'
        },
        {
          data: 'view'
        },
        // { data: 'view' },
      ]
    });
    $('#search').keyup(function() {
      dataTable.draw();
    });
  });
</script>
<script type="text/javascript">
  function viewCityModel1(id) {
    // alert(id);
    $.ajax({
      url: "{{ route('viewCityModel') }}/" + id,
      type: 'get',
      success: function(response) {

        if (response.length) {
          console.log('aaa--', response);
          $('#noData').html('');
          // $('#noData').css("display","block");
          var i = 0;
          let row = `<div class="table-responsive">
              <div>
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th><span class="tbl_row">SN.</span></th>
                      <th> <span class="tbl_row">City Name</span> </th>
                    </tr>
                  </thead>
                  <tbody id="businessDetails">`;
          $.each(response, function(key, value) {
            row += `
                <tr>
                  <td> ${++i} </td>
                  <td class="text-capitalize">${value.city_name}</td>
                 </tr>
                `;

          })
          row += `    </tbody>
                </table>
              </div>
            </div>`;
          $('#noData').append(row)
        } else {
          console.log('else');
          // let row = `
          //   <tr>
          //     <td colspan="7"> Record not found! </td>
          //   </tr>
          //   `;
          $('#noData').html("No city found.");
          // $('#noData').css("display","none");
        }
        $('#exampleModalCenter').modal('show');
      },
      error: function(err) {
        console.log(err);
      }
    });
  }

  function EditCityModel1(id) {
    // alert(id);
    $.ajax({
      url: "{{ route('viewCityModel') }}/" + id,
      type: 'get',
      success: function(response) {
        console.log(response);
        if (response) {
          $('#EditCity').html('');
          var i = 0;
          $.each(response, function(key, value) {
            let row = `

                    <form action="{{route('editCityModelView')}}" method ="GET">

                   <div class="row">
                   <div class="col-2">
          ${++i}
                  <input type="hidden" value="${value.id}" name="city_id">
                          </div>
                      <div class="col-7">
                  <input type="text" class="form-control" value="${value.city_name}" name="city_name">
                      </div>
                      <div class="col-3">
                  <button type="submit" class="btn btn-primary">Save</button>
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

  function viewDepartmentModel1(id) {
    $.ajax({
      url: "{{ route('viewDeparmentModel') }}/" + id,
      type: 'get',
      success: function(response) {

        if (response.length > 0) {
          $('#viewDepartment').html('');
          var i = 1;
          let row = ` <div class="table-responsive">
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
                  <tbody>`;
          $.each(response, function(key, value) {
            console.log(value);
            row += `
               <tr>
              <td>${i++}</td>
              <td class="text-capitalize">${value.department_name}</td>
              <td class="text-capitalize">${value.state_data.state_name}</td>
              <td class="text-capitalize">${(value.city_data) ? value.city_data.city_name : "" }</td>
              <td class="text-capitalize">${(value.avgRating) ? value.avgRating.toFixed(1) : 0 }</td>
              <td class="text-capitalize">${(value.total_reviews) ? value.total_reviews : 0 } reviews</td>
              <td class="text-capitalize">${value.badges} badges</td>
           </tr>`;

          });
          row += `  </tbody>
</table>
</div>
</div>`;
          $('#viewDepartment').append(row);
        } else {
          $('#viewDepartment').html('<div>No record found.</div>');
        }

        $('#viewDepartmentModel').modal('show');
      },
      error: function(err) {
        console.log(err);
      }
    });
  }

  // $('#viewDepartment').html('');
  //   var i = 0;
  //   let row = `
  //     <tr>
  //        <td> 1 </td>
  //        <td class="text-capitalize"> India</td>
  //        <td class="text-capitalize">UP</td>
  //        <td class="text-capitalize">Varanasi</td>
  //        <td class="text-capitalize">Rating 4</td>
  //        <td class="text-capitalize">120 reviews</td>
  //        <td class="text-capitalize">10 badges</td>
  //     </tr>
  //     <tr>
  //        <td> 2 </td>
  //        <td class="text-capitalize"> India</td>
  //        <td class="text-capitalize">UP</td>
  //        <td class="text-capitalize">Varanasi</td>
  //        <td class="text-capitalize">Rating 4</td>
  //        <td class="text-capitalize">120 reviews</td>
  //        <td class="text-capitalize">10 badges</td>
  //     </tr>
  //     <tr>
  //        <td> 3 </td>
  //        <td class="text-capitalize"> India</td>
  //        <td class="text-capitalize">UP</td>
  //        <td class="text-capitalize">Varanasi</td>
  //        <td class="text-capitalize">Rating 4</td>
  //        <td class="text-capitalize">120 reviews</td>
  //        <td class="text-capitalize">10 badges</td>
  //     </tr>
  //     <tr>
  //        <td> 4 </td>
  //        <td class="text-capitalize"> India</td>
  //        <td class="text-capitalize">UP</td>
  //        <td class="text-capitalize">Varanasi</td>
  //        <td class="text-capitalize">Rating 4</td>
  //        <td class="text-capitalize">120 reviews</td>
  //        <td class="text-capitalize">10 badges</td>
  //     </tr>
  //     <tr>
  //        <td> 5 </td>
  //        <td class="text-capitalize"> India</td>
  //        <td class="text-capitalize">UP</td>
  //        <td class="text-capitalize">Varanasi</td>
  //        <td class="text-capitalize">Rating 4</td>
  //        <td class="text-capitalize">120 reviews</td>
  //        <td class="text-capitalize">10 badges</td>
  //     </tr>
  //     <tr>
  //        <td> 6 </td>
  //        <td class="text-capitalize"> India</td>
  //        <td class="text-capitalize">UP</td>
  //        <td class="text-capitalize">Varanasi</td>
  //        <td class="text-capitalize">Rating 4</td>
  //        <td class="text-capitalize">120 reviews</td>
  //        <td class="text-capitalize">10 badges</td>
  //     </tr>

  //   `;
  //   $('#viewDepartment').append(row)
  //   $('#viewDepartmentModel').modal('show');
  // }
  function EditCountryModel1(id, country_name) {
    $('#country_id').val(id);
    $('#country_name').val(country_name);
    $('#EditCountrymodel1').modal('show');
  }

  function EditStateModel1(id, state_name) {

    $('#state_id').val(id);
    $('#state_name').val(state_name);

    $('#EditStatemodel1').modal('show');
  }
</script>
@endsection
