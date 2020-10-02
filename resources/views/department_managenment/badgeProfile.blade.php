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

  .leftpane {
    width: 20%;
    height: 100%;
    float: left;
    border-collapse: collapse;
  }

  .modal-content {
    padding: 20px;
  }

  .font1 {
    font-size: 15px;
    color: #000;
    font-weight: 600;
  }

  .font2 {
    color: #000;
    font-size: 10px;
  }

  .font3 {
    font-size: 14px;
    color: #000;
  }

  .form_div {
    display: flex;
    justify-content: space-between;
  }

  .modal-header {
    padding: 0;
  }

  .sub_comment_div {
    margin-bottom: 20px;
    /* position: absolute; */
    margin-left: 56px;
  }

  .comment_div {
    margin-bottom: 20px;
  }

  .comment_partion_div1 {
    display: flex;
    flex-direction: column;
    padding-left: 70px;
    margin-top: -10px
  }



  p.form_fields {
    margin: 0;
    padding-left: 4px;
    color: #000;
    font-size: 15px;
    font-weight: 400;
    overflow-wrap: break-word;
    width: 50%;
    text-align: left;
  }

  .custom_col_class {
    width: 85%;
    text-align: center;
    margin: 0 auto;
  }

  .middlepane {
    width: 40%;
    height: 100%;
    float: left;
    border-collapse: collapse;
  }

  .rightpane {
    width: 40%;
    height: 100%;
    position: relative;
    float: right;
    border-collapse: collapse;
  }

  .img-r {
    /*height: 200px; */
    /*width: 200px; */
    /*margin:0 auto;*/
    height: 118px;
    width: 119px;
    margin-top: 0px;
    margin-bottom: 38px;
    margin-left: -14px;
    border-radius: 100px;
    overflow: hidden;
    border: 7px solid #f6f6f6;
  }

  .modal_rating_icon {
    width: 10px;
    margin-top: -2px;
    margin-left: 2px;
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
              <div class="col-xl-12 col-md-6">
                <div class="card bg-gradient-info border-0">
                  <!-- Card body -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col">

                        <?php $post = App\Post::with('users')->where(
                          'department_id',
                          $data->id
                        )->where('flag', 2)->count(); ?>

                        <h5 class="card-title text-uppercase text-muted mb-0 text-white">
                          Users Reviews({{$post}})</h5> {{-- <span class="h2 font-weight-bold mb-0 text-white">123/267</span>
                                <div class="progress progress-xs mt-3 mb-0">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                        style="width: 50%;"></div>
                                </div> --}} </div>
                      <div class="col-auto">
                        {{-- <button type="button" class="btn btn-sm btn-neutral mr-0"
                                    data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" style="">


                                </div> --}}
                        <div class="form-group" style="margin-bottom: 0;">
                          <select class="form-control" name="rating" id="rating">
                            <option value="">Rating</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="">All</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    {{-- <p class="mt-3 mb-0 text-sm">
                            <a href="#!" class="text-nowrap text-white font-weight-600">See
                                details</a>
                        </p> --}}
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
<div class="modal fade" id="viewUserDetailModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="padding: 0;">
        <h4 class="modal-title text-capitalize" id="businessName">Post Detail </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-4" id="userImage">
            <img
              src="https://png.pngtree.com/png-clipart/20190924/original/pngtree-user-vector-avatar-png-image_4830521.jpg"
              alt="" style="width: 240px; height:240px;">
          </div>
          <div class="col-8" id="viewDepartment">

          </div>
        </div>
        {{-- <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <div>
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th><span class="tbl_row">SN.</span></th>
                      <th> <span class="tbl_row">Department Name</span> </th>
                      <th> <span class="tbl_row">State</span> </th>
                      <th> <span class="tbl_row">City</span> </th>
                      <th> <span class="tbl_row">Avg Rating</span> </th>
                      <th> <span class="tbl_row">Reviews</span> </th>
                      <th> <span class="tbl_row">No. of badges</span> </th>
                    </tr>
                  </thead>
                  <tbody id="viewDepartment">

                  </tbody>

                </table>



              </div>
            </div>
          </div>
        </div> --}}
      </div>
    </div>
  </div>
</div>
{{-- end model view department --}}
{{-- model view department --}}
<div class="modal fade" id="viewUserDetailLikeModel" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="padding: 0;">
        <h4 class="modal-title text-capitalize" id="businessName1"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-6" id="userImage1">
            <img
              src="https://png.pngtree.com/png-clipart/20190924/original/pngtree-user-vector-avatar-png-image_4830521.jpg"
              alt="" style="width: 300px; height:300px;">
          </div>
          <div class="col-6" id="viewDepartmentLike">


          </div>
        </div>
        {{-- <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <div>
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th><span class="tbl_row">SN.</span></th>
                      <th> <span class="tbl_row">Department Name</span> </th>
                      <th> <span class="tbl_row">State</span> </th>
                      <th> <span class="tbl_row">City</span> </th>
                      <th> <span class="tbl_row">Avg Rating</span> </th>
                      <th> <span class="tbl_row">Reviews</span> </th>
                      <th> <span class="tbl_row">No. of badges</span> </th>
                    </tr>
                  </thead>
                  <tbody id="viewDepartment">

                  </tbody>

                </table>



              </div>
            </div>
          </div>
        </div> --}}
      </div>
    </div>
  </div>
</div>
{{-- end model view department --}}
<div class="modal fade" id="viewUserDetailShareModel" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="padding: 0;">
        <h4 class="modal-title text-capitalize" id="share"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="share">
        <div class="row">
          <div class="col-6" id="userImage2">
            <img
              src="https://png.pngtree.com/png-clipart/20190924/original/pngtree-user-vector-avatar-png-image_4830521.jpg"
              alt="" style="width: 300px; height:300px;">
          </div>
          <div class="col-6" id="viewDepartmentShare">


          </div>
        </div>
        {{-- <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <div>
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th><span class="tbl_row">SN.</span></th>
                      <th> <span class="tbl_row">Department Name</span> </th>
                      <th> <span class="tbl_row">State</span> </th>
                      <th> <span class="tbl_row">City</span> </th>
                      <th> <span class="tbl_row">Avg Rating</span> </th>
                      <th> <span class="tbl_row">Reviews</span> </th>
                      <th> <span class="tbl_row">No. of badges</span> </th>
                    </tr>
                  </thead>
                  <tbody id="viewDepartment">

                  </tbody>

                </table>



              </div>
            </div>
          </div>
        </div> --}}
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="viewUserDetailCommentModel" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="padding: 0;">
        <h4 class="modal-title text-capitalize" id="comment"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="">
        <div class="row">
          {{-- <div class="col-6" id="userImage2">

          </div> --}}
          <div class="col-12" id="viewDepartmentComment">


          </div>
        </div>
        {{-- <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <div>
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th><span class="tbl_row">SN.</span></th>
                      <th> <span class="tbl_row">Department Name</span> </th>
                      <th> <span class="tbl_row">State</span> </th>
                      <th> <span class="tbl_row">City</span> </th>
                      <th> <span class="tbl_row">Avg Rating</span> </th>
                      <th> <span class="tbl_row">Reviews</span> </th>
                      <th> <span class="tbl_row">No. of badges</span> </th>
                    </tr>
                  </thead>
                  <tbody id="viewDepartment">

                  </tbody>

                </table>



              </div>
            </div>
          </div>
        </div> --}}
      </div>
    </div>
  </div>
</div>

{{-- model view city --}}
<div class="modal fade" id="viewUserDetailBadgeRating" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header custom_modal_header">
        <h4 class="modal-title text-capitalize" id="reason">Review Reason List</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12" id="reason_list">
            {{-- <div class="table-responsive">
                <div>
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><span class="tbl_row">SN.</span></th>
                        <th> <span class="tbl_row">City Name</span> </th>
                      </tr>
                    </thead>
                    <tbody id="businessDetails">
  
                    </tbody>
                  </table>
                </div>
              </div> --}}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="viewUserDetailVoteRating" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header custom_modal_header">
        <h4 class="modal-title text-capitalize" id="reason">Post Vote List</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12" id="vote_list">
            {{-- <div class="table-responsive">
                <div>
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th><span class="tbl_row">SN.</span></th>
                        <th> <span class="tbl_row">City Name</span> </th>
                      </tr>
                    </thead>
                    <tbody id="businessDetails">
  
                    </tbody>
                  </table>
                </div>
              </div> --}}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function() {
    var dataTable = $('#data1').DataTable({
      language: {
        searchPlaceholder: "Department Name",
        paginate: {
          previous: '<i class="fas fa-angle-left"></i>',
          next: '<i class="fas fa-angle-right"></i>'
        },
        aria: {
          paginate: {
            previous: 'Previous',
            next: 'Next'
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
        'url': "{{route('department_profile_list')}}",
        'data': function(data) {
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
          var rating = $('#rating').val();
          data.rating = rating;

        }
      },
      'columns': [{
          data: 'rating'
        },
        {
          data: 'reviews'
        }
      ],
      "columnDefs": [{
        "width": "10%",
        "targets": 0
      }]
    });
    //  $('#search_data1').click(function(){
    //     dataTable.draw();
    //  });
    //  $('#search').keyup(function(){
    //     dataTable.draw();
    //  });
    $('#rating').on('change', function() {
      //alert( this.value );
      dataTable.draw();
    });
  });
</script>
<script>
  function myFunction() {
    document.getElementById("search_data").reset();
    location.reload();

  }
</script>
<script>
  var ratingImage = {
        ratings: function (rating) {
            var ratingIcon = "";
            if (rating >= 1 && rating < 2) {
                ratingIcon =
                    `<img src="{{asset('admin_new/assets/img/pinkbadge_icon.png')}}" alt="" class="modal_rating_icon">`
            }
            if (rating >= 2 && rating < 3) {
                ratingIcon =
                    `<img src="{{asset('admin_new/assets/img/purplebadge_icon.png')}}" alt="" class="modal_rating_icon">`;
            }


            if (rating >= 3 && rating < 4) {
                ratingIcon =
                    `<img src="{{asset('admin_new/assets/img/bronzebadge_icon.png')}}" alt="" class="modal_rating_icon">`;
            }
            if (rating >=
                4 && rating < 5) {
                ratingIcon =
                    `<img src="{{asset('admin_new/assets/img/silverbadge_icon.png')}}" alt="" class="modal_rating_icon">`;
            }
            if (rating == 5) {
                ratingIcon =
                    `<img src="{{asset('admin_new/assets/img/goldbadge_icon.png')}}" alt="" class="modal_rating_icon">`;
            }
            return ratingIcon;
        }
    }

    function viewUserDetailVoteRating(id) {
        $.ajax({
            url: "{{ route('viewUserDetailVoteRating') }}/" + id,
            type: 'get',
            success: function (response) {
                if (response.length) {
                    console.log('aaa--', response);
                    $('#vote_list').html('');
                    // $('#noData').css("display","block"); 
                    var i = 0;
                    let row = `<div class="table-responsive">
                                    <div>
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th><span class="tbl_row">SN.</span></th>
                                                    <th> <span class="tbl_row">Department</span> </th>
                                                    <th> <span class="tbl_row">Badge Number</span> </th>
                                                    <th> <span class="tbl_row">User Name</span> </th>
                                                    <th> <span class="tbl_row">Rating</span> </th>
                                                </tr>
                                            </thead>
                                        <tbody id="businessDetails">`;
                    $.each(response, function (key, value) {
                        row += `<tr>
                                    <td> ${++i} </td>
                                    <td class="text-capitalize">${value.department_name}</td>
                                    <td class="text-capitalize">${value.badge_number}</td>
                                    <td class="text-capitalize">${value.user_name}</td>
                                    <td class="text-capitalize">${value.rating} <span>${ratingImage.ratings(value.rating)}</span></td>
                                </tr>`;
                    })
                    row += `</tbody>
                            </table>
                        </div>
                    </div>`;
                    $('#vote_list').append(row)
                } else {
                    $('#vote_list').html('');
                    let row = `<div class="table-responsive">
                                <div>
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th><span class="tbl_row">SN.</span></th>
                                                <th> <span class="tbl_row">Department</span> </th>
                                                <th> <span class="tbl_row">Badge Number</span> </th>
                                                <th> <span class="tbl_row">User Name</span> </th>
                                                <th> <span class="tbl_row">Rating</span> </th>
                                            </tr>
                                        </thead>
                                        <tbody id="businessDetails">
                                            <tr>
                                              <td colspan="7"> Record not found! </td>
                                            </tr>`;
                    $('#vote_list').append(row)
                }
                $('#viewUserDetailVoteRating').modal('show');
            },
            error: function (err) {
                console.log(err);
            }
        });

    }

    function viewUserDetailBadgeRating(id) {

        $.ajax({
            url: "{{ route('viewUserDetailBadgeRating') }}/" + id,
            type: 'get',
            success: function (response) {
                if (response.length) {
                    console.log('aaa--', response);
                    $('#reason_list').html('');
                    // $('#noData').css("display","block"); 
                    var i = 0;
                    let row = `<div class="table-responsive">
              <div>
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th><span class="tbl_row">SN.</span></th>
                      <th> <span class="tbl_row">Reason Question</span> </th>
                      <th> <span class="tbl_row">Rating</span> </th>
                      <th> <span class="tbl_row">Badge Number</span> </th>
                    </tr>
                  </thead>
                  <tbody id="businessDetails">`;
                    $.each(response, function (key, value) {
                        row += `
                <tr>
                  <td> ${++i} </td>
                  <td class="text-capitalize">${value.name}</td>
                  <td class="text-capitalize">${value.rating}<span>${ratingImage.ratings(value.rating)}</span></td>
                  <td class="text-capitalize">${value.badge_number}</td>
                 </tr>
                `;

                    })
                    row += `    </tbody>
                </table>
              </div>
            </div>`;
                    $('#reason_list').append(row)
                } else {
                    $('#reason_list').html('');
                    let row = `<div class="table-responsive">
              <div>
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th><span class="tbl_row">SN.</span></th>
                      <th> <span class="tbl_row">Reason Question</span> </th>
                      <th> <span class="tbl_row">Rating</span> </th>
                      <th> <span class="tbl_row">Badge Number</span> </th>
                    </tr>
                  </thead>
                  <tbody id="businessDetails">
            <tr>
              <td colspan="7"> Record not found! </td>
            </tr>
            `;
                    $('#reason_list').append(row)
                    // $('#noData').css("display","none");
                }
                $('#viewUserDetailBadgeRating').modal('show');
            },
            error: function (err) {
                console.log(err);
            }
        });

    }

    function viewUserDetailCommentModel(id) {
        $.ajax({
            url: "{{ route('viewUserDetailCommentModel') }}/" + id,
            type: 'get',
            success: function (response) {
                $('#userImage2').html(``);
                $('#comment').html(``);
                if (response.length == 0) {
                    $('#userImage2').html(``);
                    $('#comment').html(``);

                    $('#comment').html('<h4>no record found</h4>');
                }

                let row = ``;
                $('#viewDepartmentComment').html('');
                response.forEach(value => {
                    row += `<div class="col">
                        <div class="comment_div">
                          <div class="comment_partion_div">
                            <span><img src="../storage/uploads/user_image/${value.image}" alt="user_image" class="avatar" style=" vertical-align: middle; width: 40px; height: 40px; border-radius: 50%; margin-right: 15px;"></span>
                            <span class="font1">${value.user_name}</span>
                            <span class="font2">${value.date}</span>
                          </div>
                          <div class="comment_partion_div1">
                            <span class="font1">${value.comment}</span> 
                            <p style="margin:0;"><span class="font3">${value.comment_like_count}</span> <span class="font3" style="padding-left: 3px;">Likes</span> <span class="font3">${value.reply_count}</span><span class="font3" style="padding-left: 3px;">Reply</span><a href='javascript:void(0)' style=" font-size: 13px;
                                padding-left: 5px;
                                font-weight: 500;" onclick ='viewSubcomment(${value.comment_id})'>view more</a></p>
                          </div>
                        </div>
                    </div>`;

                    row +=
                        `<div class="col" style="display:none;" id="view_sub_comment${value.comment_id}">`;
                    value.sub_comment.forEach(v => {
                        row += `
                <div class="sub_comment_div">
                  <div class="comment_partion_div">
                    <span><img src="${v.user_image}" alt="user_image" class="avatar" style=" vertical-align: middle; width: 40px; height: 40px; border-radius: 50%; margin-right: 15px;"></span>
                    <span class="font1">${v.user_name}</span>
                    <span class ="font2">${v.date}</span>
                </div>
                <div class="comment_partion_div1">
                    <span class= "font1">${v.sub_comment}</span> 
       <p style ="margin:0;"><span class="font3" >${v.sub_comment_like_count}</span><span class="font3" style="padding-left: 3px;">Likes</span></p>  </div> 
         
      </div> `;


                    });
                    row += `</div>`;


                });

                $('#viewDepartmentComment').append(row);

                $('#viewUserDetailCommentModel').modal('show');

            },
            error: function (err) {
                console.log(err);
            }
        });
    }

    function viewUserDetailShareModel(id) {
        // $('#viewUserDetailLikeModel').modal('show');
        $.ajax({
            url: "{{ route('viewUserDetailShareModel') }}/" + id,
            type: 'get',
            success: function (response) {
                $('#share').html(``);
                $('#userImage2').html(``);
                if (response.length == 0) {
                    $('#userImage2').html(``);
                    $('#share').html(``);

                    $('#share').html('<h4>no record found</h4>');
                    $('#viewUserDetailShareModel').modal('show');
                    return false;
                }
                let image_length = 0;
                response.forEach(value => {
                    image_length = value.post_images.length
                });
                let rowImage = `<h4>Total Media${image_length}</h4><div id="carouselExampleControls2" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">`;
                let i = 1;
                response.forEach(value => {
                    value.post_images.forEach(image => {
                        if (i == 1) {
                        if (image.media_type == 0) {
                            rowImage += ` <div class="carousel-item active">
                                <video width="320" height="240" controls autoplay id="myVideo">
                                    <source src="../storage/uploads/post_department_image/${image.image}" type="video/mp4">
                                    <source src="../storage/uploads/post_department_image/${image.image}" type="video/ogg">
                                </video>
                                </div>`;

                        } else {
                            rowImage += ` <div class="carousel-item active">
                                        <img class="d-block w-100" src="../storage/uploads/post_department_image/${image.image}" id="myPostImg" style="width: 245px; height:245px;" alt="First slide">
                                </div>`;
                        }
                    } else {
                        if (image.media_type == 0) {
                            rowImage += ` <div class="carousel-item">
                                <video width="320" height="240" controls autoplay id="myVideo">
                                    <source src="../storage/uploads/post_department_image/${image.image}" type="video/mp4">
                                    <source src="../storage/uploads/post_department_image/${image.image}" type="video/ogg">
                                </video>
                                </div>`;
                        } else {
                            rowImage += ` <div class="carousel-item">
                                        <img class="d-block w-100" src="../storage/uploads/post_department_image/${image.image}"  id="myPostImg" style="width: 245px; height:245px;" alt="Second slide">
                                         </div>`;

                        }

                    }

                        i++;
                    });
                });
                rowImage += `</div>
  <a class="carousel-control-prev" href="#carouselExampleControls2" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls2" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>`;
                $('#userImage2').append(rowImage);
                $('#viewDepartmentShare').html('');

                response.forEach(value => {
                    let row = ` <div class="col">
        <span><img src="../storage/uploads/user_image/${value.image}" alt="user_image" class="avatar" style=" vertical-align: middle; width: 50px; height: 50px; border-radius: 50%; "></span>
        <span>${value.user_name}</span>
        <br>
            </div>`;
                    $('#viewDepartmentShare').append(row)
                });

                console.log(response);

                $('#viewUserDetailShareModel').modal('show');
            },
            error: function (err) {
                console.log(err);
            }
        });
    }

    function viewUserDetailLikeModel(id) {
        $('#viewUserDetailLikeModel').modal('show');
        $.ajax({
            url: "{{ route('viewUserDetailLikeModel') }}/" + id,
            type: 'get',
            success: function (response) {

                if (response.length == 0) {
                    $('#userImage1').html(``);
                    $('#viewDepartmentLike').html('');
                    $('#businessName1').html('no record found</>');
                    return false;
                }
                $('#userImage1').html(``);
                $('#businessName1').html('');
                let image_length = 0;
                response.forEach(value => {
                    image_length = value.post_images.length
                });
                let rowImage = `<h4>Total Media${image_length}</h4><div id="carouselExampleControls1" class="carousel slide" data-ride="carousel">
                                 <div class="carousel-inner">`;
                let i = 1;
                response.forEach(value => {
                    value.post_images.forEach(image => {
                        if (i == 1) {
                        if (image.media_type == 0) {
                            rowImage += ` <div class="carousel-item active">
                                <video width="320" height="240" controls autoplay id="myVideo">
                                    <source src="../storage/uploads/post_department_image/${image.image}" type="video/mp4">
                                    <source src="../storage/uploads/post_department_image/${image.image}" type="video/ogg">
                                </video>
                                </div>`;

                        } else {
                            rowImage += ` <div class="carousel-item active">
                                        <img class="d-block w-100" src="../storage/uploads/post_department_image/${image.image}" id="myPostImg" style="width: 245px; height:245px;" alt="First slide">
                                </div>`;
                        }
                    } else {
                        if (image.media_type == 0) {
                            rowImage += ` <div class="carousel-item">
                                <video width="320" height="240" controls autoplay id="myVideo">
                                    <source src="../storage/uploads/post_department_image/${image.image}" type="video/mp4">
                                    <source src="../storage/uploads/post_department_image/${image.image}" type="video/ogg">
                                </video>
                                </div>`;
                        } else {
                            rowImage += ` <div class="carousel-item">
                                        <img class="d-block w-100" src="../storage/uploads/post_department_image/${image.image}"  id="myPostImg" style="width: 245px; height:245px;" alt="Second slide">
                                         </div>`;

                        }

                    }
                        i++;
                    });
                });
                rowImage += `</div>
                            <a class="carousel-control-prev" href="#carouselExampleControls1" role="button" data-slide="prev">
                             <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                                    </a>
                             <a class="carousel-control-next" href="#carouselExampleControls1" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                            </a>
                            </div>`;

                $('#userImage1').append(rowImage);
                $('#viewDepartmentLike').html('');

                response.forEach(value => {
                    let row = ` <div class="col">
                                <span><img src="../storage/uploads/user_image/${value.image}" alt="user_image" class="avatar" style=" vertical-align: middle; width: 50px; height: 50px; border-radius: 50%;"></span>
                                    <span>${value.user_name}</span>
                                    <br>
                                     </div>`;
                    $('#viewDepartmentLike').append(row)
                });

                console.log(response);

                $('#viewUserDetailLikeModel').modal('show');
            },
            error: function (err) {
                console.log(err);
            }
        });
    }

    function viewUserDetailModel(id) {
        // alert(id);
        $.ajax({
            url: "{{ route('viewUserDetailModel') }}/" + id,
            type: 'get',
            success: function (response) {
                $('#userImage').html(``);

                let rowImage =
                    `<h4>Total media ${response.post_image.length}</h4><div id="carouselExampleControls" class="carousel slide" data-ride="carousel">`;

                rowImage += `<div class="carousel-inner">`;
                let i = 1;
                response.post_image.forEach(image => {
                    if (i == 1) {
                        if (image.media_type == 0) {
                            rowImage += ` <div class="carousel-item active">
                                <video width="320" height="240" controls autoplay id="myVideo">
                                    <source src="../storage/uploads/post_department_image/${image.image}" type="video/mp4">
                                    <source src="../storage/uploads/post_department_image/${image.image}" type="video/ogg">
                                </video>
                                </div>`;

                        } else {
                            rowImage += ` <div class="carousel-item active">
                                        <img class="d-block w-100" src="../storage/uploads/post_department_image/${image.image}" id="myPostImg" style="width: 245px; height:245px;" alt="First slide">
                                </div>`;
                        }
                    } else {
                        if (image.media_type == 0) {
                            rowImage += ` <div class="carousel-item">
                                <video width="320" height="240" controls autoplay id="myVideo">
                                    <source src="../storage/uploads/post_department_image/${image.image}" type="video/mp4">
                                    <source src="../storage/uploads/post_department_image/${image.image}" type="video/ogg">
                                </video>
                                </div>`;
                        } else {
                            rowImage += ` <div class="carousel-item">
      <img class="d-block w-100" src="../storage/uploads/post_department_image/${image.image}"  id="myPostImg" style="width: 245px; height:245px;" alt="Second slide">
    </div>`;

                        }

                    }


                    i++;
                });

                rowImage += `</div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>`;
                $('#userImage').append(rowImage);
                if (response.post_image.length == 0) {
                    $('#userImage').html(` <img
              src="https://png.pngtree.com/png-clipart/20190924/original/pngtree-user-vector-avatar-png-image_4830521.jpg"
              alt="" style="width: 245px; height:245px;">`);

                }
                //   if(typeof response.departments.image != "undefined"){ 

                //   $('#userImage').html(`<img
                //     src="../storage/departname/${response.departments.image}"
                //     alt="" style="width: 300px; height:300px;">`);
                // }else{
                //   $('#userImage').html(` <img
                //     src="https://png.pngtree.com/png-clipart/20190924/original/pngtree-user-vector-avatar-png-image_4830521.jpg"
                //     alt="" style="width: 300px; height:300px;">`);
                // }
                $('#viewDepartment').html('');
                // <a href='javascript:void(0)' onclick ='viewUserDetailCommentModel(${response.id})'>view list</a>
                let row = ` <div class="custom_col_class">
                                 <img src="../storage/uploads/user_image/${response.users.image}"  id="myImg" alt="user-image" class="avatar"  data-toggle="modal" data-target="img-modal" style=" vertical-align: middle; width: 66px; height: 66px; border-radius: 50%; margin-bottom:20px;   margin-left: -7rem;">
    
             <div class="form_div">
              <p class="form_fields">Full Name:</p>
              <p class="form_fields">${response.users.first_name}</p>
              </div>
              <div class="form_div">
              <p class="form_fields">Posted On:</p>
              <p class="form_fields">${response.created_at.substr(0,10).split('-').reverse().join('/')}</p>
              </div>
          
              <div class="form_div">
              <p class="form_fields">Likes:</p>
              <p class="form_fields" style="padding-right:5px;">${response.department_like}<a href='javascript:void(0)' style="padding-left:10px;" onclick ='viewUserDetailLikeModel(${response.id})'>view list</a></p>
              </div>
           
              <div class="form_div">
              <p class="form_fields">Share:</p>
              <p class="form_fields" style="padding-right:5px;">${response.department_share}<a href='javascript:void(0)'style="padding-left:10px;" onclick ='viewUserDetailShareModel(${response.id})'>view list</a></p>
              </div>
             
              <div class="form_div">
              <p class="form_fields">Comments:</p>
              <p class="form_fields" style="padding-right:5px;">${response.department_comment}<a href='javascript:void(0)'style="padding-left:10px;" onclick ='viewUserDetailCommentModel(${response.id})'>view list</a></p>
              </div>
            
              <div class="form_div">
              <p class="form_fields">Report:</p>
              <p class="form_fields">${response.department_report} </p>
              </div>
            
              <div class="form_div">
              <p class="form_fields">Rating:</p>
              <p class="form_fields">${response.rating} <a href='javascript:void(0)'style="padding-left:10px;" onclick ='viewUserDetailBadgeRating(${response.id})'>view list</a></p>
              </div>
              <div class="form_div">
              <p class="form_fields">Vote:</p>
              <p class="form_fields"><a href='javascript:void(0)'style="padding-left:0px;" onclick ='viewUserDetailVoteRating(${response.id})'>view list</a></p>
              </div>
            
              <div class="form_div">
              <p class="form_fields">Review:</p>
              <p class="form_fields">${(response.comment) ? response.comment : " " }</p>
              </div>
           
          </div>`;

                $('#viewDepartment').append(row)
                $('#viewUserDetailModel').modal('show');
            },
            error: function (err) {
                console.log(err);
            }
        });

    }
    function viewSubcomment(id) {
        $('#view_sub_comment' + id).toggle();
    }

</script>
@endsection