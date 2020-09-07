@extends('admin_dash.main')
@section('content')
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Notification</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">Notification</li>
            </ol>
          </nav>
        </div>


        <div class="col-lg-6 col-5 text-right">
          {{-- <a href="#" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#department" id="sideshow">Add
            Department</a> --}}
          {{-- <a href="#" class="btn btn-sm btn-neutral">New</a>
          <a href="#" class="btn btn-sm btn-neutral">Filters</a> --}}
          <button type="button" class="btn btn-info down_btn_new_clss_notification" data-toggle="modal"
            data-target="#myModal" />Send Notification</button>
          {{-- <a href="#" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#department" id="sideshow">Add
            Department</a> --}}
        </div>
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
                <div class='col-3'>
                  <div class="form-group">
                    <select class="form-control" name="date1" id="date1">
                      {{-- <option value = "1">Today</option> --}}
                      <option value="">Select today , week or month</option>
                      <option value="1">Today</option>
                      <option value="2">A week</option>
                      <option value="3">A month</option>
                    </select>
                  </div>
                </div>
                <div class='col-3'>
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
                <div class='col-3'>
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
                <div class='col-3'>
                  <button type="button" id="search_data1" class="btn btn-primary apply_btnn">Apply</button>

                </div>
              </div>
            </form>

          </div>
        </div>

        <div class="table-responsive py-4">
          <table class="table table-flush" id="datatable-basic">
            <thead class="thead-light">
              <tr>
                <th>Message</th>
                <th>Time</th>
                <th>Date</th>
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
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <br><br>
    <div class="modal-content">
      <div class="modal-header">
        <center>
          <h4 class="modal-title">New Notification</h4>
        </center>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="{{route('sendNotification')}}" method="get">
          <div class="form-group">
            <input class="form-control" type="title" name="title" placeholder="Notification Title" value=""><br>
          </div>
          <div class="form-group">
            <textarea class="form-control" name="desscription" placeholder="Desscription"
              style="width: 100%; height: 159; font-size: 18px; line-height: 34px; border: 1px solid #dddddd; padding: 10px;background: #ffffff;"></textarea>
          </div>
          <div class="form-group notifiction_send_btn text-center">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>



    </div>

  </div>
</div>
{{-- close model --}}
{{-- model view city --}}
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-capitalize" id="businessName">Notification</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form a>
          <div class="form-group">
            <input class="form-control" type="title" name="title" id="title1" placeholder="Notification Title"
              value=""><br>
          </div>
          <div class="form-group">
            <textarea class="form-control" name="desscription" id="desscription1" placeholder="Desscription"
              style="width: 100%; height: 159; font-size: 18px; line-height: 34px; border: 1px solid #dddddd; padding: 10px;background: #ffffff;"></textarea>
          </div>

        </form>

      </div>
    </div>
  </div>
</div>
</div>
{{-- end model view city --}}

@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
  var dataTable = $('#datatable-basic').DataTable({
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
    //  'processing': true,
     'serverSide': true,
     "bFilter": true,
     "bInfo": true,
     "lengthChange": true,
     "bAutoWidth": true,
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
        {data :'view'}
       
      
      
    ]
  });
 $('#search_data1').click(function(){
     dataTable.draw();
  });
});
function viewNotificationModel1(id){
    // alert(id);
     $.ajax({
          url: "{{ route('viewNotificationModel') }}/" + id, 
          type: 'get',
          success: function (response) {
            console.log(response);
            var space=" ";
          if(response) {
            
           $('#title1').val(response.title ) ;
           $('#desscription1').val(response.message);
              
            } else {
              let row = `
                <span>
                  Record not found! 
                </span>
                `;
                $('#notificationDetail').html(row);
            }
             $('#exampleModalCenter').modal('show');
        },
        error: function(err) {
          console.log(err);
        }
      });
  }
</script>
@endsection