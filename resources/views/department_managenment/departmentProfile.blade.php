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
                       src="{{asset('storage/'.$data->image)}}"
                       alt="User profile picture">
                </div>

             
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    Department <a class="float-right">{{$data->department_name}}</a>
                  </li>
                  <li class="list-group-item">
                    Country <a class="float-right">{{$data->country_data->country_name}}</a>
                  </li>
                  <li class="list-group-item">
                    State <a class="float-right">{{$data->state_data->state_name}}</a>
                  </li>
                   <li class="list-group-item">
                    City <a class="float-right">{{$data->city_data->city_name}}</a>
                  </li>
                  <li class="list-group-item">
                    Avg. Rating <a class="float-right">0</a>
                  </li>
                  <li class="list-group-item">
                    No. of badge <a class="float-right">0</a>
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

                {{-- <a href="#" class=""><b>View Badge List</b></a> --}}
                <a href='javascript:void(0)' onclick ='viewDepartmentBadgeModel1({{$data->id}})'><span class='tbl_row_new1 view_modd_dec'><b>View Badge List</b></span></a>
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
                    <option value = "1">Active</option>
                    <option value = "2">Inactive</option>
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

                 {{-- model view badge --}}
          <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title text-capitalize" id="businessName"></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                 </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <div>
                        <table  class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th><span class="tbl_row">SN.</span></th>
                              <th> <span class="tbl_row">Badge Number</span> </th>
                              <th> <span class="tbl_row">Rating</span> </th>
                              <th> <span class="tbl_row">Reviews</span> </th>
                              <th> <span class="tbl_row"></span> </th>
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
@endsection
@section('script')  
<script type="text/javascript">
  function viewDepartmentBadgeModel1(id){
   // alert(id); 

       $.ajax({
          url: "{{ route('viewDepartmentBadgeModel') }}/" + id, 
          type: 'get',
          success: function (response) {
            // console.log(response);
          if(response[0]) {
              $('#businessDetails').html('');
              var i = 0;
              $.each(response, function(key, value){

                var url = '{{ route("BadgeDetail", ":id") }}';
                 url = url.replace(':id','id='+value.id);

                let row = `
                <tr>
                  <td> ${++i} </td>
                  <td class="text-capitalize">${value.badge_number}</td>
                  <td class="text-capitalize">0</td>
                  <td class="text-capitalize">0</td>
                  <td class="text-capitalize"><a href="${url}">View Profile</a></td>
                  <td></td>
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
        error: function(err) {
          console.log(err);
        }
      });
  }
</script>

@endsection
