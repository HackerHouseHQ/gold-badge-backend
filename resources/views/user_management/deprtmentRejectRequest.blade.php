@extends('admin_dash.main')
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
@section('content')
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Department Request</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
              <!--<li class="breadcrumb-item"><a href="#">Tables</a></li>-->
              <li class="breadcrumb-item active" aria-current="page">Rejected</li>
            </ol>
          </nav>
        </div>

        <!--<div class="row">-->
        <div class="col-lg-6 col-6 d-flex justify-content-end">
          <ul class="nav nav-tabs abc" style="border-bottom: 1px solid #5e72e3;">
            <li class="show" style="margin-right: 0px !important"><a style="border-bottom: 2px solid #f7fafc;"
                href="{{route('departmentRequest')}}" class="btn btn-secondary" data-toggle="notify"
                data-placement="top" data-align="center" data-type="info" data-icon="ni ni-bell-55"
                id="approve">Approved</a></li>
            <?php $pending = App\UserDepartmentRequest::where("status", 0)->count(); ?>
            @if ($pending > 0)
            <li class="show" style="margin-right: 0px !important"><a href="{{route('deprtmentPendingRequest')}}"
                id="pending" class="btn btn-danger" data-toggle="notify" data-placement="top" data-align="center"
                data-type="success" data-icon="ni ni-bell-55">Pending</a></li>
            @else
            <li class="show" style="margin-right: 0px !important"><a href="{{route('deprtmentPendingRequest')}}"
                id="pending" class="btn btn-secondary" data-toggle="notify" data-placement="top" data-align="center"
                data-type="success" data-icon="ni ni-bell-55">Pending</a></li>
            @endif
            <li class="show" style="margin-right: 0px !important"><a href="{{route('deprtmentRejectRequest')}}"
                id="reject" class="btn btn-success" data-toggle="notify" data-placement="top" data-align="center"
                data-type="success" data-icon="ni ni-bell-55">Rejected</a>
            </li>
          </ul>
        </div>
        <!--</div>-->
        {{-- <div class="tab-content">
          <div id="notify-colors-component" class="tab-pane tab-example-result fade active show" role="tabpanel"
            aria-labelledby="notify-colors-component-tab">
            <a href="{{route('department')}}" class="btn btn-info" data-toggle="notify" data-placement="top"
        data-align="center" data-type="info" data-icon="ni ni-bell-55">Department List</a>
        <a href="{{route('badge')}}" class="btn btn-success" data-toggle="notify" data-placement="top"
          data-align="center" data-type="success" data-icon="ni ni-bell-55">Badge List</a>


      </div>
      <div id="notify-colors-html" class="tab-pane fade" role="tabpanel" aria-labelledby="notify-colors-html-tab">
        <figure class="highlight">
          <pre
            class=" language-html"><code class=" language-html" data-lang="html"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>button</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>btn btn-info<span class="token punctuation">"</span></span> <span class="token attr-name">data-toggle</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>notify<span class="token punctuation">"</span></span> <span class="token attr-name">data-placement</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>top<span class="token punctuation">"</span></span> <span class="token attr-name">data-align</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>center<span class="token punctuation">"</span></span> <span class="token attr-name">data-type</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>info<span class="token punctuation">"</span></span> <span class="token attr-name">data-icon</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>ni ni-bell-55<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Info<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>button</span><span class="token punctuation">&gt;</span></span>
            
            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>button</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>btn btn-success<span class="token punctuation">"</span></span> <span class="token attr-name">data-toggle</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>notify<span class="token punctuation">"</span></span> <span class="token attr-name">data-placement</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>top<span class="token punctuation">"</span></span> <span class="token attr-name">data-align</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>center<span class="token punctuation">"</span></span> <span class="token attr-name">data-type</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>success<span class="token punctuation">"</span></span> <span class="token attr-name">data-icon</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>ni ni-bell-55<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Success<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>button</span><span class="token punctuation">&gt;</span></span>
            
            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>button</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>btn btn-warning<span class="token punctuation">"</span></span> <span class="token attr-name">data-toggle</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>notify<span class="token punctuation">"</span></span> <span class="token attr-name">data-placement</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>top<span class="token punctuation">"</span></span> <span class="token attr-name">data-align</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>center<span class="token punctuation">"</span></span> <span class="token attr-name">data-type</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>warning<span class="token punctuation">"</span></span> <span class="token attr-name">data-icon</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>ni ni-bell-55<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Warning<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>button</span><span class="token punctuation">&gt;</span></span>
            
            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>button</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>btn btn-danger<span class="token punctuation">"</span></span> <span class="token attr-name">data-toggle</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>notify<span class="token punctuation">"</span></span> <span class="token attr-name">data-placement</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>top<span class="token punctuation">"</span></span> <span class="token attr-name">data-align</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>center<span class="token punctuation">"</span></span> <span class="token attr-name">data-type</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>danger<span class="token punctuation">"</span></span> <span class="token attr-name">data-icon</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>ni ni-bell-55<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Danger<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>button</span><span class="token punctuation">&gt;</span></span></code></pre>
        </figure>
      </div>
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
                <th>Country</th>
                <th>State</th>
                <th>City</th>
                <th>UserName</th>
                <th>Requested On</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact No.</th>
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
        'url': "{{route('UserRequestData')}}",
        'data': function(data) {
          data.type = 2;
          var fromdate = $('#fromdate').val();
          data.fromdate = fromdate;
          var todate = $('#todate').val();
          data.todate = todate;
        }
      },
      'columns': [{
          data: 'd_name'
        },
        {
          data: 'country'
        },
        {
          data: 'state'
        },
        {
          data: 'city'
        },
        {
          data: 'username'
        },
        {
          data: 'reg_date'
        },
        {
          data: 'u_name'
        },
        {
          data: 'email'
        },
        {
          data: 'contact'
        },
        // { data: 'view' },
      ]
    });
    $('#search').keyup(function() {
      dataTable.draw();
    });
  });
