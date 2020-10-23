@extends('admin_dash.main')
<style type="text/css">
    #myVideo {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myVideo:hover {
        opacity: 0.7;
    }

    /* The Modal (background) */
    .video-modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 3;
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
    .video-modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Caption of Modal Image (Image Text) - Same Width as the Image */
    /* #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    } */

    /* Add Animation - Zoom in the Modal */
    .video-modal-content,
    /* #caption {
        animation-name: zoom;
        animation-duration: 0.6s;
    } */

    @keyframes zoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    /* The Close Button */
    .video-close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .video-close:hover,
    .video-close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px) {
        .video-modal-content {
            width: 100%;
        }
    }

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
        z-index: 3;
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

    /* Style the Image Used to Trigger the Modal */
    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {
        opacity: 0.7;
    }

    /* The Modal (background) */
    .img-modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 3;
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
    .img-modal-content {
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
    .img-modal-content,
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
    .img-close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .img-close:hover,
    .img-close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px) {
        .img-modal-content {
            width: 100%;
        }
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


    .show {
        margin-left: 31px;
        margin-right: 92px;
    }

    .active2 {
        background: red;
    }

    #status_id {
        padding-right: 67px;
    }

    #country_id {
        padding-right: 67px;
    }

    #state_id {
        padding-right: 67px;
    }

    #city_id {
        padding-right: 67px;
    }

    #sideshow {
        /*background-color: aqua;*/
        margin-left: 637px;
    }

    .username_div {
        display: flex;
        width: 100%;
    }

    .message_div {
        text-align: right;
        margin: 0;
    }

    .message_div p {
        margin: 0;
    }

    /*}*/
