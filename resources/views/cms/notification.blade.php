@extends('admin_dash.main')
 @section('content')
    <div class="col-sm-12">
     <div class="content-wrapper custom-content-wrapper">
      <div class="below_content_clss">
        <section class="content home_conntent">
          <div class="container-fluid">
         <form action="" id="search_data" class="search_data_row_class">
          <table class="table table-striped">
           <thead>
            <tr>
              <span class="div_cover_sell">
              <span>
            <select name="user_id" id="user_id" >
              <option value = "">Recipients</option>
              <option value = "">Today</option>
              <option value = "">A week</option>
              <option value = "">A month</option>
            </select>
          </span>
          </span>
          <span class="div_cover_sell">
            <span>
             <select name="date1" id="date1">
              <option value = "">Today</option>
              <option value = "">A week</option>
              <option value = "">A month</option>
             
            </select>
          </span>
          </span>
            <span class="from_to_select">
             <label for="from_text" class="serach_by_text">From</label>
             
             <input type="date" class="from_control" name="fromdate" id="fromdate" style="-webkit-appearance: media-slider;">
              <label for="to_text" class="serach_by_text">To</label>
              <input type="date" class="from_control" name="todate" id="todate" style="-webkit-appearance: media-slider;">
            </span>
            <input type="hidden" placeholder="Look for user" name="search2" id="search2" class="search_input">
            <button type="button" id="search_data1" class="apply_btnn">Apply</button>

            
            </tr>
           </thead>
          </table>
        </form>
         <form class="form-horizontal" action = "#" method="POST" enctype="multipart/form-data" name="upload_excel" >
            {{ csrf_field() }}
         <button type="submit" name="Export"  value="export to excel" class="down_btn_new_clss"/>
            <img src="{{ asset('admin_css/images/download_icon.png') }}" alt="icon" class="img-fluid down_icon_cls">
          </button>
        </form>  
         <button type="button" class="btn btn-primary down_btn_new_clss_notification"  data-toggle="modal" data-target="#myModal"/>Send Notification</button>
         <!-- Modal -->
              <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <br><br>
                  <div class="modal-content">
                    <div class="modal-header">
                      <center><p class="modal-title">New Notification</p></center>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                   <div class="modal-body">
                   <form action ="#" method="get">
                    <br><br>
                    <div class="form-group">
                     <input type="title" name="title" placeholder="Notification Title" value=""><br>
                     </div>
                     <div class="form-group">
                       <textarea name="desscription" placeholder="Desscription"  style="width: 100%; height: 159; font-size: 18px; line-height: 34px; border: 1px solid #dddddd; padding: 10px;background: #ffffff;"></textarea>
                     </div>
                       <div class="form-group notifiction_send_btn">
                        <button type="submit" class="btn btn-primary">Save</button>
                     </div>
                   </form> 
                   </div>


                   
                  </div>

                </div>
              </div>
            {{-- close model --}}
         <br>
         <br>

        <table id="data" class="table table-striped">
         <thead>
          <tr>
           <th><span class="tbl_row"></span></th>
           <th><span class="tbl_row"></span></th>
           <th><span class="tbl_row"></span></th>
          </tr>
          </thead>
          <tbody>
            <tr>
             <td>sdf</td>
             <td>sdf</td>
             <td>sdf</td>
            </tr>
           </tbody>
          </table>
          </div>
        </section>
      </div>
      </div>
    </div>
  @endsection
  @section('script')
@endsection
