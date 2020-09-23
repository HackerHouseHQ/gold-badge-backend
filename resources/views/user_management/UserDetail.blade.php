@extends('admin_dash.main')


<style type="text/css">
  .leftpane {
    width: 20%;
    height: 100%;
    float: left;
    border-collapse: collapse;
  }

  .middlepane {
    width: 40%;
    height: 100%;
    float: left;
    border-collapse: collapse;
  }

  .rightpane {
    width: 40%;
    height: 100%;
    position: relative;
    float: right;
    border-collapse: collapse;
  }

  .img-r {
    /*height: 200px; */
    /*width: 200px; */
    /*margin:0 auto;*/
    height: 118px;
    width: 119px;
    margin-top: 0px;
    margin-bottom: 38px;
    margin-left: -14px;
    border-radius: 100px;
    overflow: hidden;
    border: 7px solid #f6f6f6;
  }
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
              <li class="breadcrumb-item"><a href={{route('user')}}>User</a></li>
              <li class="breadcrumb-item active" aria-current="page">User Detail</li>
              {{-- <li> <button class="btn btn-primary" data-toggle="sweet-alert" data-sweet-alert="confirm">Confim
                  alert</button></li> --}}

            </ol>
          </nav>
        </div>
        <!--
        <div class="col-lg-6 col-5 text-right">
          <a class="btn btn-sm btn-neutral" href="{{ route('UserDetail',['id' => $data->id])}}"> Reviews</a>
<a class="btn btn-sm btn-neutral" href="{{ route('UserDetailFollowing',['id' => $data->id])}}"> Followings</a>

</div>-->
      </div>
    </div>
  </div>
