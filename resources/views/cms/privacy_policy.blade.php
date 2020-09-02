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
              <li><a href="{{route('about_us')}}">About Us</a></li>
              <li class="active"><a href="{{route('privacy')}}">Privacy & Policy</a></li>
            <li><a href="{{route('terms')}}">Terms & Condition</a></li>
            </ul>
          </div>
         </div>
         {{-- close --}}
         <div class="row">
         <div class="col-md-12">
         <div class="card card-outline card-info">             
          <form  action="{{route('edit_privacy')}}" method="post">
            @csrf
            <div class="card-body pad">
              <div class="mb-3">
                <textarea name="privacy" class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$privacy->privacy}}</textarea>
              </div>            
            </div>
            <div class="about_us_savee">
              <button type="submit" class="btn btn-default save_intro_scrn about_us">SAVE</button>
            </div>
          </form>
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
