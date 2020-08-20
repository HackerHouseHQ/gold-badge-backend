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
            <li><a href="{{route('countries')}}">Manage Countries</a></li>
            <li class="active"><a href="{{route('ethnicity')}}">Manage Ethnicity</a></li>
           <li><a href="{{route('gender')}}">Gender</a></li>
           <li><a href="{{route('report')}}">Report Reason Type</a></li>
           </ul>
         </div>
         </div>
         {{-- close --}}
         {{-- add city country gender report reason --}}
         <div class="row">
          <div class="main_menu_add_tabs">
           <ul class="nav space_in_li xyy">
            <li><a href="{{route('add_country_page')}}">add new country<img src="{{ asset('admin_css/images/add_people.png')}}"></a></li>
            <li><a href="{{route('add_state_page')}}">add new state<img src="{{ asset('admin_css/images/add_people.png')}}"></a></li>
           <li><a href="{{route('add_city_page')}}">add new city<img src="{{ asset('admin_css/images/add_people.png')}}"></a></li>
           <li><a href="{{route('add_ethnicity_page')}}">add new ethnicity<img src="{{ asset('admin_css/images/add_people.png')}}"></a></li>
          </ul>
          </div>
         </div>
         <br>
            {{-- table --}}
  {{--      <div class="container">
        <table class="table table-striped">
         <thead>
            <tr>
              <th>ETHNICITY NAME</th>
              <th> </th>
              <th> </th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $ethnicityData)
            <tr>
              <td>{{$ethnicityData->ethnicity_name}}</td>
              <td> <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#exampleModalCenter" onclick="openModal({{$ethnicityData->id}})"> Edit</button></td>
              <td><a href="{{route('DeleteEthnicity',$ethnicityData->id)}}">Delete</a></td>
            </tr>
            @endforeach
          </tbody>
         </table>
        </div> --}}
               <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <table id="data1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th><span class="tbl_row">ETHNICITY NAME</span></th>
                  <th><span class="tbl_row"></span></th>
                    <th><span class="tbl_row"></span></th>
                </tr>
                </thead>
              <tbody>
            @foreach($data as $ethnicityData)
            <tr>
              <td><span class='tbl_row_new'>{{$ethnicityData->ethnicity_name}}</span></td>
              <td><span class='tbl_row_new'> <button class="btn btn-xs btn btn-link" data-toggle="modal" data-target="#exampleModalCenter" onclick="openModal({{$ethnicityData->id}})"> Edit</button><span class='tbl_row_new'></td>
              <td><span class='tbl_row_new'><a href="{{route('DeleteEthnicity',$ethnicityData->id)}}">Delete</a><span class='tbl_row_new'></td>
            </tr>
            @endforeach
          </tbody>
              </table>
              {{ $data->links() }}
             </div>
           </div>
         </div>
       </div>
            {{-- table --}}

         {{-- close --}}
          </div>
        </section>

                 {{-- model edit --}}
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
                            <form action="{{route('updatEthnicity')}}" method ="GET">
                              <div id="businessDetails">
                                
                              </div>
                              <button type="submit" class="btn btn-secondary">Save</button>
                    
                            </form>
                    </div>
                  </div>
                </div>
              </div>
             
             </div>
            </div>
          </div>
        {{-- end model edit --}}


      </div>
      </div>
    </div>
  @endsection
  @section('script')
      <script type="text/javascript">
    function openModal(id) {
      // alert(id);
      $.ajax({
          url: "{{ route('Show_edit_ethnicity') }}/" + id, 
          type: 'get',
          success: function (response) {
          // $('#businessName').html(response.genderData);
          
           
              $('#businessDetails').html('');
            let row = `
              
                <b>Ethnicity Name</b>
                <input type="hidden" name="id" value = "${response.id}">
                <input type="text" name="name" value = "${response.ethnicity_name}">
              
 
            `;
              $('#businessDetails').append(row);
              // $('#businessDetails').html(row);
          
        },
        error: function(err) {
          console.log(err);
        }
      });
    }
  </script>
@endsection
