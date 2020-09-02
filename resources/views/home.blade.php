@extends('admin_dash.main')
@section('content')
<div class="col-sm-12">
    <div class="content-wrapper custom-content-wrapper">
        <div class="below_content_clss">
            <section class="content home_conntent">
                <div class="container-fluid">
                    {{-- <h1>he</h1> --}}
                    <div class="row">
                        <div class="col-lg-4 col-7">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3 class="no-margins">{{$UserCount}}</h3>

                                    <p>Registered Users</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-7">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>1<sup style="font-size: 20px"></sup></h3>
                                    <p>Guest Login </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-7">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3 class="no-margins">{{$DepartmentCount}}</h3>

                                    <p>Total Departments</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{$BadgeCount}}<sup style="font-size: 20px"></sup></h3>
                                    <p>Total badge </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-7">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3 class="no-margins">10</h3>

                                    <p>Total Reviews</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                    {{-- <h1>he</h1> --}}
                    <div class="row" style="border:1px solid #000; padding: 5px;border-radius: 5px;background-color: #3aa3b959;">

                        <form action="" id="search_data" class="search_data_row_class" style="margin-top:0;padding-left:0;margin-bottom:0; width: 100%">

<!--                            <span class="div_cover_sell">
         <span>
             <select name="status_id" id="status_id">
                 <option value="">status</option>
                 <option value="1">Active</option>
                 <option value="2">Inactive</option>:
             </select>
         </span>
     </span>-->
                        <div style="">
                        <div class="row">
                            <div class="col-lg-3">
                                <span class="div_cover_sell">
                                    <span>
                                        <?php $countryList = App\Country::get(); ?>
                                        <select name="country_id" id="country_id">
                                            <option value="">Country</option>
                                            @foreach($countryList as $counntryList)
                                            <option value="{{$counntryList->id}}">{{$counntryList->country_name}}</option>
                                            @endforeach
                                        </select>
                                    </span>
                                </span>
                            </div>
                            <div class="col-lg-3">
                                <span class="div_cover_sell">
                                    <span>
                                        <select name="state_id" id="state_id">
                                            <option value="">State</option>
                                        </select>
                                    </span>
                                </span>
                            </div>
                            <div class="col-lg-3">
                                <span class="div_cover_sell">
                                    <span>
                                        <select name="city_id" id="city_id">
                                            <option value="">City</option>
                                        </select>
                                    </span>
                                </span>
                            </div>
                            <div class="col-lg-3">
                                <span class="div_cover_sell">
                                    <span>
                                        <select name="city_id" id="city_id">
                                            <option value="">Gender</option>
                                            <option value="">Male</option>
                                            <option value="">Female</option>
                                        </select>
                                    </span>


                                </span>
                            </div>
                        </div>
                            <div class="row mt-4">
                                <div class="col-lg-3">
                                    <span class="div_cover_sell">
                                        <span>

                                            <span>
                                                <?php $ethnicytyList = App\Ethnicity::get(); ?>
                                                <select name="country_id" id="country_id">
                                                    <option value="">Ethnicity</option>
                                                    @foreach($ethnicytyList as $list)
                                                    <option value="{{$list->id}}">{{$list->ethnicity_name}}</option>
                                                    @endforeach
                                                </select>
                                            </span>                   
                                        </span>

                                    </span>
                                </div>

                                <!--<span class="from_to_select">-->
                                 <div class="col-lg-4">
                                    <label for="from_text" class="serach_by_text">From</label>

                                    <input type="date" class="from_control" name="fromdate" id="fromdate"
                                           style="-webkit-appearance: media-slider;">
                                    </div>
                                  <div class="col-lg-4">
                                    <label for="to_text" class="serach_by_text">To</label>
                                    <input type="date" class="from_control" name="todate" id="todate"
                                           style="-webkit-appearance: media-slider;">
                                    </div>
                                <!--</span>-->
                                <div class="col-lg-1">
                                <input type="hidden" placeholder="Look for user" name="search2" id="search2" class="search_input">
                                <button type="button" id="search_data1" class="apply_btnn">Apply</button>

                                </div>
                            </div>
                            </div>

                    </form>
 </div>

                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header border-0">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="card-title">Users</h3>
                                        <!--<a href="javascript:void(0);">View Report</a>-->
                                    </div>
                                </div>
                                <!--                                <div class="card-body">
                                                                    <div class="d-flex">
                                                                        <p class="d-flex flex-column">
                                                                            <span class="text-bold text-lg">$18,230.00</span>
                                                                            <span>Sales Over Time</span>
                                                                        </p>
                                                                        <p class="ml-auto d-flex flex-column text-right">
                                                                            <span class="text-success">
                                                                                <i class="fas fa-arrow-up"></i> 33.1%
                                                                            </span>
                                                                            <span class="text-muted">Since last month</span>
                                                                        </p>
                                                                    </div>
                                                                   
                                                                    <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                                                        <canvas id="sales-chart" height="200" style="display: block; width: 488px; height: 200px;" width="488" class="chartjs-render-monitor"></canvas>
                                                                    </div>
                                
                                                                    <div class="d-flex flex-row justify-content-end">
                                                                        <span class="mr-2">
                                                                            <i class="fas fa-square text-primary"></i> This year
                                                                        </span>
                                
                                                                        <span>
                                                                            <i class="fas fa-square text-gray"></i> Last year
                                                                        </span>
                                                                    </div>
                                                                </div>-->


                                <div id="chartContainer" style="height: 370px; width: 100%;"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<?php
$dataPoints = array(
    array("y" => 3373.64, "label" => "Jan"),
    array("y" => 2435.94, "label" => "Feb"),
    array("y" => 1842.55, "label" => "Mar"),
    array("y" => 1828.55, "label" => "Apr"),
    array("y" => 1039.99, "label" => "May"),
    array("y" => 765.215, "label" => "Jun"),
    array("y" => 612.453, "label" => "Jul"),
    array("y" => 612.453, "label" => "Aug"),
    array("y" => 612.453, "label" => "Oct"),
    array("y" => 612.453, "label" => "Nov"),
    array("y" => 612.453, "label" => "Dec")
);
?>

@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
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
                                $("#state_id").append("<option value=''>Please Select</option>");
                                for (var i = 0; i < len; i++){
                        var id = response[i]['id'];
                                var name = response[i]['name'];
                                $("#state_id").append("<option value='" + id + "'>" + name + "</option>");
                        }
                        }
                });
        });
        }
        );
</script>
<script type="text/javascript">
        $(document).ready(function () {
            $("#state_id").change(function(){
            // alert('dfshj');
            var state_id = $(this).val();
                    // alert(state_id);
                    $.ajax({
                    url: '{{route('get_city')}}',
                            type: 'get',
                            data: {state_id:state_id},
                            dataType: 'json',
                            success:function(response){
                            var len = response.length;
                                    $("#city_id").empty();
                                    $("#city_id").append("<option value=''>Please Select</option>");
                                    for (var i = 0; i < len; i++){
                            var id = response[i]['id'];
                                    var name = response[i]['name'];
                                    $("#city_id").append("<option value='" + id + "'>" + name + "</option>");
                            }
                            }
                    }
                    );
        });
    });
</script>
<script>
    window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title: {
                //text: "Gold Reserves"
            },
            axisY: {
                title: "Users"
            },
            data: [{
                    type: "column",
                    yValueFormatString: "#,##0.## tonnes",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
        });
        chart.render();

    }
</script>
@endsection
