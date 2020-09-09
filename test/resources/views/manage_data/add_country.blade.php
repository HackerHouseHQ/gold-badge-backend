@extends('admin_dash.main')
@section('content')
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Add country</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>

              <li class="breadcrumb-item active" aria-current="page">Add country</li>
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

                        <div class="panel-heading">Enter New Country</div>
                        <div class="panel-body">
                          <h4> {{session('flash')}}</h4>
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
                                <input type="text" class="form-control" name="country_name"
                                  value="{{ old('counry_name') }}" required>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                  Save
                                </button>
                                <button type="button" class="btn btn btn-info"><a style="color : white;"
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
@endsection