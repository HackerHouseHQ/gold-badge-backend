<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Storage;
use Auth;
use Session;
use Validator;


use App\Department;
use App\DepartmentBadge;

class DepartmentController extends Controller
{

   function __construct()
    {
         $this->user = new Department;
         $this->badge = new DepartmentBadge;
     }

    public function department()
     {
         return view('department_managenment.deprtment');
     }
    public function department_list(Request $request){
        // echo"<pre>"; print_r($request->all()); die;
        $order_by = $_GET['order'][0]['dir'];
        $columnIndex = $_GET['order'][0]['column'];
        $columnName = $_GET['columns'][$columnIndex]['data'];
        $columnName =  ($columnName=='username') ? 'first_name' : 'created_at';
        $offset = $_GET['start'] ? $_GET['start'] :"0";
        $limit_t = ($_GET['length'] !='-1') ? $_GET['length'] :"";
        $draw = $_GET['draw'];
        $status_id = $_GET['status_id'];
        $state_id = $_GET['state_id'];
        $country_id = $_GET['country_id'];
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];
        $search = $_GET['search'];
        $data = $this->user->getdata_table($order_by, $offset, $limit_t,$status_id,$state_id,$country_id,$fromdate,$todate,$search);
        $count = $this->user->getdata_count($order_by,$status_id,$state_id,$country_id,$fromdate,$todate,$search);
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
        $view = "<a href='".route('DepartmentDetail',['id' => $data->id])."'><span class='tbl_row_new1 view_modd_dec'>VIEWDETAIL</span></a><br>";
        $active = "<a href='javascript:void(0)' onclick ='status(".$data->id.")'><span class='tbl_row_new1 view_modd_dec'>ACTIVATE</span></a>";
        $inactive = "<a href='javascript:void(0)' onclick = 'status(".$data->id.")'><span class='tbl_row_new1 view_modd_dec'>INACTIVATE</span></a>";


