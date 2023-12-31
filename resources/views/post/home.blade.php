@extends('admin_dash.main')
<style type="text/css">
  .show {
    margin-left: 31px;
    margin-right: 92px;
  }

  .active2 {
    background: red;
  }

  #status_id {
    padding-right: 67px;
  }

  #country_id {
    padding-right: 67px;
  }

  #state_id {
    padding-right: 67px;
  }

  #city_id {
    padding-right: 67px;
  }

  #sideshow {
    /*background-color: aqua;*/
    margin-left: 637px;
  }

  /*}*/
</style>
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
        {{-- <div class="col-lg-6 col-5 text-right">
          <a href="#" class="btn btn-sm btn-neutral">New</a>
          <a href="#" class="btn btn-sm btn-neutral">Filters</a>
        </div> --}}
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
                  <div class="form-group">
                    <select class="form-control" name="department_id" id="department_id">
                      <option value="">Department</option>
                      <option value="1">Department1</option>
                      <option value="2">Department2</option>
                    </select>
                  </div>
                </div>
                <div class='col-4'>
                  <div class="form-group">
                    <select class="form-control" name="badge_id" id="badge_id">
                      <option value="">Badge</option>
                      <option value="1">Badge1</option>
                      <option value="2">Badge2</option>
                    </select>
                  </div>
                </div>
                <div class='col-4'>
                  <?php $countryList = App\Country::get(); ?>
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
                <div class='col-4'>
                  <div class="form-group">
                    <select class="form-control" name="city_id" id="city_id">
                      <option value="">City</option>
                    </select>
                  </div>
                </div>
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
        {{-- <div class="card-header">
          <form action="" id="search_data" class="search_data_row_class">
            <table class="table table-striped">
              <thead>
                <tr>
                  <span class="div_cover_sell">
                    <span>
                      <select name="status_id" id="status_id">
                        <option value="">Status</option>
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                      </select>
                    </span>
                  </span>
                  <span class="div_cover_sell">
                    <span>
                      <select name="department_id" id="department_id">
                        <option value="">Department</option>
                        <option value="1">Department1</option>
                        <option value="2">Department2</option>
                      </select>
                    </span>
                  </span>
                  <span class="div_cover_sell">
                    <span>
                      <select name="badge_id" id="badge_id">
                        <option value="">Badge</option>
                        <option value="1">Badge1</option>
                        <option value="2">Badge2</option>
                      </select>
                    </span>
                  </span>
                  <span class="div_cover_sell">
                    <span>
                      <?php $countryList =  App\Country::get(); ?>
                      <select name="country_id" id="country_id">
                        <option value="">Country</option>
                        @foreach($countryList as $counntryList)
                        <option value="{{$counntryList->id}}">{{$counntryList->country_name}}</option>
        @endforeach
        </select>
        </span>
        </span>
        <span class="div_cover_sell">
          <span>
            <select name="state_id" id="state_id">
              <option value="">State</option>
            </select>
          </span>
        </span>
        <span class="div_cover_sell">
          <span>
            <select name="city_id" id="city_id">
              <option value="">City</option>
            </select>
          </span>
        </span>
        <br> <br>
        <span class="from_to_select">
          <label for="from_text" class="serach_by_text">From</label>

          <input type="date" class="from_control" name="fromdate" id="fromdate"
            style="-webkit-appearance: media-slider;">
          <label for="to_text" class="serach_by_text">To</label>
          <input type="date" class="from_control" name="todate" id="todate" style="-webkit-appearance: media-slider;">
        </span>
        <input type="hidden" placeholder="Look for user" name="search2" id="search2" class="search_input">
        <button type="button" id="search_data1" class="apply_btnn">Apply</button>


        </tr>
        </thead>
        </table>
        </form>

      </div> --}}
      <div class="table-responsive py-4">
        <table class="table table-flush" id="datatable-basic">
          <thead class="thead-light">
            <tr>
              <th>Username</th>
              <th>Full Name</th>
              <th>Posted on </th>
              <th>posted About</th>
              <th>Rating</th>
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
{{-- filter --}}
<script type="text/javascript">
  $(document).ready(function() {
    $("#country_id").change(function() {
      $("#state_id").append("<option value=''>Please Select</option>");
      var country_id = $(this).val();
      $.ajax({
        url: "{{route('get_state')}}"",
        type: 'get',
        data: {
          country_id: country_id
        },
        dataType: 'json',
        success: function(response) {
          var len = response.length;
          $("#state_id").empty();
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
    $("#state_id").change(function() {
      // alert('dfshj');
      $("#city_id").append("<option value=''>Please Select</option>");
      var state_id = $(this).val();
      // alert(state_id);
      $.ajax({
        url: "{{route('get_city')}}",
        type: 'get',
        data: {
          state_id: state_id
        },
        dataType: 'json',
        success: function(response) {
          var len = response.length;
          $("#city_id").empty();
          for (var i = 0; i < len; i++) {
            var id = response[i]['id'];
            var name = response[i]['name'];
            $("#city_id").append("<option value='" + id + "'>" + name + "</option>");
          }
        }
      });
    });
  });
</script>
{{-- end filter --}}
<script type="text/javascript">
  $(document).ready(function() {
    var dataTable = $('#datatable-basic').DataTable({
      language: {
        searchPlaceholder: "Department Name",
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
        'url': "{{route('postData')}}",
        'data': function(data) {
          var status_id = $('#status_id').val();
          data.status_id = status_id;
          var state_id = $('#state_id').val();
          data.state_id = state_id;
          var country_id = $('#country_id').val();
          data.country_id = country_id;
          var city_id = $('#city_id').val();
          data.city_id = city_id;
          var department_id = $('#department_id').val();
          data.department_id = department_id;
          var badge_id = $('#badge_id').val();
          data.badge_id = badge_id;
          var fromdate = $('#fromdate').val();
          data.fromdate = fromdate;
          var todate = $('#todate').val();
          data.todate = todate;
          // var search = $('#search').val();
          // data.search = search;

        }
      },
      'columns': [{
          data: 'userName'
        },
        {
          data: 'fullName'
        },
        {
          data: 'postedOn'
        },
        {
          data: 'postedAbout'
        },
        {
          data: 'rating'
        },
        {
          data: 'action'
        },
      ]
    });
    $('#search_data1').click(function() {
      dataTable.draw();
    });
    $('#search').keyup(function() {
      dataTable.draw();
    });
  });
</script>
<script type="text/javascript">
  function status(id) {
    $.ajax({
      url: "{{route('department_status')}}",
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
<script type="text/javascript">
  $(document).ready(function() {
    $("#country1").change(function() {
      var country_id = $(this).val();
      // alert(country_id);
      $.ajax({
        url: '{{route('
        get_state ')}}',
        type: 'get',
        data: {
          country_id: country_id
        },
        dataType: 'json',
        success: function(response) {
          var len = response.length;
          $("#state").empty();
          for (var i = 0; i < len; i++) {
            var id = response[i]['id'];
            var name = response[i]['name'];
            $("#state").append("<option value=''>Please Select</option>");
            $("#state").append("<option value='" + id + "'>" + name + "</option>");
          }
        }
      });
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#state").change(function() {
      // alert('dfshj');
      var state_id = $(this).val();
      // alert(state_id);
      $.ajax({
        url: '{{route('
        get_city ')}}',
        type: 'get',
        data: {
          state_id: state_id
        },
        dataType: 'json',
        success: function(response) {
          var len = response.length;
          $("#city1").empty();
          for (var i = 0; i < len; i++) {
            var id = response[i]['id'];
            var name = response[i]['name'];
            $("#city1").append("<option value=''>Please Select</option>");
            $("#city1").append("<option value='" + id + "'>" + name + "</option>");
          }
        }
      });
    });
  });
</script>
@endsection