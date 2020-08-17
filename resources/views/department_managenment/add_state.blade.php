@extends('admin_dash.main')
 @section('content')
    <div class="col-sm-12">
     <div class="content-wrapper custom-content-wrapper">
      <div class="below_content_clss">
        <section class="content home_conntent">
          <div class="container-fluid">
         {{-- add country --}}
        <div class="row">
         <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">

            <div class="panel-heading"> <a href="{{ route('countries')}}"><img src="{{ asset('admin_css/images/cross_icon.png') }}"></a>Enter New State</div>
             <div class="panel-body">
              <form class="form-horizontal" method="POST" action="{{route('add_state')}}"          enctype="multipart/form-data">
                {{ csrf_field() }}
                <?php $countryList =  App\Country::get();?>
                  <select>
                    <option>Select Country</option>
                    @foreach($countryList as $counntryList)
                    <option>{{$counntryList->country_name}}</option>
                    @endforeach
                  </select>
                  <div class="form-group">
                  <div class="col-md-6">
                   <input type="text" class="form-control" name="counry_name" value="{{ old('state_name') }}" required autofocus>
                  </div>
                 </div>
                    <br><p>or</p><br>
                 <div class="form-group">
                  <div class="col-md-6">
                   <input type="file" class="form-control" name="city_file">
                  </div>
                 </div>
                 <div class="form-group">
                  <div class="col-md-8 col-md-offset-4">
                   <button type="submit" class="btn btn-primary">
                    Save
                   </button>
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
  @endsection
  @section('script')
@endsection
