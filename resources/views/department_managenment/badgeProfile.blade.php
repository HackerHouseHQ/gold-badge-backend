@extends('admin_dash.main')
@section('content')
<style>
  p.number_ratings_grey {
    color: grey;
  }

  .number_star {
    display: flex;
  }

  .fas.fa-star.custom_star_iconn {
    color: orangered;
  }

  span.star_icon1 {
    margin-top: 7px;
  }

  /* .number_star.new_div {
    display: flex;
    justify-content: space-evenly;
    width: 56px;
  } */


  .row_one {
    margin-bottom: 5px;
  }

  p.number_ratings_black_new {
    font-size: 12px;
    line-height: 0;
    width: 25%;
  }

  .vertical_baar {
    margin: 0 5px;
    margin-top: -3px;
    color: grey;
    line-height: 0;
  }

  .main_div_five_rows {
    line-height: 3px;
    width: 100%;
    margin-bottom: -17px;
  }

  .wrapper_ratings_review {
    border: 1px solid #eee;
    padding: 16px 16px;
  }

  .main_div_five_rows {
    line-height: 3px;
  }

  span.star_icon {
    margin-top: -7px;
  }

  .fas.fa-star.custom_star_iconn {
    color: orangered;
    /* width: 10px; */
    font-size: 10px;
    margin-top: -6px;
  }

  /* #data1_paginate {
    display: none;
  } */

  .progress-bar-cus {
    height: 10px;
    line-height: 3px;
  }

  .avatar1 {
    vertical-align: middle;
    width: 75px;
    height: 75px;
    border-radius: 50%;
    margin-bottom: 10px;
  }

  .sorting_asc:before {
    content: '';
    display: none;
  }

  .sorting_asc:after {
    content: '';
    display: none;
  }

  .rating_icon {
    width: 11px;
    margin: 0 5px;
  }
