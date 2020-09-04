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
             {{--  <span class="div_cover_sell">
              <span>
            <select name="user_id" id="user_id" >
              <option value = "">Recipients</option>
              <option value = "">Today</option>
              <option value = "">A week</option>
              <option value = "">A month</option>
            </select>
          </span>
          </span> --}}
          <span class="div_cover_sell">
            <span>
             <select name="date1" id="date1">
              {{-- <option value = "1">Today</option> --}}
              <option value = "1">Today</option>
              <option value = "2">A week</option>
              <option value = "3">A month</option>
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
            <button type="button" id="search_data1" class="apply_btnn1">Apply</button>

            
            </tr>
           </thead>
          </table>
        </form>
         <form class="form-horizontal" action = "#" method="post" enctype="multipart/form-data" name="upload_excel" >
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
                   <form action ="{{route('sendNotification')}}" method="get">
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

         {{--start table --}}
          <br>
       {{--   <div class="row">
          <div class="col-md-12">
            <div class="card table_cardd class_scroll">
             <div class="card-body p-0">
             <table class="table table-bordered  table-hover" id="data1">
               <thead>
                <tr>
                  <th><span class="tbl_row1">Notification Title</span></th>
                  <th><span class="tbl_row1">Time</span></th>
                  <th><span class="tbl_row1">Date</span></th>
                 </tr>
                </thead>
                <tbody></tbody>
               </table>
              </div>
             </div>
            </div>
           </div> --}}
        {{--  --}}
         <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <table id="data1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Message</th>
                  <th>Time</th>
                  <th>Date</th>
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
        'url':"{{route('notificationList')}}",
        'data': function(data){
           var date1 = $('#date1').val();
          data.date1 = date1;
           var fromdate = $('#fromdate').val();
          data.fromdate = fromdate;
          var todate = $('#todate').val();
          data.todate = todate;
        }
       },
    'columns': [
        { data: 'message' } ,
        { data: 'time' },
        { data: 'date' },
    ]
  });
 $('#search_data1').click(function(){
     dataTable.draw();
  });
});
</script>
@endsection
