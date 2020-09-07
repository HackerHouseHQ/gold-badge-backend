@extends('admin_dash.main')
<style type="text/css">
  .addstateSave {
    margin: 10px;
    margin-left: 211px;
    padding: 16px;

  }
</style>
@section('content')
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Add city</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>

              <li class="breadcrumb-item active" aria-current="page">Add city</li>
            </ol>
          </nav>
        </div>


        <div class="col-lg-6 col-5 text-right">
          {{-- <a href="#" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#department" id="sideshow">Add
            Department</a> --}}
          {{-- <a href="#" class="btn btn-sm btn-neutral">New</a>
          <a href="#" class="btn btn-sm btn-neutral">Filters</a> --}}
          <div class="row-lg-6 row-5">


          </div>
          <br>
          <div class="row-lg-6  row-5" style="float: right;">

          </div>


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
            <div class="below_content_clss">
              <section class="content home_conntent">
                <div class="container-fluid">
                  {{-- add country --}}
                  <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                      <div class="panel panel-default">

                        <div class="panel-heading">Add New City</div>
                        <div class="panel-body">
                          @if ($errors->any())
                          <div class="alert alert-danger">
                            <ul>
                              @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                              @endforeach
                            </ul>
                          </div>
                          @endif
                          <form class="form-horizontal" method="POST" action="{{route('add_city')}}"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <?php $countryList =  App\Country::get();?>
                            <br>
                            <div class="form-group row one_key_pairr">

                              <div class="col-10 col-sm-10 col-md-8 col-lg-4">
                                <div class="to_display_inline">
                                  <select name="country_id" id="country_id"
                                    class="form-control formn_custom_class_add_form" "
                                    required>
                                    <option value="">Select Country</option>
                                    @foreach($countryList as $counntryList)
                                    <option value=" {{$counntryList->id}}">{{$counntryList->country_name}}</option>
                                    @endforeach
                                  </select>

                                </div>
                              </div>
                            </div>
                            <div class="form-group row one_key_pairr">

                              <div class="col-10 col-sm-10 col-md-8 col-lg-4">
                                <div class="to_display_inline">
                                  <select name="state_id" id="state_id" class="form-control formn_custom_class_add_form"
                                    required>
                                    <option value="">Select State</option>
                                  </select>

                                </div>
                              </div>
                            </div>
                            <br>
                            <div class="orm-control formn_custom_class_add_form">
                              <input type="text" class="form-control" placeholder="Enter City Name" name="city_name"
                                value="{{ old('state_name') }}">
                            </div>
                            <p><b>OR</b></p><br>
                            <div class="col-md-6">
                              <div class="row">
                                <input type="file" class="form-control" placeholder="fghj" name="city_file"
                                  style="display: block;">

                                <a href="http://localhost/gold_badge/storage/app/public/csvformat/city.csv"
                                  class="btn btn-sm btn-success">City CSV
                                  Sample</a>
                              </div>

                            </div>
                            <div class="form-group addstateSave">
                              <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                  Save
                                </button>
                                <button class="btn btn btn-info"><a style="color : white;"
                                    href="{{route('countries')}}">Back</a></button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>


                  {{-- close --}}
                </div>
              </section>
            </div>

          </div>
        </div>

      </div>
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
@endsection