</style>
@section('content')
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Reported Posts</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                            <!--<li class="breadcrumb-item"><a href="#">Tables</a></li>-->
                            <li class="breadcrumb-item active" aria-current="page">Post</li>
                        </ol>
                    </nav>
                </div>
                {{-- <div class="col-lg-6 col-5 text-right">
          <a href="#" class="btn btn-sm btn-neutral">New</a>
          <a href="#" class="btn btn-sm btn-neutral">Filters</a>
        </div> --}}
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
                        <form action="" id="search_data" class="search_data_row_class">
                            <div class='row'>
                                <div class='col-4'>
                                    <div class="form-group">
                                        <select class="form-control" name="status_id" id="status_id">
                                            <option value="">status</option>
                                            <option value="1">Active</option>
                                            <option value="2">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class='col-4'>
                                    <?php $departmentList = App\Department::get(); ?>
                                    <div class="form-group">
                                        <select class="form-control" name="department_id" id="department_id">
                                            <option value="">Department</option>
                                            @foreach($departmentList as $departmenntList)
                                            <option value="{{$departmenntList->id}}">
                                                {{$departmenntList->department_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class='col-4'>
                                    <?php $departmentBadgeList = App\DepartmentBadge::get(); ?>
                                    <div class="form-group">
                                        <select class="form-control" name="badge_id" id="badge_id">
                                            <option value="">Badge</option>
                                            @foreach($departmentBadgeList as $departmenntBadgeList)
                                            <option value="{{$departmenntBadgeList->id}}">
                                                {{$departmenntBadgeList->badge_number}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class='col-4'>
                                    <?php $countryList = App\Country::get(); ?>
                                    <div class="form-group">
                                        <select class="form-control" name="country_id" id="country_id">
                                            <option value="">Select Country</option>
                                            @foreach($countryList as $counntryList)
                                            <option value="{{$counntryList->id}}">{{$counntryList->country_name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class='col-4'>
                                    <div class="form-group">
                                        <select class="form-control" name="state_id" id="state_id">
                                            <option value="">Select State</option>
                                        </select>
                                    </div>
                                </div>
                                <div class='col-4'>
                                    <div class="form-group">
                                        <select class="form-control" name="city_id" id="city_id">
                                            <option value="">City</option>
                                        </select>
                                    </div>
                                </div>
                                <div class='col-5'>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="ni ni-calendar-grid-58"></i></span>
                                            </div>
                                            <input class="form-control datepicker" placeholder="Select date" type="text"
                                                value="" name="fromdate" id="fromdate">
                                        </div>
                                    </div>
                                </div>
                                <div class='col-5'>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="ni ni-calendar-grid-58"></i></span>
                                            </div>
                                            <input class="form-control datepicker" placeholder="Select date" type="text"
                                                value="" name="todate" id="todate">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" placeholder="Look for user" name="search2" id="search2"
                                    class="search_input">
                                <div class='col-2'>
                                    <div class="row">
                                        <button type="button" id="search_data1"
                                            class="btn btn-primary apply_btnn">Apply</button>
                                        <button type="button" value="Reset form" onclick="myFunction()"
                                            class="btn btn-info apply_btnn">Reset</button>
                                    </div>


                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                {{-- <div class="card-header">
          <form action="" id="search_data" class="search_data_row_class">
            <table class="table table-striped">
              <thead>
                <tr>
                  <span class="div_cover_sell">
                    <span>
                      <select name="status_id" id="status_id">
                        <option value="">Status</option>
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                      </select>
                    </span>
                  </span>
                  <span class="div_cover_sell">
                    <span>
                      <select name="department_id" id="department_id">
                        <option value="">Department</option>
                        <option value="1">Department1</option>
                        <option value="2">Department2</option>
                      </select>
                    </span>
                  </span>
                  <span class="div_cover_sell">
                    <span>
                      <select name="badge_id" id="badge_id">
                        <option value="">Badge</option>
                        <option value="1">Badge1</option>
                        <option value="2">Badge2</option>
                      </select>
                    </span>
                  </span>
                  <span class="div_cover_sell">
                    <span>
                      <?php $countryList =  App\Country::get(); ?>
                      <select name="country_id" id="country_id">
                        <option value="">Country</option>
                        @foreach($countryList as $counntryList)
                        <option value="{{$counntryList->id}}">{{$counntryList->country_name}}</option>
                @endforeach
                </select>
                </span>
                </span>
                <span class="div_cover_sell">
                    <span>
                        <select name="state_id" id="state_id">
                            <option value="">State</option>
                        </select>
                    </span>
                </span>
                <span class="div_cover_sell">
                    <span>
                        <select name="city_id" id="city_id">
                            <option value="">City</option>
                        </select>
                    </span>
                </span>
                <br> <br>
                <span class="from_to_select">
                    <label for="from_text" class="serach_by_text">From</label>

                    <input type="date" class="from_control" name="fromdate" id="fromdate"
                        style="-webkit-appearance: media-slider;">
                    <label for="to_text" class="serach_by_text">To</label>
                    <input type="date" class="from_control" name="todate" id="todate"
                        style="-webkit-appearance: media-slider;">
                </span>
                <input type="hidden" placeholder="Look for user" name="search2" id="search2" class="search_input">
                <button type="button" id="search_data1" class="apply_btnn">Apply</button>


                </tr>
                </thead>
                </table>
                </form>

            </div> --}}
            <div class="table-responsive py-4">
                <table class="table table-flush" id="datatable-basic">
                    <thead class="thead-light">
                        <tr>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Posted on </th>
                            <th>posted About</th>
                            <th>Rating</th>
                            <th>Report</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
{{-- <footer class="footer pt-0">
    <div class="row align-items-center justify-content-lg-between">
      <div class="col-lg-6">
        <div class="copyright text-center  text-lg-left  text-muted">
          &copy; 2020 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">Creative
            Tim</a>
        </div>
      </div>
      <div class="col-lg-6">
        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
          <li class="nav-item">
            <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
          </li>
          <li class="nav-item">
            <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
          </li>
          <li class="nav-item">
            <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
          </li>
          <li class="nav-item">
            <a href="https://www.creative-tim.com/license" class="nav-link" target="_blank">License</a>
          </li>
        </ul>
      </div>
    </div>
  </footer> --}}
</div>
{{-- model view department --}}
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
<div class="modal fade" id="viewUserDetailReportModel" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 0;">
                <h4 class="modal-title text-capitalize" id="businessName2"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6" id="userImage2">
                        <img src="https://png.pngtree.com/png-clipart/20190924/original/pngtree-user-vector-avatar-png-image_4830521.jpg"
                            alt="" style="width: 300px; height:300px;">
                    </div>
                    <div class="col-6" id="viewDepartmentReport">

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
{{-- filter --}}
<script type="text/javascript">
    $(document).ready(function () {
        $("#country_id").change(function () {
            var country_id = $(this).val();
            $.ajax({
                url: "{{route('get_state')}}",
                type: 'get',
                data: {
                    country_id: country_id
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    $("#state_id").empty();
                    $("#state_id").append("<option value=''>Please Select</option>");

                    for (var i = 0; i < len; i++) {
                        var id = response[i]['id'];
                        var name = response[i]['name'];
                        $("#state_id").append("<option value='" + id + "'>" + name +
                            "</option>");
                    }
                }
            });
        });
    });

</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#state_id").change(function () {
            // alert('dfshj');
            var state_id = $(this).val();
            // alert(state_id);
            $.ajax({
                url: "{{route('get_city')}}",
                type: 'get',
                data: {
                    state_id: state_id
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    $("#city_id").empty();
                    $("#city_id").append("<option value=''>Please Select</option>");

                    for (var i = 0; i < len; i++) {
                        var id = response[i]['id'];
                        var name = response[i]['name'];
                        $("#city_id").append("<option value='" + id + "'>" + name +
                            "</option>");
                    }
                }
            });
        });
    });

</script>
{{-- end filter --}}
<script type="text/javascript">
    $(document).ready(function () {
        var dataTable = $('#datatable-basic').DataTable({
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
            "searching": true,
            'processing': true,
            'serverSide': true,
            "bFilter": true,
            "bInfo": true,
            "lengthChange": true,
            "bAutoWidth": true,
            'ajax': {
                'url': "{{route('reportData')}}",
                'data': function (data) {
                    var status_id = $('#status_id').val();
                    data.status_id = status_id;
                    var state_id = $('#state_id').val();
                    data.state_id = state_id;
                    var country_id = $('#country_id').val();
                    data.country_id = country_id;
                    var city_id = $('#city_id').val();
                    data.city_id = city_id;
                    var department_id = $('#department_id').val();
                    data.department_id = department_id;
                    var badge_id = $('#badge_id').val();
                    data.badge_id = badge_id;
                    var fromdate = $('#fromdate').val();
                    data.fromdate = fromdate;
                    var todate = $('#todate').val();
                    data.todate = todate;
                    // var search = $('#search').val();
                    // data.search = search;

                }
            },
            'columns': [{
                    data: 'userName'
                },
                {
                    data: 'fullName'
                },
                {
                    data: 'postedOn'
                },
                {
                    data: 'postedAbout'
                },
                {
                    data: 'rating'
                },
                {
                    data: 'report'
                },
                {
                    data: 'action'
                },

            ]
        });
        $('#search_data1').click(function () {
            dataTable.draw();
        });
        $('#search').keyup(function () {
            dataTable.draw();
        });
        $('#status_id').on('change', function () {
            //alert( this.value );
            dataTable.draw();
        });
        $('#country_id').on('change', function () {
            //alert( this.value );
            dataTable.draw();
        });
        $('#state_id').on('change', function () {
            //alert( this.value );
            dataTable.draw();
        });
        $('#fromdate').on('change', function () {
            //alert( this.value );
            dataTable.draw();
        });
        $('#todate').on('change', function () {
            //alert( this.value );
            dataTable.draw();
        });
        $('#city_id').on('change', function () {
            //alert( this.value );
            dataTable.draw();
        });
        $('#department_id').on('change', function () {
            //alert( this.value );
            dataTable.draw();
        });
        $('#badge_id').on('change', function () {
            //alert( this.value );
            dataTable.draw();
        })
    });

</script>
<script type="text/javascript">
    function status(id, flag) {
        $.ajax({
            url: "{{route('delete_post_user')}}",
            type: "post",
            data: {
                'user_id': id,
                'flag': flag,
                '_token': "{{ csrf_token() }}"
            },
            success: function (data) {
                location.reload(); // refresh same page
            }
        });
    }

</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#country1").change(function () {
            var country_id = $(this).val();
            // alert(country_id);
            $.ajax({
                url: "{{route('get_state')}}",
                type: 'get',
                data: {
                    country_id: country_id
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    $("#state").empty();
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['id'];
                        var name = response[i]['name'];
                        $("#state").append("<option value=''>Please Select</option>");
                        $("#state").append("<option value='" + id + "'>" + name +
                            "</option>");
                    }
                }
            });
        });
    });

