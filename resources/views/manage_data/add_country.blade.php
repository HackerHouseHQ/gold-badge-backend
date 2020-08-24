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

            <div class="panel-heading"> <a href="{{ route('countries')}}"><img src="{{ asset('admin_css/images/back_icon@2x.png') }}"></a>Enter New Country</div>
             <div class="panel-body">
                   <h4>   {{session('flash')}}</h4>
              @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif
              <form class="form-horizontal" method="GET" action="{{route('add_country')}}">
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                  <div class="col-md-6">
                   <input type="text" class="form-control" name="country_name" value="{{ old('counry_name') }}" required>
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
