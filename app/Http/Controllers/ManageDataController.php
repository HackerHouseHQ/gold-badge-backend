<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Country;
use App\CountryState;
use App\City;
use App\Ethnicity;
use App\GenderOption;
use App\ReportReasson;

class ManageDataController extends Controller
{
	// show country
    function __construct()
        {
            $this->state = new CountryState;
        }


    public function countries(){
    	return view('manage_data.countries');
    }
     public function countries_list(Request $request){
         // echo"<pre>"; print_r($request->all()); die;
        $order_by = $_GET['order'][0]['dir'];
        $columnIndex = $_GET['order'][0]['column'];
        $columnName = $_GET['columns'][$columnIndex]['data'];
        $columnName =  ($columnName=='username') ? 'first_name' : 'created_at';
        $offset = $_GET['start'] ? $_GET['start'] :"0";
        $limit_t = ($_GET['length'] !='-1') ? $_GET['length'] :"";
        $draw = $_GET['draw'];
        $search= $request->role;
        $data = $this->state->getdata_table($order_by, $offset, $limit_t);
        $count = $this->state->getdata_count($order_by);
        $getuser = $this->manage_data($data);
        $results = ["draw" => intval($draw),
            "iTotalRecords" => $count,
            "iTotalDisplayRecords" => $count,
            "aaData" => $getuser ];
            echo json_encode($results);
      }
      public function manage_data($data){
          $arr = array();
          $i = 0;
          foreach($data as $key=>$data){
            $arr[$key]['country_name'] = "<td><span class='tbl_row_new'>".$data->country_data->country_name."</span></td>";
            $arr[$key]['state_name'] = "<td><span class='tbl_row_new'>".$data->state_name."</span></td>";
            $array_city = array();
            foreach ($data->city_data as $key1 => $cityData) {
               array_push($array_city, $cityData->city_name);
            }
            $array_city = implode(",",$array_city);

            
            $arr[$key]['city_name'] = "<td><span class='tbl_row_new'>".$array_city."</span></td>";
            // group_concat(ss.sub_services_name) as sub_services_name')
             $arr[$key]['view'] = 'view';
          }
         return $arr;
    }

    public function add_country_page(){
        return view('manage_data.add_country');
    }
             // insert country
    public function add_country(Request $request){
        $data['country_name'] = $request->counry_name;
        $insertCountry = Country::create($data);
        return redirect('/manage_data/countries');
    }
    public function add_state_page(){
        return view('manage_data.add_state');
    }
            // insert state
    public function add_state(Request $request){
     // echo"<pre>"; print_r($request->all()); die;
     if(!empty($request->state_file)){
        echo"sdf"; die;
     }
     else {
       $data['country_id'] = $request->country_id;
      $data['state_name'] = $request->state_name;
      $insertCountry = CountryState::create($data);
      return redirect('/manage_data/countries');
     }
     
    }

    public function add_city_page(){
        return view('manage_data.add_city');
    }
    public function get_state(Request $request){
        $country_id =$request->country_id;   
        $state_data = CountryState::where('country_id',$country_id)->get()->toArray();
        $state_arr = array();
        foreach ($state_data as $key => $value) {
            $stateid = $value['id'];
            $name = $value['state_name'];
            $state_arr[] = array("id" => $stateid, "name" => $name);
        }
        echo json_encode($state_arr);
    }
    public function add_city(Request $request){
      if(!empty($request->state_file)){
        echo"sdf"; die;
     } else {
       $data['country_id'] = $request->country_id;
       $data['state_id'] = $request->state_id;
      $data['city_name'] = $request->city_name;
      $insertCountry = City::create($data);
      return redirect('/manage_data/countries');
     }
    }


    // show enthcity
    public function ethnicity(){
        $ethnicityData = Ethnicity::get();
        $data['data'] = $ethnicityData;
    	return view('manage_data.ethnicity',$data);
    }
    // add ethnicity
    public function add_ethnicity_page(){
        return view('manage_data.add_ethnicity');
    }
    public function add_ethnicity(Request $request){
        $data['ethnicity_name'] =   ucfirst($request->ethnicity_name);
        $InsertEthnicity = Ethnicity::Create($data);
        return redirect('/manage_data/ethnicity');
    }
    public function DeleteEthnicity($id){
          $DeleteEthnicity = Ethnicity::where('id',$id)->delete(); 
          return redirect('/manage_data/ethnicity');
    }
     public function Show_edit_ethnicity($id){
        $genderData = Ethnicity::where('id',$id)->first();
         return response()->json($genderData, 200);
    }
    public function updatEthnicity(Request $request){
         $data['ethnicity_name'] = ucfirst($request->name);
         $EthnicityData = Ethnicity::where('id',$request->id)->update($data);
         return redirect('/manage_data/ethnicity');
    }


    
    // show option to give user gender
    public function gender(){
        $genderData = GenderOption::get();
        $data['data'] = $genderData;
    	return view('manage_data.gender',$data);
    }
    public function DeleteGender($id){
          $Delete = GenderOption::where('id',$id)->delete(); 
          return redirect('/manage_data/gender');
    }
    public function Show_edit_gender($id){
        $genderData = GenderOption::where('id',$id)->first();
         return response()->json($genderData, 200);
    }
    public function updateGender(Request $request){
         $data['name'] = ucfirst($request->name);
         $genderData = GenderOption::where('id',$request->id)->update($data);
         return redirect('/manage_data/gender');
    }
    public function AddGender(Request $request){
        // echo"<pre>"; print_r($request->all()); die;
         $data['name'] = ucfirst($request->name);
         $genderData = GenderOption::create($data);
         return redirect('/manage_data/gender');
    }

    // // show report reason option page
    public function report(){
        $reportData = ReportReasson::get();
        $data['data'] = $reportData;
    	return view('manage_data.report',$data);
    }
    public function DeleteReport($id){
      $Delete = ReportReasson::where('id',$id)->delete(); 
      return redirect('/manage_data/report');
    }
     public function Show_edit_report($id){
        $genderData = ReportReasson::where('id',$id)->first();
         return response()->json($genderData, 200);
    }
    public function updatReport(Request $request){
         $data['name'] = ucfirst($request->name);
         $genderData = ReportReasson::where('id',$request->id)->update($data);
         return redirect('/manage_data/report');
    }
    public function AddReport(Request $request){
              // echo"<pre>"; print_r($request->all()); die;
         $data['name'] = ucfirst($request->name);
         $genderData = ReportReasson::create($data);
         return redirect('/manage_data/report');
    }


}