</style>
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Department</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="{{route('badge')}}">Badge</a></li>
              <li class="breadcrumb-item active" aria-current="page">Badge Detail</li>
            </ol>
          </nav>
        </div>
        <!--                <div class="col-lg-6 col-5 text-right">
                    <a class="btn btn-sm btn-neutral" href="{{ route('UserDetail',['id' => $data->id])}}"> Reviews</a>
                    <a class="btn btn-sm btn-neutral" href="{{ route('UserDetailFollowing',['id' => $data->id])}}">
                        Followings</a>
                    <a class="btn btn-sm btn-neutral" href="{{ route('UserDetailFollowing',['id' => $data->id])}}">
                        Department</a>
                    <a class="btn btn-sm btn-neutral" href="{{ route('UserDetailFollowingBadge',['id' => $data->id])}}">
                        Badge</a>
                </div>-->
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
            <div class="row">
              <div class="col-md-4">
                <div class="card card-primary card-outline">
                  <div class="card-body box-profile">
                    <div class="text-center">
                      @if(!empty($data->department_data->image))
                      <img src="{{'../storage/departname/' .$data->department_data->image}}" alt="Avatar"
                        class="avatar1">
                      @else
                      <img src="{{url('admin_css/images/follow_logo.png')}}" alt="Avatar" class="avatar1">

                      @endif

                    </div>

                    <input type="hidden" name="" id="badge_id" value="{{$data->id}}">

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
                        Department Rating <a class="float-right">
                          {{($departmentRating) ? number_format($departmentRating ,1) : 0}}
                        </a>

                      </li>
                      <li class="list-group-item">
                        Badge Rating <a class="float-right"> {{($badgeRating) ? number_format($badgeRating ,1) : 0}}
                        </a>
                      </li>
                      <li class="list-group-item">
                        No. of followers <a class="float-right">{{$noOfFollowers}}</a>
                      </li>
                      <li class="list-group-item">
                        Registered On <a class="float-right">{{date("Y-m-d", strtotime($data->created_at))}}</a>
                      </li>
                      <li class="list-group-item">
                        Total Reviews <a class="float-right">{{$totalPost}}</a>
                      </li>
                    </ul>

                    {{-- <a href="#" class=""><b>View Badge List</b></a> --}}
                    {{-- <div class="text-center">
                      <a href='javascript:void(0)' onclick='viewDepartmentBadgeModel1({{$data->id}})'><span
                      class='tbl_row_new1 view_modd_dec'><b>View Badge List</b></span>
                    </a>
                  </div> --}}

                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card">
                <div class="card-body">

                  <form action="" id="search_data" class="search_data_row_class">
                    <div class='row'>
                      <div class='col-12'>
                        <div class="form-group">
                          <input class="form-control form-control-sm" type="text" placeholder="Search By User Name">

                        </div>
                      </div>
                      <div class='col-5'>
                        <div class="form-group">
                          <select class="form-control" name="status_id" id="status_id">
                            <option value="">status</option>
                            <option value="1">Active</option>
                            <option value="2">Inactive</option>
                          </select>
                        </div>
                      </div>
                      <div class='col-6'>
                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                            </div>
                            <input class="form-control datepicker" placeholder="Select from date" type="text" value=""
                              name="fromdate" id="fromdate">
                          </div>
                        </div>
                      </div>
                      <div class='col-6'>
                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                            </div>
                            <input class="form-control datepicker" placeholder="Select to date" type="text" value=""
                              name="todate" id="todate">
                          </div>
                        </div>
                      </div>
                      <input type="hidden" placeholder="Look for user" name="search2" id="search2" class="search_input">
                      <div class='col-2'>
                        <div class="d-flex">
                          <button type="button" id="search_data1" class="btn btn-primary apply_btnn">Apply</button>
                          <button type="button" value="Reset form" onclick="myFunction()"
                            class="btn btn-info apply_btnn">Reset</button>
                        </div>

                      </div>
                    </div>

                    <!--                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <span class="div_cover_sell">
                                                            <span>
                                                                <select class="" name="status_id" id="status_id">
                                                                    <option value="">Status</option>
                                                                    <option value="1">Active</option>
                                                                    <option value="2">Inactive</option>
                                                                </select>
                                                            </span>
                                                        </span>

                                                        <span class="from_to_select">
                                                            <label for="from_text" class="serach_by_text">From</label>

                                                            <input type="date" class="from_control" name="fromdate"
                                                                id="fromdate" style="-webkit-appearance: media-slider;">
                                                            <label for="to_text" class="serach_by_text">To</label>
                                                            <input type="date" class="from_control" name="todate"
                                                                id="todate" style="-webkit-appearance: media-slider;">
                                                        </span>
                                                        <input type="hidden" placeholder="Look for user" name="search2"
                                                            id="search2" class="search_input">
                                                        <button type="button" id="search_data1"
                                                            class="apply_btnn">Apply</button>


                                                    </tr>
                                                </thead>
                                            </table>-->
                  </form>
                  <div class="wrapper_ratings_review">
                    <div class="row">
                      <div class="col-md-2">
                        <div class="number_star" style="margin-top:17px;">
                          <p class="number_ratings_black"> {{($badgeRating) ? number_format($badgeRating ,1) : 0}}
                          </p>

                          <span class="star_icon1">
                            @if ($badgeRating >= 1 && $badgeRating <2)<img
                              src="{{asset('admin_new/assets/img/pinkbadge_icon.png')}}" alt="" class="rating_icon">
                              @endif
                              @if ( $badgeRating
                              >=2&& $badgeRating <3)<img <img
                                src="{{asset('admin_new/assets/img/purplebadge_icon.png')}}" alt="" class="rating_icon">
                                @endif
                                @if ($badgeRating >=3 && $badgeRating <4) <img
                                  src="{{asset('admin_new/assets/img/bronzebadge_icon.png')}}" alt=""
                                  class="rating_icon">
                                  @endif
                                  @if ($badgeRating
                                  >=4 && $badgeRating <5) <img
                                    src="{{asset('admin_new/assets/img/silverbadge_icon.png')}}" alt=""
                                    class="rating_icon">
                                    @endif
                                    @if ( $badgeRating==5 ) <img
                                      src="{{asset('admin_new/assets/img/goldbadge_icon.png')}}" alt=""
                                      class="rating_icon">

                                    @endif
                          </span>
                          {{-- <span class="star_icon">
                            <i class="fas fa-star custom_star_iconn" style="margin:3px;"></i>
                            <!--                       <i class="fa fa-star custom_star_iconn" aria-hidden="true"></i>-->
                          </span> --}}
                        </div>
                        <p class="number_ratings_grey" style="margin-top:-20px;">{{$totalPost}}</p>
                      </div>
                      <div class="col-md-10">
                        <div class="main_div_five_rows">
                          <div class="row_one">
                            <div class="number_star new_div">

                              <p class="number_ratings_black_new">Honesty</p>

                              <span class="star_icon">
                                <img src="{{asset('admin_new/assets/img/goldbadge_icon.png')}}" alt=""
                                  class="rating_icon">
                              </span>
                              <span class="vertical_baar">|</span>
                              <p class="number_ratings_black_new">{{$fiveRating}}</p>
                            </div>
                          </div>
                          <div class="row_one">
                            <div class="number_star new_div">
                              <p class="number_ratings_black_new">Communication</p>

                              <span class="star_icon">
                                <img src="{{asset('admin_new/assets/img/silverbadge_icon.png')}}" alt=""
                                  class="rating_icon">
                              </span>
                              <span class="vertical_baar">|</span>
                              <p class="number_ratings_black_new">{{$fourRating}}</p>
                            </div>
                          </div>
                          <div class="row_one">
                            <div class="number_star new_div">
                              <p class="number_ratings_black_new">Respect</p>

                              <span class="star_icon">
                                <img src="{{asset('admin_new/assets/img/bronzebadge_icon.png')}}" alt=""
                                  class="rating_icon">
                              </span>
                              <span class="vertical_baar">|</span>
                              <p class="number_ratings_black_new">{{$threeRating}}</p>
                            </div>
                          </div>
                          <div class="row_one">
                            <div class="number_star new_div">
                              <p class="number_ratings_black_new">Better</p>

                              <span class="star_icon">
                                <img src="{{asset('admin_new/assets/img/purplebadge_icon.png')}}" alt=""
                                  class="rating_icon">
                              </span>
                              <span class="vertical_baar">|</span>
                              <p class="number_ratings_black_new">{{$twoRating}}</p>
                            </div>
                          </div>
                          <div class="row_one">
                            <div class="number_star new_div">
                              <p class="number_ratings_black_new">Good</p>

                              <span class="star_icon">
                                <img src="{{asset('admin_new/assets/img/pinkbadge_icon.png')}}" alt=""
                                  class="rating_icon">
                              </span>
                              <span class="vertical_baar">|</span>
                              <p class="number_ratings_black_new">{{$oneRating}}</p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">


                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-content">
                <div class="active tab-pane" id="activity">
                  <div class="post">
                    <div class="row">
                      <div class="col-12">
                        <div class="card class_scroll ">
                          <div class="card-body p-0">
                            <table id="data1" class="table table-hover">
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
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
  var dataTable = $('#data1').DataTable({
    language: {
      searchPlaceholder: "Department Name",
      paginate: {
          previous: '<i class="fas fa-angle-left"></i>',
          next:     '<i class="fas fa-angle-right"></i>'
      },
      aria: {
          paginate: {
              previous: 'Previous',
              next:     'Next'
          }
      }
  },
  "pageLength": 5,
     "searching": false,
     'processing': true,
     'serverSide': true,
     "bFilter": true,
     "bInfo": false,
     "lengthChange": false,
     "bAutoWidth": false,
     'ajax': {
        'url':"{{route('department_profile_list')}}",
       'data': function(data){
        var badge_id = $('#badge_id').val();
         data.badge_id = badge_id;
//            var status_id = $('#status_id').val();
//          data.status_id = status_id;
//          var state_id = $('#state_id').val();
//          data.state_id = state_id;
//          var country_id = $('#country_id').val();
//          data.country_id = country_id;
//           var fromdate = $('#fromdate').val();
//          data.fromdate = fromdate;
//          var todate = $('#todate').val();
//          data.todate = todate;
//          var search = $('#search').val();
//          data.search = search;
          
        }
       },
    'columns': [
        { data: 'rating' } ,
        { data: 'reviews' }
    ],
     "columnDefs": [
    { "width": "10%", "targets": 0 }
  ]
  });
//  $('#search_data1').click(function(){
//     dataTable.draw();
//  });
//  $('#search').keyup(function(){
//     dataTable.draw();
//  });
});
</script>
<script>
  function myFunction() {
document.getElementById("search_data").reset();
location.reload();

}
</script>
@endsection