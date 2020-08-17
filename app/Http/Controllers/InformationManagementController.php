<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InformationManagementController extends Controller
{

    public function about_us(){
       return view ('cms.about_us');
    }
    public function edit_about_us(Request $req){
       return redirect ('/cms/about_us');
    }

    public function privacy(){
       return view ('cms.privacy_policy');
    }
     public function edit_privacy(Request $req){
       return view ('cms/privacy');
    }


    public function terms(){
       return view ('cms.terms');
    }  
    public function edit_terms(Request $req){
       return view ('cms/terms');
    }

    public function notification(){
       return view ('cms/notification');
    }

}