</script>
{{--
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
        'url':"{{route('userList')}}",
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
}
},
'columns': [
{ data: 'name' } ,
{ data: 'contact' },
{ data: 'email' },
{ data: 'username' },
{ data: 'registered_on' },
{ data: 'review' },
{ data: 'view' },
]
});
$('#search_data1').click(function(){
dataTable.draw();
});
});
</script> --}}
{{-- <script type="text/javascript">
  $("#approve").on('click', function () {
  var dataTable = $('#data1').DataTable({
     "searching": false,
     'processing': true,
     'serverSide': true,
     "bFilter": true,
     "bInfo": false,
     "lengthChange": false,
     "bAutoWidth": false,
     'ajax': {
       'url':"{{route('UserRequestData')}}",
'data': function(data){
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
{ data: 'contact' },
{ data: 'view' },
]
});

});
$("#reject").on('click', function () {
var dataTable = $('#data1').DataTable({
"searching": false,
'processing': true,
'serverSide': true,
"bFilter": true,
"bInfo": false,
"lengthChange": false,
"bAutoWidth": false,
'ajax': {
'url':"{{route('UserRequestData')}}",
'data': function(data){
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
{ data: 'contact' },
{ data: 'view' },
]
});
});
$("#pending").on('click', function () {
var dataTable = $('#data1').DataTable({
"searching": false,
'processing': true,
'serverSide': true,
"bFilter": true,
"bInfo": false,
"lengthChange": false,
"bAutoWidth": false,
'ajax': {
'url':"{{route('UserRequestData')}}",
'data': function(data){
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
{ data: 'contact' },
{ data: 'view' },
]
});

});
</script> --}}
<script>
  function myFunction() {
    document.getElementById("search_data").reset();
  }
</script>

@endsection