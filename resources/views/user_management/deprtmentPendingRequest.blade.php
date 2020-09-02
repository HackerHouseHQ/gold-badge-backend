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
<div class="col-sm-12">
  <div class="content-wrapper custom-content-wrapper">
    <div class="below_content_clss">
      <section class="content home_conntent">
        <div class="container-fluid">
          <div class="card-body">
            <input class="form-control form-control-sm" id="search" type="text"
              placeholder="Search By Name.Badge,Department,Country,State,City....">
          </div>
          {{-- main header for show list --}}
          <div class="row">
            <div class="main_menu_three_tabs">
              <ul class="nav nav-tabs abc">
                <li class="show"><a href="{{route('departmentRequest')}}" id="approve">Approved</a></li>
                <li class="show active"><a href="#" id="pending">Pending</a></li>
                <li class="show"><a href="{{route('deprtmentRejectRequest')}}" id="reject">Rejected</a></li>
              </ul>
            </div>
          </div>
          {{-- close --}}

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
          </div>
          <form action="" id="search_data" class="search_data_row_class">
            <table class="table table-striped">
              <thead>
                <tr>
                  <span class="from_to_select">
                    <label for="from_text" class="serach_by_text">From</label>

                    <input type="date" class="from_control" name="fromdate" id="fromdate"
                      style="-webkit-appearance: media-slider;">
                    <label for="to_text" class="serach_by_text">To</label>
                    <input type="date" class="from_control" name="todate" id="todate"
                      style="-webkit-appearance: media-slider;">
                  </span>
                  <input type="hidden" placeholder="Look for user" name="search2" id="search2" class="search_input">
                  <button type="button" id="search_data1" class="apply_btnn">Apply</button>
                </tr>
              </thead>
            </table>
          </form>

          <br>
          <br>
          {{--start table --}}
          <br>

          <div class="row">
            <div class="col-12">
              <div class="card class_scroll ">
                <div class="card-body p-0">
                  <table id="data1" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><span class="tbl_row">Department Name</span></th>
                        <th><span class="tbl_row">Country</span></th>
                        <th><span class="tbl_row">State</span></th>
                        <th><span class="tbl_row">City</span></th>
                        <th><span class="tbl_row">UserName</span></th>
                        <th><span class="tbl_row">Requested On</span></th>
                        <th><span class="tbl_row">Name</span></th>
                        <th><span class="tbl_row">Email</span></th>
                        <th><span class="tbl_row">Contact No.</span></th>
                        <th><span class="tbl_row">Action</span></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          {{-- end table --}}
        </div>
      </section>

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
       'url':"{{route('UserRequestData')}}",
       'data': function(data){
            data.type = 0;
            var search = $('#search').val();
            data.search = search; 
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
        { data: 'contact' },       
       { data: 'action' },
    ]
  });
   $('#search_data1').click(function(){
    //   alert();
     dataTable.draw();
  });
  $('#search').keyup(function(){
     dataTable.draw();
    // alert('f');
  });
});
</script>


<script type="text/javascript">
  function status(id , status){ 
     // alert(id);
    var id =  $("#abc").val(id); 
     
      if(status == 1)
      {
        console.log(status);
       $('#uploadModal').modal('show');
      }
      if(status == 2)
      {

      reject(id , status);
      }
       
//       return false;

  }

      function reject(id  , status)
      {
        console.log(id);
        
      $.ajax({
        
     url: "{{route('acceptDepartmentRequest')}}",
     type: "post",
     data: {'deprtmentRequestId':id ,
     '_token': "{{ csrf_token() }}" ,
     'status' : status},
       success: function (data) {
           console.log(data);
           location.reload();// refresh same page
       }
   });
      
      }    
</script>
<script>
  $('#btn_upload').click(function(){
 //alert($("#abc").val());
 var id = $("#abc").val();
 var status = $('#status').val();
    var fd = new FormData();
    var files = $('#file')[0].files[0];
    fd.append('file',files);
///onsole.log(files);
    // AJAX request
    $.ajax({
      url: "{{route('acceptDepartmentRequest')}}",
      type: 'post',
     data: {'img':fd ,'deprtmentRequestId':id,'_token': "{{ csrf_token() }}" , 
     'status' : 1},
     //data: {'img':fd ,'deprtmentRequestId':id},
      contentType: json,
     processData: false,
//      beforeSend: function (xhr) {
//            var token = $('meta[name="csrf_token"]').attr('content');
//            if (token) {
//                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
//            }                
//        },
      success: function(response){
          console.log(response);
          return false;
           location.reload();
//        if(response != 0){
//          // Show image preview
//          $('#preview').append("<img src='"+response+"' width='100' height='100' style='display: inline-block;'>");
//        }else{
//          alert('file not uploaded');
//        }
      }
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

@endsection