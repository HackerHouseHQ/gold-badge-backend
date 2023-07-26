@extends('admin_dash.main')
<style type="text/css">
    .leftpane {
        width: 20%;
        height: 100%;
        float: left;
        border-collapse: collapse;
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
</style>
@section('content')
<div class="col-sm-12">
    <div class="content-wrapper custom-content-wrapper">
        <div class="below_content_clss">
            <section class="content home_conntent">
                <div class="container-fluid">
                    {{--start table --}}
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card table_cardd">

                                <div class="card-body ">

                                    <div class="leftpane">
                                        <div class="img-r">
                                            <img src="{{$data->image}}" alt="" style="width: 100px;">
                                        </div>
                                    </div>
                                    <div class="middlepane">
                                        <div class="key_value_box">
                                            <div class="key_value_box_div">
                                                <label class="tbl_row labell">Full Name:</label>
                                            </div>
                                            <div class="key_value_box_div">
                                                <p class="tbl_row value">{{$data->first_name}} {{$data->last_name}}</p>
                                            </div>
                                            <div class="key_value_box_div">
                                                <label class="tbl_row labell">Username:</label>
                                            </div>
                                            <div class="key_value_box_div">
                                                <p class="tbl_row value">{{$data->username}}</p>
                                            </div>
                                            <div class="key_value_box_div">
                                                <label class="tbl_row labell">MOB. NO.:</label>
                                            </div>
                                            <div class="key_value_box_div">
                                                <p class="tbl_row value">
                                                    {{$data->mobile_country_code}}-{{$data->mobile_no}}</p>
                                            </div>
                                            <div class="key_value_box_div">
                                                <label class="tbl_row labell">Email:</label>
                                            </div>
                                            <div class="key_value_box_div">
                                                <p class="tbl_row value">{{$data->email}}</p>
                                            </div>
                                            <div class="key_value_box_div">
                                                <label class="tbl_row labell">Gender:</label>
                                            </div>
                                            <div class="key_value_box_div">
                                                <p class="tbl_row value">{{$data->gender}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rightpane">
                                        <div class="key_value_box">
                                            <div class="key_value_box_div">
                                                <label class="tbl_row labell">Ethnicity:</label>
                                            </div>
                                            <div class="key_value_box_div">
                                                <p class="tbl_row value">{{$data->ethnicity}}</p>
                                            </div>
                                            <div class="key_value_box_div">
                                                <label class="tbl_row labell">DOB:</label>
                                            </div>
                                            <div class="key_value_box_div">
                                                <?php $r_date = date("d/m/Y", strtotime($data->dob)); ?>
                                                <p class="tbl_row value">{{$r_date}}</p>
                                            </div>
                                            <div class="key_value_box_div">
                                                <label class="tbl_row labell">Following Department:</label>:
                                            </div>
                                            <div class="key_value_box_div">
                                                <p class="tbl_row value">0</p>
                                            </div>
                                            <div class="key_value_box_div">
                                                <label class="tbl_row labell">Following Badge:</label>
                                            </div>
                                            <div class="key_value_box_div">
                                                <p class="tbl_row value">0</p>
                                            </div>
                                            <div class="key_value_box_div">
                                                <label class="tbl_row labell">Total Reviews:</label>
                                            </div>
                                            <div class="key_value_box_div">
                                                <p class="tbl_row value">0</p>
                                            </div>
                                            <div class="key_value_box_div">
                                                <label class="tbl_row labell">Reported Reviews:</label>
                                            </div>
                                            <div class="key_value_box_div">
                                                <p class="tbl_row value">0</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end table --}}
                    {{-- start datatable --}}
                    <div class="card">
                        <div class="card-header">
                            <div class="main_menu_three_tabs1">
                                <ul class="nav nav-tabs abc">
                                    <li class="active"><a href="{{ route('UserDetail',['id' => $data->id])}}">
                                            Reviews</a></li>
                                    <li><a href="{{ route('UserDetailFollowing',['id' => $data->id])}}"> Followings</a>
                                    </li>
                                </ul>

                            </div>
                            {{-- <h3 class="card-title"></h3> --}}
                        </div>
                        <!-- /.card-header -->
                        <input type="hidden" value="{{$data->id}}" id="user_id">

                        <div class="card-body">

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Department Name</th>
                                        <th>Badge Number</th>
                                        <th>Date</th>
                                        <th>Rating</th>
                                        <th>Likes</th>
                                        <th>Share</th>
                                        <th>Commennt</th>
                                        <th>Report</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Trident</td>
                                        <td>#46fsdh4</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>View post<br>Delete</td>
                                    </tr>
                                    <tr>
                                        <td>Trident</td>
                                        <td>#46fsdh4</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>View post<br>Delete</td>
                                    </tr>
                                    <tr>
                                        <td>Trident</td>
                                        <td>#46fsdh4</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>View post<br>Delete</td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    {{-- end end datatable --}}
                </div>
            </section>
        </div>
    </div>
