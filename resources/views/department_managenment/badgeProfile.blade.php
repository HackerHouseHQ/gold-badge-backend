@extends('admin_dash.main')
 @section('content')
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-md-4">
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{asset('storage/'.$data->department_data->image)}}"
                       alt="User profile picture">
                </div>

             
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    Badge Number <a class="float-right">{{$data->badge_number}}</a>
                  </li>
                   <li class="list-group-item">
                    Department <a class="float-right">{{$data->department_data->department_name}}</a>
                  </li>
                  <li class="list-group-item">
                    Country <a class="float-right">{{$data->department_data->country_data->country_name}}</a>
                  </li>
                  <li class="list-group-item">
                    State <a class="float-right">{{$data->department_data->state_data->state_name}}</a>
                  </li>
                   <li class="list-group-item">
                    City <a class="float-right">{{$data->department_data->city_data->city_name}}</a>
                  </li>
                  <li class="list-group-item">
                    Department Rating <a class="float-right">0</a>
                  </li>
                   <li class="list-group-item">
                    Badge Rating <a class="float-right">0</a>
                  </li>
                  <li class="list-group-item">
                    No. of followers <a class="float-right">0</a>
                  </li>
                  <li class="list-group-item">
                    Registered On <a class="float-right">{{date("Y-m-d", strtotime($data->created_at))}}</a>
                  </li>
                  <li class="list-group-item">
                    Total Reviews <a class="float-right">0</a>
                  </li>
                </ul>

              </div>
            </div>
          </div>
          <div class="col-md-8">
           <div class="card"> 
             <div class="card-body">
               <input class="form-control form-control-sm" type="text" placeholder="Search By User Name">

               <form action="" id="search_data" class="search_data_row_class">
                <table class="table table-striped">
                 <thead>
                  <tr>
                  <span class="div_cover_sell">
                    <span>
                  <select name="status_id" id="status_id" >
                    <option value = "">UserName</option>
                    <option value = "1">no user</option>
                    {{-- <option value = "2">Inactive</option> --}}
                  </select>
                </span>
                </span>
               
                 <span class="from_to_select">
                   <label for="from_text" class="serach_by_text">From</label>
                   
                   <input type="date" class="from_control" name="fromdate" id="fromdate" style="-webkit-appearance: media-slider;">
                    <label for="to_text" class="serach_by_text">To</label>
                    <input type="date" class="from_control" name="todate" id="todate" style="-webkit-appearance: media-slider;">
                  </span>
                  <input type="hidden" placeholder="Look for user" name="search2" id="search2" class="search_input">
                  <button type="button" id="search_data1" class="apply_btnn">Apply</button>

                  
                  </tr>
                 </thead>
                </table>
              </form>
             </div>
           </div>
            <div class="card">
             <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <div class="post">
                     {{--  <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image">
                        <span class="username">
                          <a href="#">Jonathan Burke Jr.</a>
                          <a href="#" class="float-right btn-tool"></a>
                        </span>
                        <span class="description">Shared publicly - 7:30 PM today</span>
                      </div>
                      <p>
                       No Post Available !
                      </p>
                      <p>
                        <a href="#" class="link-black text-sm mr-2">View Post</a>
                      </p> --}}

                       <p>
                       No Post Available !
                      </p>


                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>
@endsection
@section('script')  

@endsection