</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#state").change(function () {
            // alert('dfshj');
            var state_id = $(this).val();
            // alert(state_id);
            $.ajax({
                url: "{{route('get_city')}}",
                type: 'get',
                data: {
                    state_id: state_id
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    $("#city1").empty();
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['id'];
                        var name = response[i]['name'];
                        $("#city1").append("<option value=''>Please Select</option>");
                        $("#city1").append("<option value='" + id + "'>" + name +
                            "</option>");
                    }
                }
            });
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

    function viewUserDetailReportModel(id) {
        $('#viewUserDetailReportModel').modal('show');
        $.ajax({
            url: "{{ route('viewUserDetailReportModel') }}/" + id,
            type: 'get',
            success: function (response) {

                if (response.length == 0) {
                    $('#userImage2').html(``);
                    $('#viewDepartmentReport').html('');
                    $('#businessName2').html('no record found</>');
                    return false;
                }
                $('#userImage2').html(``);
                $('#businessName2').html('');
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

                $('#userImage2').append(rowImage);
                $('#viewDepartmentReport').html('');

                response.forEach(value => {
                    let row = ` <div class="col">
                    <div class="username_div"><p><img src="../storage/uploads/user_image/${value.image}" alt="user_image" class="avatar" style=" vertical-align: middle; width: 50px; height: 50px; border-radius: 50%;"></p>
                                    <p style="padding-left: 0px; margin: 10px;">${value.user_name}</p></div>
                                <div class="message_div">
                                    <p>${value.message}</p>
                                </div>
                                   

                                    <br>
                                     </div>`;
                    $('#viewDepartmentReport').append(row)
                });

                console.log(response);

                $('#viewUserDetailReportModel').modal('show');
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
              <p class="form_fields" style="padding-right:5px;">${response.department_report}<a href='javascript:void(0)' style="padding-left:10px;" onclick ='viewUserDetailReportModel(${response.id})'>view list</a></p>
              </div>
             
            
              <div class="form_div">
              <p class="form_fields">Rating:</p>
              <p class="form_fields">${response.rating} <a href='javascript:void(0)'style="padding-left:10px;" onclick ='viewUserDetailBadgeRating(${response.id})'>view list</a></p>
              </div>
              <div class="form_div">
              <p class="form_fields">Vote:</p>
              <p class="form_fields">${response.vote}<a href='javascript:void(0)'style="padding-left:10px;" onclick ='viewUserDetailVoteRating(${response.id})'>view list</a></p>
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

</script>
<script>
    function status(id) {


        $.ajax({
            url: "{{route('delete_post')}}",
            type: "post",
            data: {
                'post_id': id,
                '_token': "{{ csrf_token() }}"
            },
            success: function (data) {
                //alert();
                //  $(".cancel").(function(){

                //   $(this).parent("tr:first").remove()
                // })
                location.reload(); // refresh same page
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