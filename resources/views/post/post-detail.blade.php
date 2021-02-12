@extends('admin_dash.main')
<style>
    /* img {
  transition: transform .5s;
  transform: scale(.5);
} */

/* img:hover, img:focus {
    transform: scale(2);
    opacity: 5;

} */
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

    .avatar1 {
        vertical-align: middle;
        width: 75px;
        height: 75px;
        border-radius: 50%;
        margin-bottom: 10px;
    }

    td.sorting_1 {
        width: 50%;
        padding: 0;
    }


    img.d-block {
        width: 65%;
        text-align: center;
        margin: 0 auto;
        display: flex;
        height: 185px;
    }

    .carousel-control-prev {
        left: 0;
        background: #cea42f;

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

    .carousel-control-next {
        right: 0;
        background: #cea42f;

    }

    .modal_rating_icon {
        width: 10px;
        margin-top: -2px;
        margin-left: 2px;
    }

    .alignleft {
        float: left;
    }

    .alignright {
        float: right;

    }

    .table td,
    .table th {
        font-size: .8125rem;
        white-space: pre-wrap !important;
    }

</style>
@section('content')
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Post</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">PostDetails</li>
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

                                            <img class="avatar1" src="../storage/uploads/user_image/{{ $data->image }}"
                                                alt="User profile picture">
                                        </div>
                                        <input type="hidden" id="user_id" value="{{ $data->id }}">

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                Full Name <a
                                                    class="float-right">{{ $data->first_name . ' ' . $data->last_name }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                Username <a class="float-right">{{ @$data->user_name }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                Mobile No. <a class="float-right">{{ @$data->mobil_no }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                Gender <a class="float-right">{{ @$data->gender }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                Ethnicity <a class="float-right">{{ @$data->ethnicity }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                D.O.B.<a
                                                    class="float-right">{{ date('d-m-y', strtotime(@$data->dob)) }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                Following Departments <a
                                                    class="float-right">{{ @$data->total_department_follows }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                Following Badges <a
                                                    class="float-right">{{ @$data->total_department_badge_follows }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                Reported Reviews <a class="float-right">{{ @$data->total_report }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                Total Reviews <a class="float-right">{{ @$data->total_reviews }}</a>
                                            </li>
                                        </ul>
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
                                                        <input class="form-control form-control" type="text"
                                                            placeholder="Search By Name.Badge,Department,Country,State,City....">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class='col-sm-6'>
                                                    <?php $departmentList = App\Department::get(); ?>
                                                    <div class="form-group">
                                                        <select class="form-control" name="department_id"
                                                            id="department_id">
                                                            <option value="">Department</option>
                                                            @foreach ($departmentList as $departmenntList)
                                                            <option value="{{ $departmenntList->id }}">
                                                                {{ $departmenntList->department_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='col-sm-6'>
                                                    <?php $departmentBadgeList =
                                                        App\DepartmentBadge::get(); ?>
                                                    <div class="form-group">
                                                        <select class="form-control" name="badge_id" id="badge_id">
                                                            <option value="">Badge</option>
                                                            @foreach ($departmentBadgeList as $departmenntBadgeList)
                                                            <option value="{{ $departmenntBadgeList->id }}">
                                                                {{ $departmenntBadgeList->badge_number }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
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
                                            </div>
                                            <input type="hidden" placeholder="Look for user" name="search2" id="search2"
                                                class="search_input">
                                            <div class="row">
                                                <div class='col-sm-2 d-flex'>

                                                    <button type="button" id="search_data1"
                                                        class="btn btn-primary apply_btnn">Apply</button>
                                                    <button type="button" value="Reset form" onclick="myFunction()"
                                                        class="btn btn-info apply_btnn">Reset</button>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card class_scroll ">
                                            <div class="card-body p-0">
                                                <table id="data1" class="table" style="width: 100%;">
                                                    <tbody>
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
                        <div class="col-sm-12" id="viewDepartmentComment">

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

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
                    <div class="col-sm-12" id="reason_list">
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
                    <div class="col-sm-12" id="vote_list">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modal title</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
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
            "searching": false,
            'processing': true,
            'serverSide': true,
            "bFilter": true,
            "bInfo": false,
            "lengthChange": false,
            "bAutoWidth": false,
            "pageLength": 2,
            "orderable": false,
            'ajax': {
                'url': "{{ route('PostDepartmentDetail') }}",
                'data': function (data) {
                    var user_id = $('#user_id').val();
                    data.user_id = user_id;
                    var department_id = $('#department_id').val();
                    data.department_id = department_id;
                    var badge_id = $('#badge_id').val();
                    data.badge_id = badge_id;
                    var fromdate = $('#fromdate').val();
                    data.fromdate = fromdate;
                    var todate = $('#todate').val();
                    data.todate = todate;

                }
            },

            columnDefs: [{
                className: "cancel",
                "targets": [-1]
            }],
            'columns': [{
                    data: 'image',
                },
                {
                    data: 'userName'
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
    function status(id) {
        $.ajax({
            url: "{{ route('delete_post') }}",
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
                    `<img src="{{ asset('admin_new/assets/img/pinkbadge_icon.png') }}" alt="" class="modal_rating_icon">`
            }
            if (rating >= 2 && rating < 3) {
                ratingIcon =
                    `<img src="{{ asset('admin_new/assets/img/purplebadge_icon.png') }}" alt="" class="modal_rating_icon">`;
            }


            if (rating >= 3 && rating < 4) {
                ratingIcon =
                    `<img src="{{ asset('admin_new/assets/img/bronzebadge_icon.png') }}" alt="" class="modal_rating_icon">`;
            }
            if (rating >=
                4 && rating < 5) {
                ratingIcon =
                    `<img src="{{ asset('admin_new/assets/img/silverbadge_icon.png') }}" alt="" class="modal_rating_icon">`;
            }
            if (rating == 5) {
                ratingIcon =
                    `<img src="{{ asset('admin_new/assets/img/goldbadge_icon.png') }}" alt="" class="modal_rating_icon">`;
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
                    row += ` <div class="col">
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

</script>
<script>
    function viewSubcomment(id) {
        $('#view_sub_comment' + id).toggle();
    }
    $(document).on('click','img',function(){
	$('#modal .modal-body').html($(this).clone()[0]);
  $('#modal').modal('show');
})
</script>
@endsection
