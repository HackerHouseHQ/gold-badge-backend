@extends('admin_dash.main')
<style type="text/css">
  .addstateSave{
    margin: 10px;
    margin-left: 211px;
    padding: 16px;

  }
</style>
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

            <div class="panel-heading"> <a href="{{ route('countries')}}"><img src="{{ asset('admin_css/images/back_icon@2x.png') }}"></a>Enter New State</div>
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
              <form class="form-horizontal" method="POST" action="{{route('add_state')}}"          enctype="multipart/form-data">
                {{ csrf_field() }}
                <?php $countryList =  App\Country::get();?>
                  <br>
                  <select name="country_id" id="country_id" class="form-control formn_custom_class_add_form"  required>
                    <option>Select Country</option>
                    @foreach($countryList as $counntryList)
                    <option value="{{$counntryList->id}}">{{$counntryList->country_name}}</option>
                    @endforeach
                  </select>
                  <br>
                  <div class="orm-control formn_custom_class_add_form">
                   <input type="text" class="form-control" placeholder="Enter State Name" name="state_name" value="{{ old('state_name') }}">
                 </div>
                 <p><b>OR</b></p><br>
                  <div class="col-md-6">
                   <input type="file" class="form-control"placeholder="fghj" name="state_file" style="display: block;">
                  </div>
                 <div class="form-group addstateSave">
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