</div>
<div class="container-fluid mt--6">
  <!-- Table -->
  <input type="hidden" value="{{$data->id}}" id="user_id">
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body ">

          <div class="leftpane">
            <div class="img-r">
              <img src="../storage/uploads/user_image/{{$data->image}}" alt="user-image">
            </div>
          </div>
          <div class="middlepane">
            <div class="key_value_box">
              <div class="key_value_box_div">
                <label class="tbl_row labell">Full Name:</label>
                <span class="tbl_row value userDetailsColor">{{@$data->first_name}} {{@$data->last_name}}</span>
              </div>
              <div class="key_value_box_div">
                <label class="tbl_row labell">Username:</label>
                <span class="tbl_row value userDetailsColor">{{$data->user_name}}</span>
              </div>
              <div class="key_value_box_div">
                <label class="tbl_row labell">MOB. NO.:</label>
                <span class="tbl_row value userDetailsColor">{{$data->mobile_country_code}}-{{$data->mobil_no}}</span>
              </div>
              <div class="key_value_box_div">
                <label class="tbl_row labell">Email:</label>
                <span class="tbl_row value userDetailsColor">{{$data->email}}</span>
              </div>
              <div class="key_value_box_div">
                <label class="tbl_row labell">Gender:</label>
                <span class="tbl_row value userDetailsColor">{{$data->gender}}</span>
              </div>
            </div>
          </div>
          <div class="rightpane">
            <div class="key_value_box">
              <div class="key_value_box_div">
                <label class="tbl_row labell">Ethnicity:</label>
                <span class="tbl_row value userDetailsColor">{{$data->ethnicity}}</span>
              </div>
              <div class="key_value_box_div">
                <label class="tbl_row labell">DOB:</label>
                <?php $r_date = date("d/m/Y", strtotime($data->dob));?>
                <span class="tbl_row value userDetailsColor">{{$r_date}}</span>
              </div>
              <div class="key_value_box_div">
                <?php $followcount =  App\UserDepartmentFollow::where('user_id' , $data->id)->count(); ?>
                <label class="tbl_row labell">Following Department:</label>
                <span class="tbl_row value userDetailsColor">{{ ($followcount) >0 ? $followcount : 0}}</span>
              </div>

              <div class="key_value_box_div">
                <?php $followBadgecount =  App\UserDepartmentBadgeFollow::where('user_id' , $data->id)->count(); ?>
                <label class="tbl_row labell">Following Badge:</label>
                <span class="tbl_row value userDetailsColor">{{$followBadgecount}}</span>
              </div>
              <div class="key_value_box_div">

              </div>
              <div class="key_value_box_div">
                <?php $Reviewcount =  App\Post::where('user_id' , $data->id)->count(); ?>

                <label class="tbl_row labell">Total Reviews:</label>
                <span class="tbl_row value userDetailsColor">{{ ($Reviewcount) >0 ? $Reviewcount : 0}}</span>
              </div>
              <div class="key_value_box_div">
                <?php $reportedCount =  App\DepartmentReport::where('user_id' , $data->id)->count(); ?>
                <label class="tbl_row labell">Reported Reviews:</label>
                <span class="tbl_row value userDetailsColor">{{$reportedCount}}</span>
              </div>
            </div>
          </div>
          <div>
          </div>

        </div>
        <!-- tab-->
        <div class="row">
          <div class="col-3">
          </div>
          <div class="col-3">
            <a href="{{ route('UserDetail',['id' => $data->id])}}" class="btn btn-success" data-toggle="notify"
              data-placement="top" data-align="center" data-type="info" data-icon="ni ni-bell-55">Reviews</a>
          </div>
          <div class="col-3">
            <a href="{{ route('UserDetailFollowing',['id' => $data->id])}}" class="btn btn-info" data-toggle="notify"
              data-placement="top" data-align="center" data-type="info" data-icon="ni ni-bell-55">Followings</a>
          </div>
          <div class="col-3">
          </div>
        </div>
        <!--            <div class="tab-content">
            <div id="nav-pills-component" class="tab-pane tab-example-result fade show active" role="tabpanel" aria-labelledby="nav-pills-component-tab">
              <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="tabs-text" role="tablist">
                  <li class="nav-item">
                  <a class="nav-link mb-sm-3 mb-md-0" href="{{ route('UserDetail',['id' => $data->id])}}"  style="color:#fff;background-color:#2dce89" >Reviews</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-sm-3 mb-md-0 active"  href="{{ route('UserDetailFollowing',['id' => $data->id])}}" >Followings</a>
                </li>
              </ul>
            </div>
          </div>-->



        <div class="table-responsive py-4">
          <table class="table table-flush" id="datatable-basic">
            <thead class="thead-light">
              <tr>
                <th>Department Name</th>
                <th>Badge Number</th>
                <th>Date</th>
                <th>Rating</th>
                <th>Likes</th>
                <th>Share</th>
                <th>Comment</th>
                <th>Report</th>
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

{{-- model view department --}}
<div class="modal fade" id="viewUserDetailModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-capitalize" id="businessName"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-6" id="userImage">
            <img
              src="https://png.pngtree.com/png-clipart/20190924/original/pngtree-user-vector-avatar-png-image_4830521.jpg"
              alt="" style="width: 300px; height:300px;">
          </div>
          <div class="col-6" id="viewDepartment">


          </div>
        </div>
        {{-- <div class="row">
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
        </div> --}}
      </div>
    </div>
  </div>
</div>
{{-- end model view department --}}
{{-- model view department --}}
<div class="modal fade" id="viewUserDetailLikeModel" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-capitalize" id="businessName1"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-6" id="userImage1">
            <img
              src="https://png.pngtree.com/png-clipart/20190924/original/pngtree-user-vector-avatar-png-image_4830521.jpg"
              alt="" style="width: 300px; height:300px;">
          </div>
          <div class="col-6" id="viewDepartmentLike">


          </div>
        </div>
        {{-- <div class="row">
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
        </div> --}}
      </div>
    </div>
  </div>
