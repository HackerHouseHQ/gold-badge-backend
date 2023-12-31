@extends('admin_dash.main')
@section('content')
<style>
    #myPostImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myPostImg:hover {
        opacity: 0.7;
    }

    /* The Modal (background) */
    .post-img-modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 9999;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.9);
        /* Black w/ opacity */
    }

    /* Modal Content (Image) */
    .post-img-modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Caption of Modal Image (Image Text) - Same Width as the Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation - Zoom in the Modal */
    .post-img-modal-content,
    #caption {
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    /* The Close Button */
    .post-img-close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .post-img-close:hover,
    .post-img-close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px) {
        .post-img-modal-content {
            width: 100%;
        }
    }

    p.number_ratings_grey {
        color: grey;
    }

    .number_star {
        display: flex;
    }

    .fas.fa-star.custom_star_iconn {
        color: orangered;
    }

    /* .number_star.new_div {
      display: flex;
      justify-content: space-evenly;
      width: 56px;
    } */


    .row_one {
        margin-bottom: 8px;
    }

    p.number_ratings_black_new {
        font-size: 12px;
        line-height: 0;
        width: 25%;
    }

    .vertical_baar {
        margin: 0 10px;

        color: grey;
        line-height: 0;
    }

    .main_div_five_rows {
        line-height: 3px;
        width: 100%;
        margin-bottom: -17px;
        margin-top: 13px;
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

    span.star_icon1 {
        margin-top: 7px;
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

    .table td,
    .table th {
        font-size: .8125rem;
        white-space: normal;
    }

    /* table.dataTable tbody td {
        word-break: break-all;
        vertical-align: top;
    } */

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
                            <li class="breadcrumb-item"><a href="{{route('department')}}">Department</a></li>

                            <li class="breadcrumb-item active" aria-current="page">Department Detail</li>
                        </ol>
                    </nav>
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
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            @if(!empty($data->image))
                                            <img src="{{'../storage/departname/' .$data->image}}" alt="Avatar"
                                                class="avatar1">
                                            @else
                                            <img src="{{url('admin_css/images/follow_logo.png')}}" alt="Avatar"
                                                class="avatar1">

                                            @endif

                                        </div>
                                        <input type="hidden" name="department_id" id="department_id"
                                            value="{{$data->id}}">

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                Department <a class="float-right">{{@$data->department_name}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                Country <a
                                                    class="float-right">{{@$data->country_data->country_name}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                State <a class="float-right">{{@$data->state_data->state_name}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                City <a class="float-right">{{@$data->city_data->city_name}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                Avg. Rating <a class="float-right">
                                                    {{($avgRating) ? number_format($avgRating ,1) : 0}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                No. of badge <a class="float-right">{{$noOfbadge}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                Badge Rating <a
                                                    class="float-right">{{($badgeRating) ? number_format($badgeRating ,1) : 0}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                No. of followers <a class="float-right">{{$noOfFollowers}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                Registered On <a
                                                    class="float-right">{{date("Y-m-d", strtotime($data->created_at))}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                Total Reviews <a class="float-right">{{$totalRating}}</a>
                                            </li>
                                        </ul>

                                        {{-- <a href="#" class=""><b>View Badge List</b></a> --}}
                                        <div class="text-center">
                                            <a href="javascript:void(0)"
                                                onclick=" viewDepartmentBadgeModel1({{$data->id}})">
                                                <span class="tbl_row_new1 view_modd_dec"><b>View
                                                        Badge List</b></span></a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="card">
                                    <div class="card-body">

                                        <form action="" id="search_data" class="search_data_row_class">
                                            <div class='row'>
                                                <div class='col-sm-12'>
                                                    <div class="form-group">
                                                        <input class="form-control form-control-sm" type="text"
                                                            placeholder="Search By User Name">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <div class='col-sm-6'>
                                                    <div class="form-group">
                                                        <select class="form-control" name="status_id" id="status_id">
                                                            <option value="">status</option>
                                                            <option value="1">Active</option>
                                                            <option value="2">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='col-sm-6'>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                        class="ni ni-calendar-grid-58"></i></span>
                                                            </div>
                                                            <input class="form-control datepicker"
                                                                placeholder="Select from date" type="text" value=""
                                                                name="fromdate" id="fromdate">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <div class='col-sm-6'>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                        class="ni ni-calendar-grid-58"></i></span>
                                                            </div>
                                                            <input class="form-control datepicker"
                                                                placeholder="Select to date" type="text" value=""
                                                                name="todate" id="todate">
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" placeholder="Look for user" name="search2"
                                                    id="search2" class="search_input">
                                                <div class='col-2'>
                                                    <div class="d-flex">
                                                        <button type="button" id="search_data1"
                                                            class="btn btn-primary apply_btnn">Apply</button>
                                                        <button type="button" value="Reset form" onclick="myFunction()"
                                                            class="btn btn-info apply_btnn">Reset</button>
                                                    </div>


                                                </div>
                                            </div>
                                        </form>
                                        <div class="wrapper_ratings_review">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="number_star" style="margin-top:17px;">
                                                        <p class="number_ratings_black">
                                                            {{($avgRating) ? number_format($avgRating ,1) : ""}}</p>
                                                        <span class="star_icon1">
                                                            @if ($avgRating >= 1 && $avgRating <2)<img
                                                                src="{{asset('admin_new/assets/img/pinkbadge_icon.png')}}"
                                                                alt="" class="rating_icon">
                                                                @endif
                                                                @if ( $avgRating
                                                                >=2&& $avgRating <3)<img <img
                                                                    src="{{asset('admin_new/assets/img/purplebadge_icon.png')}}"
                                                                    alt="" class="rating_icon">
                                                                    @endif
                                                                    @if ($avgRating >=3 && $avgRating <4) <img
                                                                        src="{{asset('admin_new/assets/img/bronzebadge_icon.png')}}"
                                                                        alt="" class="rating_icon">
                                                                        @endif
                                                                        @if ($avgRating
                                                                        >=4 && $avgRating <5) <img
                                                                            src="{{asset('admin_new/assets/img/silverbadge_icon.png')}}"
                                                                            alt="" class="rating_icon">
                                                                            @endif
                                                                            @if ( $avgRating==5 ) <img
                                                                                src="{{asset('admin_new/assets/img/goldbadge_icon.png')}}"
                                                                                alt="" class="rating_icon">

                                                                            @endif
                                                        </span>

                                                    </div>
                                                    <p class="number_ratings_grey" style="margin-top:-20px;">
                                                        {{($totalRating) ? $totalRating : "" }}</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="main_div_five_rows">
                                                        <div class="row_one">
                                                            <div class="number_star new_div">
                                                                <p class="number_ratings_black_new">5</p>

                                                                <span class="star_icon">
                                                                    <img src="{{asset('admin_new/assets/img/goldbadge_icon.png')}}"
                                                                        alt="" class="rating_icon">
                                                                </span>
                                                                <span class="vertical_baar">|</span>
                                                                <p class="number_ratings_black_new">
                                                                    {{$fiveRating}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row_one">
                                                            <div class="number_star new_div">
                                                                <p class="number_ratings_black_new">4</p>

                                                                <span class="star_icon">
                                                                    <img src="{{asset('admin_new/assets/img/silverbadge_icon.png')}}"
                                                                        alt="" class="rating_icon">
                                                                </span>
                                                                <span class="vertical_baar">|</span>
                                                                <p class="number_ratings_black_new">
                                                                    {{$fourRating}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row_one">
                                                            <div class="number_star new_div">
                                                                <p class="number_ratings_black_new">3</p>

                                                                <span class="star_icon">
                                                                    <img src="{{asset('admin_new/assets/img/bronzebadge_icon.png')}}"
                                                                        alt="" class="rating_icon">
                                                                </span>
                                                                <span class="vertical_baar">|</span>
                                                                <p class="number_ratings_black_new">{{$threeRating}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row_one">
                                                            <div class="number_star new_div">
                                                                <p class="number_ratings_black_new">2</p>

                                                                <span class="star_icon">
                                                                    <img src="{{asset('admin_new/assets/img/purplebadge_icon.png')}}"
                                                                        alt="" class="rating_icon">
                                                                </span>
                                                                <span class="vertical_baar">|</span>
                                                                <p class="number_ratings_black_new">{{$twoRating}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row_one">
                                                            <div class="number_star new_div">
                                                                <p class="number_ratings_black_new">1</p>

                                                                <span class="star_icon">
                                                                    <img src="{{asset('admin_new/assets/img/pinkbadge_icon.png')}}"
                                                                        alt="" class="rating_icon">
                                                                </span>
                                                                <span class="vertical_baar">|</span>
                                                                <p class="number_ratings_black_new">{{$oneRating}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">


                                                    <div class="progress-group">
                                                        <div class="progress progress-sm progress-bar-cus">
                                                            <div class="progress-bar bg-primary"
                                                                style="width: {{($totalRating)? $fiveRating/$totalRating*100 : 0}}%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.progress-group -->

                                                    <div class="progress-group">
                                                        <div class="progress progress-sm progress-bar-cus">
                                                            <div class="progress-bar bg-danger"
                                                                style="width: {{($totalRating)? $fourRating/$totalRating*100 : 0}}%">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- /.progress-group -->
                                                    <div class="progress-group">
                                                        <div class="progress progress-sm progress-bar-cus">
                                                            <div class="progress-bar bg-success"
                                                                style="width: {{($totalRating)? $threeRating/$totalRating*100 : 0}}%">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- /.progress-group -->
                                                    <div class="progress-group">
                                                        <div class="progress progress-sm progress-bar-cus">
                                                            <div class="progress-bar bg-warning"
                                                                style="width: {{($totalRating)? $twoRating/$totalRating*100 : 0}}%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.progress-group -->
                                                    <div class="progress-group">
                                                        <div class="progress progress-bar-cus">
                                                            <div class="progress-bar bg-warning"
                                                                style="width: {{($totalRating) ? $oneRating/$totalRating*100 : 0}}%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.progress-group -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 ">
                                    <div class="card bg-gradient-info border-0">
                                        <!-- Card body -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">

                                                    <?php $post = App\Post::with('users')->where("department_id", $data->id)->where("flag", 1)->count(); ?>

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
    {{-- model view badge --}}
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-capitalize" id="businessName">Badge List</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div>
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th><span class="tbl_row">SN.</span></th>
                                                <th> <span class="tbl_row">Badge Number</span> </th>
                                                <th> <span class="tbl_row">Rating</span> </th>
                                                <th> <span class="tbl_row">Reviews</span> </th>
                                                <th> <span class="tbl_row">Action</span> </th>
                                            </tr>
                                        </thead>
                                        <tbody id="businessDetails">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end model view badge --}}
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
                        <img src="https://png.pngtree.com/png-clipart/20190924/original/pngtree-user-vector-avatar-png-image_4830521.jpg"
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
                        <img src="https://png.pngtree.com/png-clipart/20190924/original/pngtree-user-vector-avatar-png-image_4830521.jpg"
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
                        <img src="https://png.pngtree.com/png-clipart/20190924/original/pngtree-user-vector-avatar-png-image_4830521.jpg"
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
                <h4 class="modal-title text-capitalize" id="reason">Post Rate List</h4>
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
<div id="myPostModal" class="post-img-modal">

    <!-- The Close Button -->
    <span class="post-img-close">&times;</span>

    <!-- Modal Content (The Image) -->
    <img class="post-img-modal-content" id="imgPost01">

</div>

@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
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
            "bFilter": false,
            "bInfo": false,
            "lengthChange": false,
            "bAutoWidth": true,
            'ajax': {
                'url': "{{route('department_profile_list')}}",
                'data': function (data) {
                    var department_id = $('#department_id').val();
                    data.department_id = department_id;
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

        $('#rating').on('change', function () {
            //alert( this.value );
            dataTable.draw();
        });
        //  $('#search').keyup(function(){
        //     dataTable.draw();
        //  });
    });

</script>
<script type="text/javascript">
    function viewDepartmentBadgeModel1(id) {
        $.ajax({
            url: "{{ route('viewDepartmentBadgeModel') }}/" + id,
            type: 'get',
            success: function (response) {
                // console.log(response);
                if (response[0]) {
                    $('#businessDetails').html('');
                    var i = 0;
                    $.each(response, function (key, value) {

                        var url = '{{ route("BadgeDetail", ":id") }}';
                        url = url.replace(':id', 'id=' + value.id);

                        let row = `
                  <tr>
                    <td> ${++i} </td>
                    <td class="text-capitalize">${value.badge_number}</td>
                    <td class="text-capitalize">${value.rating}</td>
                    <td class="text-capitalize">${value.total_reviews}</td>
                    <td class="text-capitalize"><a href="${url}"><button type="button" class="btn btn-primary btn-sm">View Profile</button></a></td>
                   </tr>
                  `;
                        $('#businessDetails').append(row)
                    })
                } else {
                    let row = `
                  <tr>
                    <td colspan="7"> Record not found! </td>
                  </tr>
                  `;
                    $('#businessDetails').html(row);
                }
                $('#exampleModalCenter').modal('show');
            },
            error: function (err) {
                console.log(err);
            }
        });
    }

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
                    // console.log('aaa--', response);
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
                                <video width="320" height="240" controls  id="myVideo">
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
                                <video width="320" height="240" controls  id="myVideo">
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
                                <video width="320" height="240" controls  id="myVideo">
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
                                <video width="320" height="240" controls  id="myVideo">
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
                                <video width="320" height="240" controls  id="myVideo">
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
                                <video width="320" height="240" controls  id="myVideo">
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
              <p class="form_fields">Rate:</p>
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
    $(document).on('click', 'img', function () {
        var postmodal = document.getElementById("myPostModal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var imgPost = document.getElementById("myPostImg");
        console.log(imgPost);
        var modalPostImg = document.getElementById("imgPost01");
        // var captionText = document.getElementById("caption");

        postmodal.style.display = "block";
        modalPostImg.src = $(this).clone()[0].src;
        // captionText.innerHTML = this.alt;


        // Get the <span> element that closes the modal
        var spanPost = document.getElementsByClassName("post-img-close")[0];

        // When the user clicks on <span> (x), close the modal
        spanPost.onclick = function () {
            postmodal.style.display = "none";
        }
        // $('#modal .modal-body').html($(this).clone()[0]);
        //   $('#modal').modal('show');
    })

</script>
@endsection
