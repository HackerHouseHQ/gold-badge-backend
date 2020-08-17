<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Country;
use App\CountryState;

class ManageDataController extends Controller
{
	// show country
    public function countries(){
    	return view('manage_data.countries');
    }
    // show enthcity
    public function ethnicity(){
    	return view('manage_data.ethnicity');
    }
    // // show option to give user gender
    public function gender(){
    	return view('manage_data.gender');
    }
    // // show report reason option page
    public function report(){
    	return view('manage_data.report');
    }
// add country
    public function add_country_page(){
    	return view('manage_data.add_country');
    }
    public function add_country(Request $request){
        // print_r($request->all()); die;
        $data['country_name'] = $request->counry_name;
        $insertCountry = Country::create($data);
        return redirect('/manage_data/countries');
    }
// end add country 
// add state
    
    public function add_state_page(){
        return view('manage_data.add_state');
    }
    public function add_state(){
  	  print_r($request->all()); die;
      $data['country_id'] = $request->counry_name;
      $data['state_name'] = $request->counry_name;
        $insertCountry = CountryState::create($data);
    }
// end add state 
 // add city
    public function add_city_page(){
    	return view('manage_data.add_city');
    }
// end add city 
// add ethnicity
    public function add_ethnicity_page(){
    	return view('manage_data.add_ethnicity');
    }
// end add enthnicity  
}
