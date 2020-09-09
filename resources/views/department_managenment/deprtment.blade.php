@extends('admin_dash.main')

@section('content')
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Department Management</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
              <!--<li class="breadcrumb-item"><a href="#">Tables</a></li>-->
              <li class="breadcrumb-item active" aria-current="page">Department</li>
            </ol>
          </nav>
        </div>


        <div class="col-lg-6 col-5 text-right">
          {{-- <a href="#" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#department" id="sideshow">Add
            Department</a> --}}
          {{-- <a href="#" class="btn btn-sm btn-neutral">New</a>
          <a href="#" class="btn btn-sm btn-neutral">Filters</a> --}}
          <button type="button" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#exampleModal">
            Add Department
          </button>
          {{-- <a href="#" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#department" id="sideshow">Add
            Department</a> --}}
        </div>

        <!--<div class="row">-->
        <!-- <div id="buttons-colors-component" class="tab-pane tab-example-result fade show active" role="tabpanel" aria-labelledby="buttons-colors-component-tab"> -->

        <!-- <div class="tab-content">
          <div id="notify-colors-component" class="tab-pane tab-example-result fade active show" role="tabpanel" 
            aria-labelledby="notify-colors-component-tab">-->
        <div class="col-3">
        </div>
        <div class="col-3">
          <a href="{{route('department')}}" class="btn btn-success" data-toggle="notify" data-placement="top"
            data-align="center" data-type="info" data-icon="ni ni-bell-55">Department List</a>
        </div>
        <div class="col-3">
          <a href="{{route('badge')}}" class="btn btn-info" data-toggle="notify" data-placement="top"
            data-align="center" data-type="success" data-icon="ni ni-bell-55">Badge List</a>
        </div>
        <div class="col-3">
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
                <div class='col-3'>
                  <div class="form-group">
                    <select class="form-control" name="status_id" id="status_id">
                      <option value="">status</option>
                      <option value="1">Active</option>
                      <option value="2">Inactive</option>
                    </select>
                  </div>
                </div>
                <div class='col-3'>
                  <?php $countryList = App\Country::get();?>
                  <div class="form-group">
                    <select class="form-control" name="country_id" id="country_id">
                      <option value="">Select Country</option>
                      @foreach($countryList as $counntryList)
                      <option value="{{$counntryList->id}}">{{$counntryList->country_name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class='col-3'>
                  <div class="form-group">
                    <select class="form-control" name="state_id" id="state_id">
                      <option value="">Select State</option>
                    </select>
                  </div>
                </div>
                <div class='col-3'>
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
                      <input class="form-control datepicker" placeholder="Select from date" type="text" value=""
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
                      <input class="form-control datepicker" placeholder="Select to date" type="text" value=""
                        name="todate" id="todate">
                    </div>
                  </div>
                </div>
                <input type="hidden" placeholder="Look for user" name="search2" id="search2" class="search_input">
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
                <th>Department Name</th>
                <th>Total Reviews</th>
                <th>Rating</th>
                <th>Registered On</th>
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


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Department</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
            <span style="color:red">*</span>All fields are mandatory
            <div class="table-responsive">
              <form id="formId" class="form-horizontal" action="{{route('AddDepartment')}}"
                enctype="multipart/form-data" method="POST">
                {{ csrf_field() }}
                <div class="card-body">

                  <div class="form-group row">

                    <input type="text" id="department_name" class="form-control" value="{{ old('department_name') }}"
                      placeholder="Department Name" name="department_name">

                  </div>
                  <div class="form-group row">
                    <select class="form-control select2" style="width: 100%;" id="country1" name="country">
                      <option value="">Country name</option>
                      @foreach($countryList as $counntryList)
                      <option value="{{$counntryList->id}}">{{$counntryList->country_name}} </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group row">
                    <select class="form-control select2" style="width: 100%;" id="state" name="state">
                      <option selected="selected">State Name</option>
                    </select>
                  </div>
                  <div class="form-group row">
                    <select class="form-control select2" style="width: 100%;" id="city1" name="city">
                      <option selected="selected">City Name</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Department Icon</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="departmentImage">
                        <label class="custom-file-label" for="exampleInputFile">Pick Icon</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    OR
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <input type="file" class="form-control" name="department_file">
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group">

                        <a href="{{route('export')}}" class="btn btn-primary">File
                          upload sample</a>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="modal-footer" style="margin-top: -50px;">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button id="depart" type="submit" class="btn btn-primary ">Add</button>
                  {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

{{-- start add department model view --}}
{{-- <div id="department" class="modal">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

          <div class="modal-header">
            <h4 class="modal-title text-capitalize" id="userName">Add Department1</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <span style="color:red">*</span>All fields are mandatory
                <div class="table-responsive">
                  <form id="formId" class="form-horizontal" action="{{route('AddDepartment')}}"
enctype="multipart/form-data" method="POST">
{{ csrf_field() }}
<div class="card-body">

  <div class="form-group row">

    <input type="text" id="department_name" class="form-control" placeholder="Department Name" name="department_name">

  </div>
  <div class="form-group row">
    <select class="form-control select2" style="width: 100%;" id="country1" name="country">
      <option value="">Country name</option>
      @foreach($countryList as $counntryList)
      <option value="{{$counntryList->id}}">{{$counntryList->country_name}} </option>
      @endforeach
    </select>
  </div>
  <div class="form-group row">
    <select class="form-control select2" style="width: 100%;" id="state" name="state">
      <option selected="selected">State Name</option>
    </select>
  </div>
  <div class="form-group row">
    <select class="form-control select2" style="width: 100%;" id="city1" name="city">
      <option selected="selected">City Name</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputFile">Department Icon</label>
    <div class="input-group">
      <div class="custom-file">
        <input type="file" class="custom-file-input" id="exampleInputFile" name="departmentImage">
        <label class="custom-file-label" for="exampleInputFile">Pick Icon</label>
      </div>
    </div>
  </div>

</div>
<!-- /.card-body -->
<div class="card-footer btn-add">
  <button id="depart" type="button" class="btn btn-info float-right ">Add</button>
</div>
<!-- /.card-footer -->
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div> --}}
{{-- end add department  --}}
{{-- start add badge model view --}}
{{-- <div id="badge" class="modal">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

          <div class="modal-header">
            <h4 class="modal-title text-capitalize" id="userName">Add Badge</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <form class="form-horizontal" action="{{route('AddBadge')}}" method="GET">
{{ csrf_field() }}
<div class="card-body">

  <div class="form-group row">
    <select class="form-control select2" style="width: 100%;" id="department_id" name="department_id">
      <option value="">Department Name</option>
      @foreach($departmentName as $value)
      <option value="{{$value->id}}">{{$value->department_name}} </option>
      @endforeach
    </select>
  </div>
  <div class="form-group row">
    <div class="form-group">
      <input type="text" class="form-control" placeholder="Badge Number" name="badge_number">
    </div>
  </div>
</div>
<div class="card-footer">
  <button type="submit" class="btn btn-info float-right">Add</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div> --}}
{{-- end add badge  --}}

@endsection
@section('script')
{{-- filter --}}
<!--<script type="text/javascript">
  $(document).ready(function(){
       $("#depart").click(function(){
          var department_name=  $('#department_name').val();
       //   var city=  $('#city1').val();
         if(department_name == null || department_name == '' ){
         // if(city == null && city == ''){
              alert('Please fill all fields. All fields are mandatory');
              return false;
          }else{
                 $("#formId").submit();
          }           
  })
  })
</script>-->
<script type="text/javascript">
  $(document).ready(function(){
    $("#country_id").change(function(){
        var country_id = $(this).val();
        $.ajax({
            url: '{{route('get_state')}}',
            type: 'get',
            data: {country_id:country_id},
            dataType: 'json',
            success:function(response){
            var len = response.length;
            $("#state_id").empty();
            $("#state_id").append("<option value=''>Please Select</option>");

              for( var i = 0; i<len; i++){
                var id = response[i]['id'];
                var name = response[i]['name'];
                $("#state_id").append("<option value='"+id+"'>"+name+"</option>");
              }
            }
        });
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#state_id").change(function(){
      // alert('dfshj');
        var state_id = $(this).val();
        // alert(state_id);
        $.ajax({
            url: '{{route('get_city')}}',
            type: 'get',
            data: {state_id:state_id},
            dataType: 'json',
            success:function(response){
            var len = response.length;
            $("#city_id").empty();
       $("#city_id").append("<option value=''>Please Select</option>");

              for( var i = 0; i<len; i++){
                var id = response[i]['id'];
                var name = response[i]['name'];
                $("#city_id").append("<option value='"+id+"'>"+name+"</option>");
              }
            }
        });
    });
  });
</script>
{{-- end filter --}}
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
        'url':"{{route('department_list')}}",
       'data': function(data){
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
          // var search = $('#search').val();
          // data.search = search;
          
        }
       },
    'columns': [
        { data: 'name' } ,
        { data: 'reviews' },
        { data: 'rating' },
        // { data: 'username' },
        { data: 'registered_on' },
        // { data: 'review' },
        { data: 'view' },
    ]
  });
  $('#search_data1').click(function(){
     dataTable.draw();
  });
  $('#search').keyup(function(){
     dataTable.draw();
  });
});
</script>
<script type="text/javascript">
  function status(id){
       $.ajax({
      url: "{{route('department_status')}}",
      type: "post",
      data: {'user_id':id ,'_token': "{{ csrf_token() }}"},
        success: function (data) {
            location.reload();// refresh same page
        }
    });
  }
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#country1").change(function(){
        var country_id = $(this).val();
        // alert(country_id);
       // $("#state").append("<option value=''>Please Select</option>");

        $.ajax({
            url: '{{route('get_state')}}',
            type: 'get',
            data: {country_id:country_id},
            dataType: 'json',
            success:function(response){
            var len = response.length;
            $("#state").empty();
            $("#state").append("<option value=''>Please Select</option>");
              for( var i = 0; i<len; i++){
                var id = response[i]['id'];
                var name = response[i]['name'];
                $("#state").append("<option value='"+id+"'>"+name+"</option>");
              }
            }
        });
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#state").change(function(){
      // alert('dfshj');
        var state_id = $(this).val();
        // alert(state_id);
        $.ajax({
            url: '{{route('get_city')}}',
            type: 'get',
            data: {state_id:state_id},
            dataType: 'json',
            success:function(response){
            var len = response.length;
            $("#city1").empty();
            $("#city1").append("<option value=''>Please Select</option>");
              for( var i = 0; i<len; i++){
                var id = response[i]['id'];
                var name = response[i]['name'];
                $("#city1").append("<option value='"+id+"'>"+name+"</option>");
              }
            }
        });
    });
  });
</script>
<script type="text/javascript">
  @if (count($errors) > 0)
      $('#exampleModal').modal('show');
  @endif
</script>
<script>
  function myFunction() {
document.getElementById("search_data").reset();
}
</script>
@endsection