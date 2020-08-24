@extends('admin_dash.main')
<style type="text/css">
  .show{
    margin-left: 31px;
        margin-right: 92px;
}
  .active2{
background: red;
}
</style>
 @section('content')
    <div class="col-sm-12">
     <div class="content-wrapper custom-content-wrapper">
      <div class="below_content_clss">
        <section class="content home_conntent">
          <div class="container-fluid">
             <div class="card-body">
               <input class="form-control form-control-sm" id="search" type="text" placeholder="Search By Name.Badge,Department,Country,State,City....">
             </div>
            {{-- main header for show list --}}
          <div class="row">
          <div class="main_menu_three_tabs">
           <ul class="nav nav-tabs abc">
            <li class=" show"><a href="{{route('department')}}">Department List</a>
            </li>
            <li class="active  show"><a href="{{route('badge')}}">Badge List</a></li>
           </ul>
         </div>
         </div>
         {{-- close --}}
         {{-- add --}}
          <div class="row">
          <div class="main_menu_add_tabs">
           <ul class="nav space_in_li xyy">
           {{--  <li><a href="#"  data-toggle="modal" data-target="#department" class="data2">Add Department<img src="{{ asset('admin_css/images/add_people.png')}}"></a></li> --}}
            <li><a href="#"  data-toggle="modal" data-target="#badge" class="data2">Add Badge<img src="{{ asset('admin_css/images/add_people.png')}}"></a></li>

          </ul>
          </div>
         </div>
         {{-- add --}}
         <form action="" id="search_data" class="search_data_row_class">
          <table class="table table-striped">
           <thead>
            <tr>
            <span class="div_cover_sell">
              <span>
            <select name="status_id" id="status_id" >
              <option value = "">Status</option>
              <option value = "1">Active</option>
              <option value = "2">Inactive</option>
            </select>
          </span>
          </span>
          <span class="div_cover_sell">
            <span>
            <?php $countryList =  App\Country::get();?>
             <select name="country_id" id="country_id">
              <option value = "">Country</option>
              @foreach($countryList as $counntryList)
                 <option value="{{$counntryList->id}}">{{$counntryList->country_name}}</option>
              @endforeach
            </select>
          </span>
          </span>
          <span class="div_cover_sell">
            <span>
             <select name="state_id" id="state_id">
              <option value = "">State</option>
            </select>
          </span>
          </span>
           <span class="div_cover_sell">
            <span>
             <select name="city_id" id="city_id">
              <option value = "">City</option>
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
       {{--   <form class="form-horizontal" action = "#" method="POST" enctype="multipart/form-data" name="upload_excel" >
            {{ csrf_field() }}
         <button type="submit" name="Export"  value="export to excel" class="down_btn_new_clss"/>
            <img src="{{ asset('admin_css/images/download_icon.png') }}" alt="icon" class="img-fluid down_icon_cls">
          </button>
        </form>   --}}
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
                  <th><span class="tbl_row">Badge Number</span></th>
                  <th><span class="tbl_row">Department Name</span></th>
                  <th><span class="tbl_row">Badge Rating</span></th>
                  <th><span class="tbl_row">Department Rating</span></th>
                  <th><span class="tbl_row">Registered On</span></th>
                  <th><span class="tbl_row"></span></th>
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

        {{-- start add department model view --}}
            <div id="department" class="modal">
             <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
               
                 <div class="modal-header">
                  <h4 class="modal-title text-capitalize" id="userName"></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                  </button>
                 </div>
                  <div class="modal-body">
                   <div class="row">
                    <div class="col-md-12">
                     <div class="table-responsive">
                       <form class="form-horizontal" action="{{route('AddDepartment')}}" enctype="multipart/form-data" method="POST">
                         {{ csrf_field() }}
                <div class="card-body">
                                  
                   <div class="form-group row">
                    <div class="form-group">
                    <input type="text" class="form-control" placeholder="Department Name" name="department_name">
                  </div>
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
                <div class="card-footer">
                  <button type="submit" class="btn btn-info float-right">Add</button>
                </div>
                <!-- /.card-footer -->
              </form>
                      </div>
                     </div>
                    </div>
                   </div>
                  </div>
                 </div>
                </div>
               {{-- end add department  --}}
               {{-- start add badge model view --}}
            <div id="badge" class="modal">
             <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
               
                 <div class="modal-header">
                  <h4 class="modal-title text-capitalize" id="userName"></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                  </button>
                 </div>
                  <div class="modal-body">
                   <div class="row">
                    <div class="col-md-12">
                     <div class="table-responsive">
                       <form class="form-horizontal" action="{{route('AddBadge')}}" method="GET">
                         {{ csrf_field() }}
                       <div class="card-body">
                        <?php $departmentName = App\Department::where('status',1)->get(); ?>
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
                </div>
               {{-- end add badge  --}}
      </div>
      </div>
    </div>
  @endsection
  @section('script')
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
              for( var i = 0; i<len; i++){
                var id = response[i]['id'];
                var name = response[i]['name'];
                $("#state_id").append("<option value=''>Please Select</option>");
                $("#state_id").append("<option value='"+id+"'>"+name+"</option>");
              }
            }
        });
    });
  });
</script>
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
        'url':"{{route('badge_list')}}",
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
        { data: 'badge_name' } ,
        { data: 'department_name' },
        { data: 'badge_rating' },
        { data: 'department_rating' },
        { data: 'registered_on' },
        { data: 'view' },
    ]
  });
  $('#search_data1').click(function(){
     dataTable.draw();
  });
});
</script>
<script type="text/javascript">
  function status(id){
       $.ajax({
      url: "{{route('badge_status')}}",
      type: "post",
      data: {'user_id':id ,'_token': "{{ csrf_token() }}"},
        success: function (data) {
            location.reload();// refresh same page
        }
    });
  }
</script>
 
@endsection
