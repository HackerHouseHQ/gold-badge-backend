<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InformationData;
use App\SendNotification;

use DB;
use Auth;
use Storage;
use Session;
use Validator;

class InformationManagementController extends Controller
{

  function __construct()
        {
            $this->user = new SendNotification;
        }

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

    public function sendNotification(Request $req){
      // echo"<pre>"; print_r($req->all()); die;  
      $data['title'] = $req->title;
      $data['message'] = $req->desscription;
      $insertNotification = SendNotification::create($data);
       return redirect('cms/notification');
    }
    public function notificationList(Request $request){
         // echo"<pre>"; print_r($request->all()); die;
        $order_by = $_GET['order'][0]['dir'];
        $columnIndex = $_GET['order'][0]['column'];
        $columnName = $_GET['columns'][$columnIndex]['data'];
        $columnName =  ($columnName=='username') ? 'first_name' : 'created_at';
        $offset = $_GET['start'] ? $_GET['start'] :"0";
        $limit_t = ($_GET['length'] !='-1') ? $_GET['length'] :"";
        $draw = $_GET['draw'];
        $date1 = $_GET['date1'];
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];

        $data = $this->user->getdata_table($order_by, $offset, $limit_t,$date1,$todate,$fromdate);
        $count = $this->user->getdata_count($order_by,$date1,$todate,$fromdate);
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
          $arr[$key]['message'] = "<td><span class='tbl_row_new'>".$data->title."</span></td>";
           // $arr[$key]['message'] = "<td><span class='tbl_row_new'>".$data->title."</span></td>";
          $arr[$key]['time'] = "<td><span class='tbl_row_new'>".date("h:i a", strtotime($data->created_at))."</span></td>";
          $arr[$key]['date'] = "<td><span class='tbl_row_new'>".date("Y-m-d", strtotime($data->created_at))."</span></td>";
        }
          return $arr;
    }
   public function downloadNotification(Request $r){
   // print_r($r->all()); die;
     if(isset($_POST["Export"])){
        header('Content-Type: text/csv; charset=utf-8');  
        header('Content-Disposition: attachment; filename=data.csv');  
        $output = fopen("php://output", "w");  
        fputcsv($output, array('title','message','created_at'));  
        // echo $output;  die;
        $result = SendNotification::select('title','message','created_at')->get()->toArray();
        foreach ($result as $key => $arr) {
            fputcsv($output, $arr);
        }
        fclose($output);  
     } 
  }


}
