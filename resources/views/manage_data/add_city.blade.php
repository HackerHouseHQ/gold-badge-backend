@extends('admin_dash.main')
<style type="text/css">
  .addstateSave{
    margin: 10px;
    margin-left: 211px;
    padding: 16px;

  }
</style>
 @section('content')
    <div class="col-sm-12">
     <div class="content-wrapper custom-content-wrapper">
      <div class="below_content_clss">
        <section class="content home_conntent">
          <div class="container-fluid">
         {{-- add country --}}
        <div class="row">
         <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">

            <div class="panel-heading"> <a href="{{ route('countries')}}"><img src="{{ asset('admin_css/images/cross_icon.png') }}"></a>Add New City</div>
             <div class="panel-body">
              <form class="form-horizontal" method="POST" action="{{route('add_city')}}"          enctype="multipart/form-data">
                {{ csrf_field() }}
                <?php $countryList =  App\Country::get();?>
                  <br>
                 <div class="form-group row one_key_pairr">
                   <label for="text" class="ttl_bnr addteam promo">Select Country</label>
                    <div class="col-10 col-sm-10 col-md-8 col-lg-4">
                     <div class="to_display_inline">
                      <select name="country_id" id="country_id" class="form-control formn_custom_class_add_form" style="-webkit-appearance: none;">
                        <option value="">Select Country</option>
                        @foreach($countryList as $counntryList)
                            <option value="{{$counntryList->id}}">{{$counntryList->country_name}}</option>
                          @endforeach
                      </select>
                      <img src="{{asset('admin_css/images/down_icon.png')}}" class="img-fluid team_formm_cityy">
                     </div>
                    </div>
                  </div>  
                  <div class="form-group row one_key_pairr">
                   <label for="text" class="ttl_bnr addteam promo">Select State</label>
                   <div class="col-10 col-sm-10 col-md-8 col-lg-4">
                    <div class="to_display_inline">
                     <select name="state_id" id="state_id" class="form-control formn_custom_class_add_form">
                      <option value="">Select State</option>
                     </select>
                     <img src="{{asset('admin_css/images/down_icon.png')}}" class="img-fluid team_formm_cityy">
                    </div>
                   </div>
                  </div>
                 <br>
                  <div class="orm-control formn_custom_class_add_form">
                   <input type="text" class="form-control" placeholder="Enter City Name" name="city_name" value="{{ old('state_name') }}">
                 </div>
                 <p><b>OR</b></p><br>
                  <div class="col-md-6">
                   <input type="file" class="form-control"placeholder="fghj" name="city_file" style="display: block;">
                  </div>
                 <div class="form-group addstateSave">
                  <div class="col-md-8 col-md-offset-4">
                   <button type="submit" class="btn btn-primary">
                    Save
                   </button>
                  </div>
                 </div>
                </form>
               </div>
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
  <script type="text/javascript">
  $(document).ready(function(){
    $("#country_id").change(function(){
        var country_id = $(this).val();
        $.ajax({
            url: '{{route('get_state')}}',
            type: 'get',
            data: {country_id:country_id},
            dataType: 'json',
            success:function(response){
            var len = response.length;
            $("#state_id").empty();
              for( var i = 0; i<len; i++){
                var id = response[i]['id'];
                var name = response[i]['name'];
                $("#state_id").append("<option value='"+id+"'>"+name+"</option>");
              }
            }
        });
    });
  });
</script>
@endsection
