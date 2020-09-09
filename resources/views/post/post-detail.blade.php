@extends('admin_dash.main')
<style>
    .avatar1 {
        vertical-align: middle;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-bottom: 10px;
    }
</style>
@section('content')
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Post</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">PostDetails</li>
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
                        <div class="row">

                            <div class="col-md-4">
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">

                                            <img class="avatar1" src="{{$data->image}}" alt="User profile picture">
                                        </div>
                                        <input type="hidden" id="user_id" value="{{$data->id}}">

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                Full Name <a
                                                    class="float-right">{{$data->first_name ." ". $data->last_name}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                UserName <a class="float-right">{{@$data->user_name}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                Mobile No. <a class="float-right">{{@$data->mobil_no}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                Gender <a class="float-right">{{@$data->gender}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                Ethnicity <a class="float-right">{{@$data->ethnicity}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                D.O.B.<a class="float-right">{{@$data->dob}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                Following Departments <a class="float-right">0</a>
                                            </li>
                                            <li class="list-group-item">
                                                Following Badges <a class="float-right">0</a>
                                            </li>
                                            <li class="list-group-item">
                                                Reported Reviews <a class="float-right">0</a>
                                            </li>
                                            <li class="list-group-item">
                                                Total Reviews <a class="float-right">0</a>
                                            </li>
                                        </ul>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="" id="search_data" class="search_data_row_class">
                                            <div class='row'>
                                                <div class='col-12'>
                                                    <div class="form-group">
                                                        <input class="form-control form-control-sm" type="text"
                                                            placeholder="Search By Name.Badge,Department,Country,State,City....">

                                                    </div>
                                                </div>
                                                <div class='col-5'>
                                                    <div class="form-group">

                                                        <select class="form-control" name="department_id"
                                                            id="department_id">
                                                            <option value="">Select Department</option>
                                                            <option value="1">Department1</option>
                                                            <option value="2">Department2</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='col-5'>
                                                    <div class="form-group">

                                                        <select class="form-control" name="badge_id" id="badge_id">
                                                            <option value="">Select Badge</option>
                                                            <option value="1">Badge1</option>
                                                            <option value="2">Badge2</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='col-6'>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                        class="ni ni-calendar-grid-58"></i></span>
                                                            </div>
                                                            <input class="form-control datepicker"
                                                                placeholder="Select from date" type="text" value=""
                                                                name="fromdate" id="fromdate">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-6'>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                        class="ni ni-calendar-grid-58"></i></span>
                                                            </div>
                                                            <input class="form-control datepicker"
                                                                placeholder="Select to date" type="text" value=""
                                                                name="todate" id="todate">
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" placeholder="Look for user" name="search2"
                                                    id="search2" class="search_input">
                                                <div class='col-2 d-flex'>

                                                    <button type="button" id="search_data1"
                                                        class="btn btn-primary apply_btnn">Apply</button>
                                                    <button type="button" value="Reset form" onclick="myFunction()"
                                                        class="btn btn-info apply_btnn">Reset</button>

                                                </div>
                                            </div>
                                            <!--                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>

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
                                                        <span class="from_to_select">
                                                            <label for="from_text" class="serach_by_text">From</label>

                                                            <input type="date" class="from_control" name="fromdate"
                                                                id="fromdate" style="-webkit-appearance: media-slider;">
                                                            <label for="to_text" class="serach_by_text">To</label>
                                                            <input type="date" class="from_control" name="todate"
                                                                id="todate" style="-webkit-appearance: media-slider;">
                                                        </span>
                                                        <input type="hidden" placeholder="Look for user" name="search2"
                                                            id="search2" class="search_input">
                                                        <button type="button" id="search_data1"
                                                            class="apply_btnn">Apply</button>
                                                    </tr>
                                                </thead>
                                            </table>-->
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card class_scroll ">
                                            <div class="card-body p-0">
                                                <table id="data1" class="table ">
                                                    <!--                                                    <thead>
                                                        <tr>
                                                            {{-- <th><span class="tbl_row">Username</span></th>
                                                        <th><span class="tbl_row">Full Name</span></th>
                                                        <th><span class="tbl_row">Posted on </span></th>
                                                        <th><span class="tbl_row">posted About</span></th>
                                                        <th><span class="tbl_row">Rating</span></th> --}}
                                                            {{-- <th><span class="tbl_row">Username</span></th> --}}
                                                            {{-- <th><span class="tbl_row">Action</span></th> --}}

                                                        </tr>
                                                    </thead>-->
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="card">
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            <div class="post">
                                                <div class="user-block">
                                                    <img class="img-circle img-bordered-sm"
                                                        src="../../dist/img/user1-128x128.jpg" alt="user image">
                                                    <span class="username">
                                                        <a href="#">Jonathan Burke Jr.</a>
                                                        <a href="#" class="float-right btn-tool"></a>
                                                    </span>
                                                    <span class="description">Shared publicly - 7:30 PM today</span>
                                                </div>
                                                <p>
                                                    No Post Available !
                                                </p>
                                                <p>
                                                    <a href="#" class="link-black text-sm mr-2">View Post</a>
                                                </p>
        
                                                <p>
                                                    No Post Available !
                                                </p>
        
        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>

    @endsection
    @section('script')
    {{-- <script type="text/javascript">
    function viewDepartmentBadgeModel1(id){
   // alert(id); 

       $.ajax({
          url: "{{ route('viewDepartmentBadgeModel') }}/" + id,
    type: 'get',
    success: function (response) {
    // console.log(response);
    if(response[0]) {
    $('#businessDetails').html('');
    var i = 0;
    $.each(response, function(key, value){

    var url = '{{ route("BadgeDetail", ":id") }}';
    url = url.replace(':id','id='+value.id);

    let row = `
    <tr>
        <td> ${++i} </td>
        <td class="text-capitalize">${value.badge_number}</td>
        <td class="text-capitalize">0</td>
        <td class="text-capitalize">0</td>
        <td class="text-capitalize"><a href="${url}">View Profile</a></td>
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
    </script> --}}
    <script type="text/javascript">
        $(document).ready(function(){
    var dataTable = $('#data1').DataTable({
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
       "searching": false,
       'processing': true,
       'serverSide': true,
       "bFilter": true,
       "bInfo": false,
       "lengthChange": false,
       "bAutoWidth": false,
       "pageLength": 2,
       "orderable":false,
       'ajax': {
          'url':"{{route('PostDepartmentDetail')}}",
         'data': function(data){
        //       var status_id = $('#status_id').val();
        //     data.status_id = status_id;
        //     var state_id = $('#state_id').val();
        //     data.state_id = state_id;
        //     var country_id = $('#country_id').val();
        //     data.country_id = country_id;
        //     var city_id = $('#city_id').val();
        //     data.city_id = city_id;
            var user_id = $('#user_id').val();
            data.user_id = user_id;
            var department_id = $('#department_id').val();
            data.department_id = department_id;
            var badge_id = $('#badge_id').val();
            data.badge_id = badge_id;
             var fromdate = $('#fromdate').val();
            data.fromdate = fromdate;
            var todate = $('#todate').val();
            data.todate = todate;
           
            
         }
         },
         columnDefs: [
    {
         className: "cancel", "targets": [ -1 ] 
    }
  ],
      'columns': [
        { data: 'image' } ,
          { data: 'userName' } ,
           { data: 'action' },
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
        url: "{{route('delete_post')}}",
        type: "get",
        data: {'post_id':id ,'_token': "{{ csrf_token() }}"},
          success: function (data) {
              //alert();
          //  $(".cancel").(function(){
                
//   $(this).parent("tr:first").remove()
// })
             location.reload();// refresh same page
          }
      });
    }
    </script>
    <script>
        function myFunction() {
      document.getElementById("search_data").reset();
      }
    </script>

    @endsection