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
    .img-r{
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
    <div class="col-sm-12">
     <div class="content-wrapper custom-content-wrapper">
      <div class="below_content_clss">
        <section class="content home_conntent">
          <div class="container-fluid">
         {{--start table --}}
          <br>
             <div class="row">
              <div class="col-md-12">
                <div class="card table_cardd">
          
                 <div class="card-body ">
                  
                    <div class="leftpane">
                     <div class="img-r">
                                    <img src="{{$data->image}}" alt="" style="width: 100px;">
                                </div>
                    </div>
                    <div class="middlepane">
                       <div class="key_value_box">
                         <div class="key_value_box_div">
                           <label class="tbl_row labell">Full Name:</label>
                         </div>
                         <div class="key_value_box_div">
                           <p class="tbl_row value">{{$data->first_name}} {{$data->last_name}}</p>
                         </div>
                         <div class="key_value_box_div">
                           <label class="tbl_row labell">Username:</label>
                         </div>
                         <div class="key_value_box_div">
                           <p class="tbl_row value">{{$data->username}}</p>
                         </div>
                         <div class="key_value_box_div">
                           <label class="tbl_row labell">MOB. NO.:</label>
                         </div>
                         <div class="key_value_box_div">
                           <p class="tbl_row value">{{$data->mobile_country_code}}-{{$data->mobile_no}}</p>
                         </div>
                         <div class="key_value_box_div">
                           <label class="tbl_row labell">Email:</label>
                         </div>
                         <div class="key_value_box_div">
                           <p class="tbl_row value">{{$data->email}}</p>
                         </div>
                         <div class="key_value_box_div">
                           <label class="tbl_row labell">Gender:</label>
                         </div>
                         <div class="key_value_box_div">
                           <p class="tbl_row value">{{$data->gender}}</p>
                         </div>
                       </div>
                    </div>
                    <div class="rightpane">
                       <div class="key_value_box">
                         <div class="key_value_box_div">
                           <label class="tbl_row labell">Ethnicity:</label>
                         </div>
                         <div class="key_value_box_div">
                           <p class="tbl_row value">{{$data->ethnicity}}</p>
                         </div>
                         <div class="key_value_box_div">
                           <label class="tbl_row labell">DOB:</label>
                         </div>
                         <div class="key_value_box_div">
                           <?php $r_date = date("d/m/Y", strtotime($data->dob));?>
                           <p class="tbl_row value">{{$r_date}}</p>
                         </div>
                          <div class="key_value_box_div">
                           <label class="tbl_row labell">Following Department:</label>:
                         </div>
                         <div class="key_value_box_div">
                           <p class="tbl_row value">0</p>
                         </div>
                         <div class="key_value_box_div">
                           <label class="tbl_row labell">Following Badge:</label>
                         </div>
                          <div class="key_value_box_div">
                           <p class="tbl_row value">0</p>
                         </div>
                         <div class="key_value_box_div">
                           <label class="tbl_row labell">Total Reviews:</label>
                         </div>
                         <div class="key_value_box_div">
                           <p class="tbl_row value">0</p>
                         </div>
                         <div class="key_value_box_div">
                           <label class="tbl_row labell">Reported Reviews:</label>
                         </div>
                          <div class="key_value_box_div">
                           <p class="tbl_row value">0</p>
                         </div>
                       </div>
                    </div>
                  
                </div>
                </div>
                </div>
               </div>
         {{-- end table --}}
         {{-- start datatable --}}
          <div class="card">
            <div class="card-header">
              <div class="main_menu_three_tabs1">
           <ul class="nav nav-tabs abc">
            <li class="active"><a href="{{ route('UserDetail',['id' => $data->id])}}"> Reviews</a></li>
            <li ><a href="{{ route('UserDetailFollowing',['id' => $data->id])}}"> Followings</a></li>
          </ul>
          
         </div>
              {{-- <h3 class="card-title"></h3> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="userDetails" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Department Name</th>
                  <th>Badge Number</th>
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
            <!-- /.card-body -->
          </div>
         {{-- end end datatable --}}
          </div>
        </section>
      </div>
      </div>
    </div>
  @endsection
  @section('script')
<script type="text/javascript">
  $(document).ready(function(){
  var dataTable = $('#userDetails').DataTable({
     "searching": false,
     'processing': true,
     'serverSide': true,
     "bFilter": true,
     "bInfo": false,
     "lengthChange": false,
     "bAutoWidth": false,
     'ajax': {
        'url':"{{route('userReviewList')}}",
        'data': function(data){
         
        }
       },
    'columns': [
        { data: 'departmentName' } ,
        { data: 'BadgeNumber' },
        { data: 'rating' },
        { data: 'like' },
        { data: 'share' },
        { data: 'comment' },
        { data: 'report' },
        { data: 'action' },
    ]
  });
   $('#search_data1').click(function(){
     dataTable.draw();
  });
});
</script>
  @endsection
