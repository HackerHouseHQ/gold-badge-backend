@extends('admin_dash.main')
@section('content')
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Manage Report</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">State</li>
            </ol>
          </nav>
        </div>

      </div>
    </div>
  </div>
</div>
<div class="container-fluid mt--6">
  <div class="container-fluid mt--6">


    <div class="col-lg-12">
      <div class="card-wrapper">
        <!-- Form controls -->
        <div class="card">
          <!-- Card header -->
          <div class="card-header">
            <h3 class="mb-0">Add State</h3>
          </div>
          <!-- Card body -->
          <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
            <form class="form-horizontal" method="POST" action="{{route('add_state')}}" enctype="multipart/form-data">
              {{ csrf_field() }}
              <?php $countryList =  App\Country::get(); ?>
              <div class="form-group">
                <label class="form-control-label" for="exampleFormControlInput1">Country</label>
                <select class="form-control" name="country_id" id="country_id">
                  <option value="">Select Country</option>
                  @foreach($countryList as $counntryList)
                  <option value="{{$counntryList->id}}">{{$counntryList->country_name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label class="form-control-label" for="exampleFormControlInput1">State Name</label>
                <input type="text" class="form-control" name="state_name" value="{{ old('state_name') }}" placeholder="Enter State Name">
              </div>
              <div class="form-group">
                OR
              </div>
              <div class="row">
                <div class="col-9">
                  <div class="form-group">
                    <input type="file" class="form-control" name="state_file">
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">

                    <a href="{{route('stateExport')}}" class="btn btn-primary">File
                      upload sample</a>
                  </div>
                </div>
              </div>
              <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Save</button>
                <a style="color : white;" href="{{route('countries')}}"><button type="button" class="btn btn btn-info">Back</button></a>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>

  </div>
  <!-- Footer -->
  {{-- <footer class="footer pt-0">
    <div class="row align-items-center justify-content-lg-between">
      <div class="col-lg-6">
        <div class="copyright text-center  text-lg-left  text-muted">
          © 2020 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">Creative Tim</a>
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

</div>


@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function() {
    var dataTable = $('#datatable-basic').DataTable({
      language: {
        searchPlaceholder: "Department Name",
        paginate: {
          previous: '<i class="fas fa-angle-left"></i>',
          next: '<i class="fas fa-angle-right"></i>'
        },
        aria: {
          paginate: {
            previous: 'Previous',
            next: 'Next'
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
        'url': "{{route('notificationList')}}",
        'data': function(data) {
          var date1 = $('#date1').val();
          data.date1 = date1;
          var fromdate = $('#fromdate').val();
          data.fromdate = fromdate;
          var todate = $('#todate').val();
          data.todate = todate;
        }
      },
      'columns': [{
          data: 'message'
        },
        {
          data: 'time'
        },
        {
          data: 'date'
        },
      ]
    });
    $('#search_data1').click(function() {
      dataTable.draw();
    });
  });
</script>
@endsection