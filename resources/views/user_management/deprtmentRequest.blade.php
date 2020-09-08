@extends('admin_dash.main')
@section('content')
<style type="text/css">
  .show {
    margin-left: 21px;
    margin-right: 92px;
  }

  .nav-tabs.abc>li.active>a,
  .nav-tabs.abc>li.active>a:focus,
  .nav-tabs.abc>li.active>a:hover {
    color: #ffffff;
    cursor: default;
    background-color: #007bff;
    border: none;
    border-radius: 1px;
    border-bottom: 2px solid #01AFAA;
  }
</style>
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
         <h6 class="h2 text-white d-inline-block mb-0">Department Request</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">Approved</li>
            </ol>
          </nav>
        </div> 
           <!--<div class="row">-->
        
           <div class="col-lg-6 col-6 d-flex justify-content-end">
            <ul class="nav nav-tabs abc" style="border-bottom: 1px solid #5e72e3;">
                <!-- <li class="show" style="margin-right: 0px !important"><a style="border-bottom: 2px solid #057afc;" href="{{route('departmentRequest')}}" class="btn btn-success" data-toggle="notify"
                  data-placement="top" data-align="center" data-type="info" data-icon="ni ni-bell-55"
                  id="approve">Approved</a></li> -->

                  <li class="show" style="margin-right: 0px !important"><a style="border-bottom: 2px solid #61cf8a;" href="{{route('departmentRequest')}}" class="btn btn-success"
                  data-toggle="notify" data-placement="top" data-align="center" data-type="success"
                  data-icon="ni ni-bell-55">Approved</a></li>

              <li class="show" style="margin-right: 0px !important"><a href="{{route('deprtmentPendingRequest')}}" id="pending" class="btn btn-secondary"
                  data-toggle="notify" data-placement="top" data-align="center" data-type="success"
                  data-icon="ni ni-bell-55">Pending</a></li>
              <li class="show"  style="margin-right: 0px !important"><a href="{{route('deprtmentRejectRequest')}}" id="reject" class="btn btn-secondary"
                  data-toggle="notify" data-placement="top" data-align="center" data-type="success"
                  data-icon="ni ni-bell-55">Rejected</a>
              </li>
            </ul>
          </div>
        <!--</div>--> 
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
            <form action="" id="search_data" class="search_data_row_class">
              <div class='row'>

                <div class='col-5'>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                      </div>
                      <input class="form-control datepicker" placeholder="Select date" type="text" value=""
                        name="fromdate" id="fromdate">
                    </div>
                  </div>
                </div>
                <div class='col-5'>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                      </div>
                      <input class="form-control datepicker" placeholder="Select date" type="text" value=""
                        name="todate" id="todate">
                    </div>
                  </div>
                </div>
                <input type="hidden" placeholder="Look for user" name="search2" id="search2" class="search_input">
                <div class='col-2'>
                  <button type="button" id="search_data1" class="btn btn-primary apply_btnn">Apply</button>

                </div>
              </div>
            </form>

          </div>
        </div>

        <div class="table-responsive py-4">
          <table class="table table-flush" id="datatable-basic">
            <thead class="thead-light">
              <tr>
                <th>Department Name</th>
                <th>Country</th>
                <th>State</th>
                <th>City</th>
                <th>UserName</th>
                <th>Requested On</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact No.</th>
<<<<<<< HEAD
                <th>Action</th>
=======
                <!--<th>Action</th>-->
>>>>>>> f0827c1f3c3f0ba7c8f02d217a2c0a7fa6e27e33
              </tr>
            </thead>

            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div id="uploadModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Upload Department Image</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>
        <div class="modal-body">
          <!-- Form -->
          <form method='post' action='{{route('acceptDepartmentRequest')}}' enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="departId" id="abc" />
            <input type="hidden" name="status" id="status" value="1">
            Select file : <input type='file' name='departmentImage' id='file' class='form-control'><br>
            <input type='submit' class='btn btn-info' value='Upload' id='btn_upload1'>
          </form>

          <!-- Preview-->
          <div id='preview'></div>
        </div>

      </div>

    </div>
    <!-- Footer -->
    {{-- <footer class="footer pt-0">
      <div class="row align-items-center justify-content-lg-between">
        <div class="col-lg-6">
          <div class="copyright text-center  text-lg-left  text-muted">
            &copy; 2020 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">Creative
              Tim</a>
          </div>
        </div>
        <div class="col-lg-6">
          <ul class="nav nav-footer justify-content-center justify-content-lg-end">
            <li class="nav-item">
              <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
            </li>
            <li class="nav-item">
              <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
            </li>
            <li class="nav-item">
              <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
            </li>
            <li class="nav-item">
              <a href="https://www.creative-tim.com/license" class="nav-link" target="_blank">License</a>
            </li>
          </ul>
        </div>
      </div>
    </footer> --}}
  </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    var dataTable = $('#datatable-basic').DataTable({
    language: {
      searchPlaceholder: "Department Name",
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
       'url':"{{route('UserRequestData')}}",
       'data': function(data){
            data.type = 1;
            // var search = $('#search').val();
            // data.search = search; 
            var fromdate = $('#fromdate').val();
          data.fromdate = fromdate;
          var todate = $('#todate').val();
          data.todate = todate;
        }
       },
    'columns': [
        { data: 'd_name' },
        { data: 'country' },
        { data: 'state' },
        { data: 'city' },
        { data: 'username' } ,
        { data: 'reg_date' },
        { data: 'u_name' },
        { data: 'email' },
        { data: 'contact' }
    ]
  });
  $('#search').keyup(function(){
     dataTable.draw();
  });
});
</script>




@endsection