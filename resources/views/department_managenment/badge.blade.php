@extends('admin_dash.main')
 @section('content')
    <div class="col-sm-12">
     <div class="content-wrapper custom-content-wrapper">
      <div class="below_content_clss">
        <section class="content home_conntent">
          <div class="container-fluid">
            {{-- main header for show list --}}
          <div class="row">
          <div class="main_menu_three_tabs">
           <ul class="nav nav-tabs abc">
            <li><a href="{{route('department')}}">Department List</a>
            </li>
            <li class="active"><a href="{{route('badge')}}">Badge List</a></li>
           </ul>
         </div>
         </div>
         {{-- close --}}
         <form action="" id="search_data" class="search_data_row_class">
          <table class="table table-striped">
           <thead>
            <tr>
            <span class="div_cover_sell">
              <span>
            <select name="status_id" id="status_id" >
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
         <br>
         <br>
         {{--start table --}}
          <br>
         <div class="row">
          <div class="col-md-12">
            <div class="card table_cardd class_scroll">
             <div class="card-body p-0">
             <table class="table table-bordered" id="data1">
               <thead>
                <tr>
                  <th><span class="tbl_row">NAME</span></th>
                  <th><span class="tbl_row">Contact No.</span></th>
                  <th><span class="tbl_row">Email</span></th>
                  <th><span class="tbl_row">Username</span></th>
                  <th><span class="tbl_row">Registered On</span></th>
                  <th><span class="tbl_row">Total Reviews</span></th>
                  <th><span class="tbl_row"></span></th>
                  <th></th>
                  <th></th>
                 </tr>
                </thead>
                <tbody></tbody>
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
        'url':"{{route('userList')}}",
        'data': function(data){
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
});
</script>
<script type="text/javascript">
  function status(id){
       $.ajax({
      url: "{{route('change_status')}}",
      type: "post",
      data: {'user_id':id ,'_token': "{{ csrf_token() }}"},
        success: function (data) {
            location.reload();// refresh same page
        }
    });
  }
</script>
@endsection
