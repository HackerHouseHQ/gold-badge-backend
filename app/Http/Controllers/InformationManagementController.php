<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InformationData;

class InformationManagementController extends Controller
{

    public function about_us(){
       $GetAboutUs = InformationData::first();
       $data['data'] = $GetAboutUs;      
       return view ('cms.about_us',$data);
    }
    public function edit_about_us(Request $req){
       $data['about_us'] = $req->AboutUs;
       $updateAboutUs = InformationData::where('id',1)->update($data);
       return redirect('/cms/about_us');
    }

    public function privacy(){
       $GetPrivacy = InformationData::first();
       $data['privacy'] = $GetPrivacy;      
       return view ('cms.privacy_policy',$data);
    }
     public function edit_privacy(Request $req){
      // print_r($req->all()); die;
       $data['privacy'] = $req->privacy;
       $updatePrivacy = InformationData::where('id',1)->update($data);
       return redirect('/cms/privacy');
    }


    public function terms(){
      $GetTerms = InformationData::first();
      $data['Terms'] = $GetTerms;
       return view ('cms.terms',$data);
    }  
    public function edit_terms(Request $req){
       $data['terms'] = $req->terms;
       $updateTerms = InformationData::where('id',1)->update($data);
       return redirect('/cms/terms');
    }

    public function notification(){
       return view ('cms/notification');
    }

}
