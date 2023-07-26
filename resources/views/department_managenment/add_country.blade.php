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

                <div class="panel-heading"> <a href="{{ route('countries')}}"><img src="{{ asset('admin_css/images/cross_icon.png') }}"></a>Enter New Country</div>
                <div class="panel-body">
                  <form class="form-horizontal" method="GET" action="{{route('add_country')}}">
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="counry_name" value="{{ old('counry_name') }}" required autofocus>
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