        $arr[$key]['name'] = "<td><span class='tbl_row_new'>".$data->department_name."</span></td>";
        $arr[$key]['reviews'] = "<td><span class='tbl_row_new'>0</span></td>";
        $arr[$key]['rating'] = "<td><span class='tbl_row_new'>0</span></td>";
        $arr[$key]['registered_on'] = "<td><span class='tbl_row_new'>".date("Y-m-d", strtotime($data->created_at))."</span></td>";
        if($data->status == 1){
           $view1= $view.$inactive ;
        } else {
           $view1= $view.$active ;
        }
        $arr[$key]['view'] = "<td><span class='line_heightt'>".$view1."</span></td>";
      }
     return $arr;
    }


    //******add department data
    public function AddDepartment(Request $req){
    	$data['department_name'] = $req->department_name;
    	$data['country_id'] = $req->country;
    	$data['state_id'] = $req->state;
    	$data['city_id'] = $req->city;
        if($req->departmentImage){
         $departmentImage = Storage::disk('public')->put('departname', $req->departmentImage);          
          $data['image'] = $departmentImage;
        }
        $insertData = Department::create($data);
     	return redirect('/department_management/department');
    }
    // *******view departmentprofilepage data
    public function DepartmentDetail(Request $req){
        $getDetail = Department::with('country_data')->with('state_data')->with('city_data')->whereId($req->id)->first();
        $data['data'] = $getDetail;
        return view('department_managenment.departmentProfile',$data);

    }
      // *******view as modalview in departmentprofile page of all badge data 
    public function viewDepartmentBadgeModel($id){
        $DepartmentBadgeModelData = DepartmentBadge::where('department_id',$id)->get();
        return response()->json($DepartmentBadgeModelData, 200);
    }
    // ******change department statusa as active/inacttive
    public function department_status(Request $req){
         $user_id = $req->user_id;
        $status_data = Department::where('id',$user_id)->first();
        $status = $status_data->status;
         if($status == 1){
            $user = Department::where('id', $user_id)->update(['status' => 2]);
         } else {
            $user = Department::where('id', $user_id)->update(['status' => 1]);
         }
         return redirect('/department_management/department');
    }
  

    // ****badge page
    public function badge()   
     {
        return view('department_managenment.badge');
     }
    public function badge_list(Request $request){
        $order_by = $_GET['order'][0]['dir'];
        $columnIndex = $_GET['order'][0]['column'];
        $columnName = $_GET['columns'][$columnIndex]['data'];
        $columnName =  ($columnName=='username') ? 'first_name' : 'created_at';
        $offset = $_GET['start'] ? $_GET['start'] :"0";
        $limit_t = ($_GET['length'] !='-1') ? $_GET['length'] :"";
        $draw = $_GET['draw'];
        $status_id = $_GET['status_id'];
        $state_id = $_GET['state_id'];
        $country_id = $_GET['country_id'];
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];
        $search = $_GET['search'];
        $city_id = $_GET['city_id'];
        $data = $this->badge->getdata_badge_table($order_by, $offset, $limit_t,$status_id,$state_id,$country_id,$fromdate,$todate,$search,$city_id);

        $count = $this->badge->getdata_badge_count($order_by,$status_id,$state_id,$country_id,$fromdate,$todate,$search,$city_id);
        $getuser = $this->manage_badge_data($data);
        $results = ["draw" => intval($draw),
            "iTotalRecords" => $count,
            "iTotalDisplayRecords" => $count,
            "aaData" => $getuser ];
            echo json_encode($results);

    }
    public function manage_badge_data($data){
      $arr = array();
      $i = 0;
      foreach($data as $key=>$data){
        $view = "<a href='".route('BadgeDetail',['id' => $data->id])."'><span class='tbl_row_new1 view_modd_dec'>VIEWDETAIL</span></a><br>";
        $active = "<a href='javascript:void(0)' onclick ='status(".$data->id.")'><span class='tbl_row_new1 view_modd_dec'>ACTIVATE</span></a>";
        $inactive = "<a href='javascript:void(0)' onclick = 'status(".$data->id.")'><span class='tbl_row_new1 view_modd_dec'>INACTIVATE</span></a>";


        
        $arr[$key]['badge_name'] = "<td><span class='tbl_row_new'>".$data->badge_number."</span></td>";
        $arr[$key]['department_name'] = "<td><span class='tbl_row_new'>".$data->department_data->department_name."</span></td>";
        $arr[$key]['badge_rating'] = "<td><span class='tbl_row_new'>0</span></td>";
        $arr[$key]['department_rating'] = "<td><span class='tbl_row_new'>0</span></td>";
        $arr[$key]['registered_on'] = "<td><span class='tbl_row_new'>".date("Y-m-d", strtotime($data->created_at))."</span></td>";
        if($data->status == 1){
           $view1= $view.$inactive ;
        } else {
           $view1= $view.$active ;
        }
        $arr[$key]['view'] = "<td><span class='line_heightt'>".$view1."</span></td>";
      }
     return $arr;
    }
     // ******change badge statusa as active/inacttive
    public function badge_status(Request $req){
         $user_id = $req->user_id;
        $status_data = DepartmentBadge::where('id',$user_id)->first();
        $status = $status_data->status;
         if($status == 1){
            $user = DepartmentBadge::where('id', $user_id)->update(['status' => 2]);
         } else {
            $user = DepartmentBadge::where('id', $user_id)->update(['status' => 1]);
         }
         return redirect('/department_management/badge');
    }
      // **add badge data
    public function AddBadge(Request $req){
         $data['department_id'] = $req->department_id;
         $data['badge_number'] = $req->badge_number;
         $insertBadge = DepartmentBadge::create($data);
         return redirect('/department_management/badge');
    }
    // ***badgeprofile data page
    public function BadgeDetail(Request $req){
       $getDetail = DepartmentBadge::with('department_data.country_data')->with('department_data.state_data')->with('department_data.city_data')->whereId($req->id)->first();
       $data['data'] = $getDetail;
       return view('department_managenment.badgeProfile',$data);

    }

}