</div>
{{-- model view department --}}
<div class="modal fade" id="viewUserDetailModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-capitalize" id="businessName"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6" id="userImage">
                        <img src="https://png.pngtree.com/png-clipart/20190924/original/pngtree-user-vector-avatar-png-image_4830521.jpg"
                            alt="" style="width: 300px; height:300px;">
                    </div>
                    <div class="col-6" id="viewDepartment">


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
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        var dataTable = $('#example1').DataTable({
            "searching": false,
            'processing': true,
            'serverSide': true,
            "bFilter": true,
            "bInfo": false,
            "lengthChange": false,
            "bAutoWidth": false,
            'ajax': {
                'url': "{{route('UserDetailData')}}",
                'data': function (data) {
                    var user_id = $('#user_id').val();
                    data.user_id = user_id;
                    var search = $('#search').val();
                    data.search = search;
                    //   var status_id = $('#status_id').val();
                    // data.status_id = status_id;
                    // var state_id = $('#state_id').val();
                    // data.state_id = state_id;
                    // var country_id = $('#country_id').val();
                    // data.country_id = country_id;
                    //  var fromdate = $('#fromdate').val();
                    // data.fromdate = fromdate;
                    // var todate = $('#todate').val();
                    // data.todate = todate;
                }
            },
            'columns': [{
                    data: 'department_name'
                },
                {
                    data: 'badge_number'
                },
                {
                    data: 'date'
                },
                {
                    data: 'rating'
                },
                {
                    data: 'likes'
                },
                {
                    data: 'share'
                },
                {
                    data: 'comment'
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
    });

</script>
<script>
    function viewUserDetailModel(id) {
        // alert(id);
        $.ajax({
            url: "{{ route('viewUserDetailModel') }}/" + id,
            type: 'get',
            success: function (response) {
                // console.log(response.departments.image);
                if (typeof response.departments.image != "undefined") {
                    $('#userImage').html(`<img
              src="${response.departments.image}"
              alt="" style="width: 300px; height:300px;">`);
                } else {
                    $('#userImage').html(` <img
              src="https://png.pngtree.com/png-clipart/20190924/original/pngtree-user-vector-avatar-png-image_4830521.jpg"
              alt="" style="width: 300px; height:300px;">`);
                }
                $('#viewDepartment').html('');

                let row = ` <div class="col">

        <span><img src="${response.users.image}" alt="user_image" class="avatar" style=" vertical-align: middle;
  width: 50px;
  height: 50px;
  border-radius: 50%;"></span>
        <br>
              <span>Full Name:</span>
              <span>${response.users.first_name+' '+ response.users.last_name}</span>
              <br>
              <span>Posted On:</span>
              <span>${response.created_at.substr(0,10).split('-').reverse().join('/')}</span>
              <br>
              <span>Likes:</span>
              <span>0</span>
              <br>
              <span>Share:</span>
              <span>0</span>
              <br>
              <span>Comments:</span>
              <span>0</span>
              <br>
              <span>Report:</span>
              <span>0</span>
              <br>
              <span>Rating:</span>
              <span>${response.rating}</span>
              <br>
              <span>Review:</span>
              <span></span>
              <br>
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
<script type="text/javascript">
    function status(id) {
        $.ajax({
            url: "{{route('delete_post')}}",
            type: "get",
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

@endsection
