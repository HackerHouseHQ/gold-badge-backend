<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManageDataController extends Controller
{
    public function countries(){
    	return view('manage_data.countries');
    }
// add country
    public function add_country_page(){
    	return view('manage_data.add_country');
    }
// end add country  
}
