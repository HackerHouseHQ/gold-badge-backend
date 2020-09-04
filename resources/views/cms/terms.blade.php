@extends('admin_dash.main')
@section('content')
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Terms & Condition</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">Terms & Condition</li>
            </ol>
          </nav>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a class="btn btn-sm btn-neutral" href="{{route('about_us')}}">About Us</a>
          <a class="btn btn-sm btn-neutral" href="{{route('privacy')}}">Privacy & Policy</a>
          <a class="btn btn-sm btn-neutral" href="{{route('terms')}}">Terms & Condition</a>
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
        <div class="row">
          <div class="col-md-12">



            <!-- <div class="card-header"> <h3 class="card-title"> About Us  </h3>   </div> -->
            <!-- /.card-header -->
            <form action="{{route('edit_terms')}}" method="post">
              @csrf
              <div class="card-body pad">
                <div class="mb-3">
                  <textarea name="terms" class="textarea" placeholder="Place some text here"
                    style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$Terms->terms}}</textarea>
                </div>
              </div>
              <div class="about_us_savee">
                <button type="submit" class="btn btn-default save_intro_scrn about_us float-right">SAVE</button>
              </div>
            </form>


          </div>
          {{-- close --}}
        </div>


      </div>
    </div>
  </div>

</div>

@endsection
@section('script')
@endsection