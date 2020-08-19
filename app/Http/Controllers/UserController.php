<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;




class UserController extends Controller
{

	   function __construct()
        {
            $this->user = new User;
        }


  public function index()
    {
        return view('user_management.user');
    }
    public function user_list(Request $request){
    	   // echo"<pre>"; print_r($request->all()); die;
        $order_by = $_GET['order'][0]['dir'];
        $columnIndex = $_GET['order'][0]['column'];
        $columnName = $_GET['columns'][$columnIndex]['data'];
        $columnName =  ($columnName=='username') ? 'first_name' : 'created_at';
        $offset = $_GET['start'] ? $_GET['start'] :"0";
        $limit_t = ($_GET['length'] !='-1') ? $_GET['length'] :"";
        $draw = $_GET['draw'];
        $search= $request->role;
        $data = $this->user->getdata_table($order_by, $offset, $limit_t);
        $count = $this->user->getdata_count($order_by);
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
          	$view = "<a href='".route('UserDetail',['id' => $data->id])."'><span class='tbl_row_new1 view_modd_dec'>VIEWDETAIL</span></a><br>";
            $active = "<a href='javascript:void(0)' onclick ='status(".$data->id.")'><span class='tbl_row_new1 view_modd_dec'>ACTIVATE</span></a>";
            $inactive = "<a href='javascript:void(0)' onclick = 'status(".$data->id.")'><span class='tbl_row_new1 view_modd_dec'>INACTIVATE</span></a>";


            $arr[$key]['name'] = "<td><span class='tbl_row_new'>".$data->first_name." ".$data->last_name."</span></td>";
            $arr[$key]['contact'] = "<td><span class='tbl_row_new'>".$data->mobile_country_code."-".$data->mobil_no."</span></td>";
            $arr[$key]['email'] = "<td><span class='tbl_row_new'>".$data->email."</span></td>";
            $arr[$key]['username'] = "<td><span class='tbl_row_new'>".$data->user_name."</span></td>";
            $arr[$key]['registered_on'] = "<td><span class='tbl_row_new'>".date("Y-m-d", strtotime($data->created_at))."</span></td>";
            $arr[$key]['review'] = "<td><span class='tbl_row_new'>20</span></td>";
             // $arr[$key]['view'] = '<a href="#"><span class="line_heightt">view Detailes/<br>Inactive</a>';
            // $arr[$key]['view'] = $view;
	        if($data->status == 1){
               $view1= $view.$inactive ;
            } else {
               $view1= $view.$active ;
            }
            $arr[$key]['view'] = "<td><span class='line_heightt'>".$view1."</span></td>";
          }
         return $arr;
    }
    public function change_status(Request $req){
        $user_id = $req->user_id;
        $status_data = User::where('id',$user_id)->first();
        $status = $status_data->status;
         if($status == 1){
            $user = User::where('id', $user_id)->update(['status' => 2]);
         } else {
            $user = User::where('id', $user_id)->update(['status' => 1]);
         }
         return redirect('/user_management/user');
    }
    public function UserDetail(Request $req){
    	// echo"<pre>"; print_r($req->all()); die;
    	$data['data'] = User::where('id',$req->id)->first();
    	return view('user_management.UserDetail',$data);

    }

}
