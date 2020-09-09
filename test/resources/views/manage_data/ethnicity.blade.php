@extends('admin_dash.main')
@section('content')
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Datatables</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="#">Tables</a></li>
              <li class="breadcrumb-item active" aria-current="page">Datatables</li>
            </ol>
          </nav>
        </div>


        <div class="col-lg-6 col-5 text-right">
          {{-- <a href="#" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#department" id="sideshow">Add
            Department</a> --}}
          {{-- <a href="#" class="btn btn-sm btn-neutral">New</a>
          <a href="#" class="btn btn-sm btn-neutral">Filters</a> --}}
          <div class="row-lg-6 row-5">
            <a href="{{route('countries')}}" class="btn btn-sm btn-neutral">Manage Countries</a>
            <a href="{{route('ethnicity')}}" class="btn btn-sm btn-neutral">Manage Ethnicity</a>
            <a href="{{route('gender')}}" class="btn btn-sm btn-neutral">Gender</a>
            <a href="{{route('report')}}" class="btn btn-sm btn-neutral">Report Reason Type</a>

          </div>
          <br>
          <div class="row-lg-6  row-5" style="float: right;">
            <div class="btn-toolbar">
              <div class="btn-group">
                <a href="{{route('add_country_page')}}" class="btn btn-sm btn-neutral">add new country</a>
                <a href="{{route('add_state_page')}}" class="btn btn-sm btn-neutral">add new state</a>
                <a href="{{route('add_city_page')}}" class="btn btn-sm btn-neutral">add new city</a>
                <a href="{{route('add_ethnicity_page')}}" class="btn btn-sm btn-neutral">add new ethnicity</a>
              </div>
            </div>
          </div>

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
        <div class="table-responsive py-4">
          <table class="table table-flush" id="datatable-basic">
            <thead class="thead-light">
              <tr>
                <th>Ethnicity Name</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $ethnicityData)
              <tr>
                <td><span class='tbl_row_new'>{{$ethnicityData->ethnicity_name}}</span></td>
                <td><span class='tbl_row_new'> <button class="btn btn-xs btn btn-link" data-toggle="modal"
                      data-target="#exampleModalCenter" onclick="openModal({{$ethnicityData->id}})">
                      Edit</button><span class='tbl_row_new'></td>
                <td><span class='tbl_row_new'><a href="{{route('DeleteEthnicity',$ethnicityData->id)}}">Delete</a><span
                      class='tbl_row_new'>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- model edit --}}
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
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
              <form action="{{route('updatEthnicity')}}" method="GET">
                <div id="businessDetails">

                </div>
                <button type="submit" class="btn btn-secondary">Save</button>

              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
{{-- end model edit --}}
@endsection
@section('script')
<script type="text/javascript">
  function openModal(id) {
      // alert(id);
      $.ajax({
          url: "{{ route('Show_edit_ethnicity') }}/" + id, 
          type: 'get',
          success: function (response) {
          // $('#businessName').html(response.genderData);
          
           
              $('#businessDetails').html('');
            let row = `
              
                <b>Ethnicity Name</b>
                <input type="hidden" name="id" value = "${response.id}">
                <input type="text" name="name" value = "${response.ethnicity_name}">
              
 
            `;
              $('#businessDetails').append(row);
              // $('#businessDetails').html(row);
          
        },
        error: function(err) {
          console.log(err);
        }
      });
    }
</script>
<script>
  $('#datatable-basic').dataTable( {
    language: {
      searchPlaceholder: "Ethnicity",
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
     "bFilter": true,
     "bInfo": true,
     "lengthChange": true,
     "bAutoWidth": true
} );
</script>
@endsection