@extends('admin_dash.main')
<style type="text/css">
     .leftpane {
        width: 30%;
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
      width: 30%;
      height: 100%;
      position: relative;
      float: right;
      border-collapse: collapse;
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
                 <div class="card-body p-0">
                  
                    <div class="leftpane">
                      <h1>Test Page</h1>
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
                           <p class="tbl_row value">10</p>
                         </div>
                         <div class="key_value_box_div">
                           <label class="tbl_row labell">Following Badge:</label>
                         </div>
                          <div class="key_value_box_div">
                           <p class="tbl_row value">20</p>
                         </div>
                         <div class="key_value_box_div">
                           <label class="tbl_row labell">Total Reviews:</label>
                         </div>
                         <div class="key_value_box_div">
                           <p class="tbl_row value">30</p>
                         </div>
                         <div class="key_value_box_div">
                           <label class="tbl_row labell">Reported Reviews:</label>
                         </div>
                          <div class="key_value_box_div">
                           <p class="tbl_row value">40</p>
                         </div>
                       </div>
                    </div>
                  
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

  @endsection