</div>
{{-- end model view department --}}
<div class="modal fade" id="viewUserDetailShareModel" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-capitalize" id="share"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="share">
        <div class="row">
          <div class="col-6" id="userImage2">
            <img
              src="https://png.pngtree.com/png-clipart/20190924/original/pngtree-user-vector-avatar-png-image_4830521.jpg"
              alt="" style="width: 300px; height:300px;">
          </div>
          <div class="col-6" id="viewDepartmentShare">


          </div>
        </div>
        {{-- <div class="row">
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
        </div> --}}
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="viewUserDetailCommentModel" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-capitalize" id="comment"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="share">
        <div class="row">
          <div class="col-6" id="userImage2">

          </div>
          <div class="col-6" id="viewDepartmentComment">


          </div>
        </div>
        {{-- <div class="row">
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
        </div> --}}
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    var dataTable = $('#datatable-basic').DataTable({
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
     "searching": false,
     'processing': true,
     'serverSide': true,
     "bFilter": true,
     "bInfo": true,
     "lengthChange": true,
     "bAutoWidth": true,
       'ajax': {
          'url':"{{route('UserDetailData')}}",
          'data': function(data){
              var user_id = $('#user_id').val();
            data.user_id = user_id;
          }
         },
      'columns': [
          { data: 'department_name' },
          { data: 'badge_number' } ,
          {data :'date'},
          { data: 'rating' },
          {data :'likes'},
          {data :'share'} ,
          {data : 'comment'},
          {data :'report'},
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
<script>
  function viewUserDetailCommentModel(id){
    $.ajax({
          url: "{{ route('viewUserDetailCommentModel') }}/" + id, 
          type: 'get',
          success: function (response) {
console.log(response);
         
        $('#viewUserDetailCommentModel').modal('show');
        },
        error: function(err) {
          console.log(err);
        }
      });
  }
  function viewUserDetailShareModel(id){
    // $('#viewUserDetailLikeModel').modal('show');
    $.ajax({
          url: "{{ route('viewUserDetailShareModel') }}/" + id, 
          type: 'get',
          success: function (response) {
            $('#share').html(``);
            $('#userImage2').html(``);
            
           let rowImage = `<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">`;
  let i = 1;
    response.forEach(value => {
        value.post_images.forEach(image => {
          if(i==1)
          {
            rowImage +=` <div class="carousel-item active">
      <img class="d-block w-100" src="../storage/uploads/post_department_image/${image.image}" style="width: 300px; height:300px;" alt="First slide">
    </div>`;
          }
          else{
            rowImage +=` <div class="carousel-item">
      <img class="d-block w-100" src="../storage/uploads/post_department_image/${image.image}" style="width: 300px; height:300px;" alt="Second slide">
    </div>`;
          }
           
           i++;
         });
       }); 
       rowImage +=`</div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>`;
$('#userImage2').append(rowImage);
        $('#viewDepartmentShare').html('');
            
            response.forEach(value => {
              let row=` <div class="col">
        <span><img src="../storage/uploads/user_image/${value.image}" alt="user_image" class="avatar" style=" vertical-align: middle; width: 50px; height: 50px; border-radius: 50%;"></span>
        <span>${value.user_name}</span>
        <br>
            </div>`;
            $('#viewDepartmentShare').append(row)
            }); 
            if(response.length == 0)
            {
              $('#userImage2').html(``);
            $('#share').html(``);

              $('#share').html('<h4>no record found</h4>');
            }
            console.log(response);
         
        $('#viewUserDetailShareModel').modal('show');
        },
        error: function(err) {
          console.log(err);
        }
      });
  }
  function viewUserDetailLikeModel(id){
    $('#viewUserDetailLikeModel').modal('show');
    $.ajax({
          url: "{{ route('viewUserDetailLikeModel') }}/" + id, 
          type: 'get',
          success: function (response) {
            $('#userImage1').html(``);
            $('#businessName1').html('');
           let rowImage = `<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">`;
  let i = 1;
    response.forEach(value => {
        value.post_images.forEach(image => {
          if(i==1)
          {
            rowImage +=` <div class="carousel-item active">
      <img class="d-block w-100" src="../storage/uploads/post_department_image/${image.image}" style="width: 300px; height:300px;" alt="First slide">
    </div>`;
          }
          else{
            rowImage +=` <div class="carousel-item">
      <img class="d-block w-100" src="../storage/uploads/post_department_image/${image.image}" style="width: 300px; height:300px;" alt="Second slide">
    </div>`;
          }
           
           i++;
         });
       }); 
       rowImage +=`</div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>`; 

$('#userImage1').append(rowImage);
        $('#viewDepartmentLike').html('');
            
            response.forEach(value => {
              let row=` <div class="col">
        <span><img src="../storage/uploads/user_image/${value.image}" alt="user_image" class="avatar" style=" vertical-align: middle; width: 50px; height: 50px; border-radius: 50%;"></span>
        <span>${value.user_name}</span>
        <br>
            </div>`;
            $('#viewDepartmentLike').append(row)
            }); 
            if(response.length == 0)
            {
            $('#userImage1').html(``);
            $('#viewDepartmentLike').html('');
              $('#businessName1').html('no record found</>');
            }
            console.log(response);
         
        $('#viewUserDetailLikeModel').modal('show');
        },
        error: function(err) {
          console.log(err);
        }
      });
  }
  function viewUserDetailModel(id){
    // alert(id);
    $.ajax({
          url: "{{ route('viewUserDetailModel') }}/" + id, 
          type: 'get',
          success: function (response) {
            $('#userImage').html(``);
           let rowImage = `<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">`;
  let i = 1;
   
        response.post_image.forEach(image => {
          if(i==1)
          {
            rowImage +=` <div class="carousel-item active">
      <img class="d-block w-100" src="../storage/uploads/post_department_image/${image.image}" style="width: 300px; height:300px;" alt="First slide">
    </div>`;
          }
          else{
            rowImage +=` <div class="carousel-item">
      <img class="d-block w-100" src="../storage/uploads/post_department_image/${image.image}" style="width: 300px; height:300px;" alt="Second slide">
    </div>`;
          }
           
           i++;
         });
      
       rowImage +=`</div>
  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>`;
$('#userImage').append(rowImage);
if(response.post_image.length == 0)
{
    $('#userImage').html(` <img
              src="https://png.pngtree.com/png-clipart/20190924/original/pngtree-user-vector-avatar-png-image_4830521.jpg"
              alt="" style="width: 300px; height:300px;">`);

}
          //   if(typeof response.departments.image != "undefined"){ 
              
          //   $('#userImage').html(`<img
          //     src="../storage/departname/${response.departments.image}"
          //     alt="" style="width: 300px; height:300px;">`);
          // }else{
          //   $('#userImage').html(` <img
          //     src="https://png.pngtree.com/png-clipart/20190924/original/pngtree-user-vector-avatar-png-image_4830521.jpg"
          //     alt="" style="width: 300px; height:300px;">`);
          // }
            $('#viewDepartment').html('');
            // <a href='javascript:void(0)' onclick ='viewUserDetailCommentModel(${response.id})'>view list</a>
         let row=` <div class="col">
        <span><img src="../storage/uploads/user_image/${response.users.image}" alt="user_image" class="avatar" style=" vertical-align: middle; width: 50px; height: 50px; border-radius: 50%;"></span>
        <br>
              <span>Full Name:</span>
              <span>${response.users.first_name}</span>
              <br>
              <span>Posted On:</span>
              <span>${response.created_at.substr(0,10).split('-').reverse().join('/')}</span>
              <br>
              <span>Likes:</span>
              <span>${response.department_like}</span>
              <a href='javascript:void(0)' onclick ='viewUserDetailLikeModel(${response.id})'>view list</a>
              <br>
              <span>Share:</span>
              <span>${response.department_share}</span>
              <a href='javascript:void(0)' onclick ='viewUserDetailShareModel(${response.id})'>view list</a>
              <br>
              <span>Comments:</span>
              <span>${response.department_comment}</span>
              <br>
              <span>Report:</span>
              <span>${response.department_report} </span>
              <br>
              <span>Rating:</span>
              <span>${response.rating}</span>
              <br>
              <span>Review:</span>
              <span>${(response.comment) ? response.comment : " " }</span>
              <br>
            </div>`;
            $('#viewDepartment').append(row)
        $('#viewUserDetailModel').modal('show');
        },
        error: function(err) {
          console.log(err);
        }
      });
      
      }
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
        },
        error: function(err) {
          console.log(err);
        }
    });
  }
</script>

@endsection