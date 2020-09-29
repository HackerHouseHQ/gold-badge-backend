@extends('admin_dash.main')
@section('content')
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">User Management</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
              <!--<li class="breadcrumb-item"><a href="#">Tables</a></li>-->
              <li class="breadcrumb-item active" aria-current="page">User</li>
            </ol>
          </nav>
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
        <!-- <div class="card-header">
          <form action="" id="search_data" class="search_data_row_class">
         
                  <input type="hidden" placeholder="Look for user" name="search2" id="search2" class="search_input">
                  <button type="button" id="search_data1" class="apply_btnn">Apply</button>
           
          </form>
 -->
        <!-- Card body -->
        <div class="card-body">
          <div class="card-header" style="border-bottom: 1px solid #6073e4 ">
            <form id="myForm">
              <div class='row'>
                <div class='col-4'>
                  <div class="form-group">
                    <select class="form-control" name="status_id" id="status_id">
                      <option value="">status</option>
                      <option value="1">Active</option>
                      <option value="2">Inactive</option>
                    </select>
                  </div>
                </div>
                <div class='col-4'>
                  <?php $countryList =  App\Country::get(); ?>
                  <div class="form-group">
                    <select class="form-control" name="country_id" id="country_id">
                      <option value="">Select Country</option>
                      @foreach($countryList as $counntryList)
                      <option value="{{$counntryList->id}}">{{$counntryList->country_name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class='col-4'>
                  <div class="form-group">
                    <select class="form-control" name="state_id" id="state_id">
                      <option value="">Select State</option>
                    </select>
                  </div>
                </div>
                <div class='col-5'>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                      </div>
                      <input class="form-control datepicker" placeholder="Select date form date" type="text" value=""
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
                      <input class="form-control datepicker" placeholder="Select date to date" type="text" value=""
                        name="todate" id="todate">
                    </div>
                  </div>
                </div>
                <div class='col-2'>
                  <div class="row">
                    <button type="button" id="search_data1" class="btn btn-primary apply_btnn">Apply</button>
                    <button type="button" value="Reset form" onclick="myFunction()"
                      class="btn btn-info apply_btnn">Reset</button>
                  </div>



                </div>
              </div>
            </form>

          </div>
        </div>
        <div class="table-responsive py-4">
          <table class="table table-flush" id="datatable-basic">
            <thead class="thead-light">
              <tr>
                <th><span class="tbl_row">NAME</span></th>
                <th><span class="tbl_row">Contact No.</span></th>
                <th><span class="tbl_row">Email</span></th>
                <th><span class="tbl_row">Username</span></th>
                <th><span class="tbl_row">Registered On</span></th>
                <th><span class="tbl_row">Total Reviews</span></th>
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
@endsection
@section('script')
<noscript>
  <img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=111649226022273&ev=PageView&noscript=1" />
</noscript>
<script>

</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#country_id").change(function() {
      var country_id = $(this).val();
      $.ajax({
        url: "{{route('get_state')}}",
        type: 'get',
        data: {
          country_id: country_id
        },
        dataType: 'json',
        success: function(response) {
          var len = response.length;

          $("#state_id").empty();
          $("#state_id").append("<option value=''>Select State</option>");
          for (var i = 0; i < len; i++) {
            var id = response[i]['id'];
            var name = response[i]['name'];
            $("#state_id").append("<option value='" + id + "'>" + name + "</option>");
          }
        }
      });
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    var dataTable = $('#datatable-basic').DataTable({
      language: {
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
      "searching": false,
      'processing': true,
      'serverSide': true,
      "bFilter": true,
      "bInfo": true,
      "lengthChange": true,
      "bAutoWidth": true,
      'ajax': {
        'url': "{{route('userList')}}",
        'data': function(data) {
          var status_id = $('#status_id').val();
          data.status_id = status_id;
          var state_id = $('#state_id').val();
          data.state_id = state_id;
          var country_id = $('#country_id').val();
          data.country_id = country_id;
          var fromdate = $('#fromdate').val();
          data.fromdate = fromdate;
          var todate = $('#todate').val();
          data.todate = todate;
        }
      },
      'columns': [{
          data: 'name'
        },
        {
          data: 'contact'
        },
        {
          data: 'email'
        },
        {
          data: 'username'
        },
        {
          data: 'registered_on'
        },
        {
          data: 'review'
        },
        {
          data: 'view'
        },
      ]
    });

    //   $("#status_id").keyup(function(){

    // });
    $('#search_data1').click(function() {
      dataTable.draw();
    });
  });
</script>
<script type="text/javascript">
  function status(id) {
    $.ajax({
      url: "{{route('change_status')}}",
      type: "post",
      data: {
        'user_id': id,
        '_token': "{{ csrf_token() }}"
      },
      success: function(data) {
        location.reload(); // refresh same page
      }
    });
  }
</script>
<script>
  function myFunction() {
    document.getElementById("myForm").reset();
    location.reload();

  }
</script>
{{-- <script>
  $(document).ready(function () {
          $('#datatable-basic').DataTable({
            language: {
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
              "columns": [
                  { "data": "name" },
                  { "data": "position" },
                  { "data": "office" },
                  { "data": "age" },
                  { "data": "start_date" },
                  { "data": "salary" }
              ]
          });
      });
</script> --}}

@endsection