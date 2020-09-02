<?php

namespace App\Http\Controllers;

use Auth;

use Session;
use Storage;
use App\Post;
use App\User;
use Validator;


use App\Department;
use App\DepartmentBadge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

   function __construct()
   {    
      $this->user = new Department;
      $this->badge = new DepartmentBadge;
      
      $this->postTable = new Post;
      
   }

   public function department()
   {
      return view('department_managenment.deprtment');
   }
   public function department_new_request(Request $request)
   {
   }
   public function posts(Request $request)
   {
   //  echo "aWSA"; die;
      return view('post.post');
   }
   public function post_list(Request $request)
   {
      // echo"<pre>"; print_r($request->all()); die;
      $order_by = $_GET['order'][0]['dir'];
      $columnIndex = $_GET['order'][0]['column'];
      $columnName = $_GET['columns'][$columnIndex]['data'];
      $columnName =  ($columnName == 'username') ? 'first_name' : 'created_at';
      $offset = $_GET['start'] ? $_GET['start'] : "0";
      $limit_t = ($_GET['length'] != '-1') ? $_GET['length'] : "";
      $draw = $_GET['draw'];
      $status_id = $_GET['status_id'];
      $department_id = $_GET['department_id'];
      $badge_id = $_GET['badge_id'];
      $city_id = $_GET['city_id'];

      $state_id = $_GET['state_id'];
      $country_id = $_GET['country_id'];
      $fromdate = $_GET['fromdate'];
      $todate = $_GET['todate'];
      $search = $_GET['search'];
      $data = $this->postTable->getdata_table($order_by, $offset, $limit_t, $status_id, $state_id, $country_id, $fromdate, $todate, $search, $department_id, $badge_id, $city_id);
      $count = $this->postTable->getdata_count($order_by, $offset, $limit_t, $status_id, $state_id, $country_id, $fromdate, $todate, $search, $department_id, $badge_id);
      $getuser = $this->manage_data($data);
      $results = [
         "draw" => intval($draw),
         "iTotalRecords" => $count,
         "iTotalDisplayRecords" => $count,
         "aaData" => $getuser
      ];
      echo json_encode($results);
   }
   public function manage_data($data)
   {
      $arr = array();
      $i = 0;
      foreach ($data as $key => $data) {
         $view = "<a href='" . route('postViewDetail', ['user_id' => $data->user_id]) . "'><span class='tbl_row_new1 view_modd_dec'>VIEWDETAIL</span></a><br>";
         $active = "<a href='javascript:void(0)' onclick ='status(" . $data->id . ")'><span class='tbl_row_new1 view_modd_dec'>Delete</span></a>";
         // $inactive = "<a href='javascript:void(0)' onclick = 'status(" . $data->id . ")'><span class='tbl_row_new1 view_modd_dec'>INACTIVATE</span></a>";

         $flag = ($data->flag == 1) ? 'department' : 'badges';
         $arr[$key]['userName'] = "<td><span class='tbl_row_new'>" . $data->users->user_name . "</span></td>";
         $arr[$key]['fullName'] = "<td><span class='tbl_row_new'>" . $data->users->first_name . " " . $data->users->last_name . "</span></td>";
         $arr[$key]['postedAbout'] = "<td><span class='tbl_row_new'>" . $flag . "</span></td>";
         $arr[$key]['postedOn'] = "<td><span class='tbl_row_new'>" . date("Y-m-d", strtotime($data->created_at)) . "</span></td>";
         $arr[$key]['rating'] = "<td><span class='tbl_row_new'>" . $data->rating . "</span></td>";

         $view1 = $view . $active;

         $arr[$key]['action'] = "<td><span class='line_heightt'>" . $view1 . "</span></td>";
      }
      return $arr;
   }


   //******add department data
   public function AddDepartment(Request $req)
   {
      $data['department_name'] = $req->department_name;
      $data['country_id'] = $req->country;
      $data['state_id'] = $req->state;
      $data['city_id'] = $req->city;
      if ($req->departmentImage) {
         $departmentImage = Storage::disk('public')->put('departname', $req->departmentImage);
         $data['image'] = $departmentImage;
      }
      $insertData = Department::create($data);
      return redirect('/department_management/department');
   }
   // *******view departmentprofilepage data
   public function DepartmentDetail(Request $req)
   {
      $getDetail = Department::with('country_data')->with('state_data')->with('city_data')->whereId($req->id)->first();
      $data['data'] = $getDetail;
      return view('department_managenment.departmentProfile', $data);
   }
   // *******view as modalview in departmentprofile page of all badge data 
   public function viewDepartmentBadgeModel($id)
   {
      $DepartmentBadgeModelData = DepartmentBadge::where('department_id', $id)->get();
      return response()->json($DepartmentBadgeModelData, 200);
   }
   // ******change department statusa as active/inacttive
   public function department_status(Request $req)
   {
      $user_id = $req->user_id;
      $status_data = Department::where('id', $user_id)->first();
      $status = $status_data->status;
      if ($status == 1) {
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
   public function badge_list(Request $request)
   {
      $order_by = $_GET['order'][0]['dir'];
      $columnIndex = $_GET['order'][0]['column'];
      $columnName = $_GET['columns'][$columnIndex]['data'];
      $columnName =  ($columnName == 'username') ? 'first_name' : 'created_at';
      $offset = $_GET['start'] ? $_GET['start'] : "0";
      $limit_t = ($_GET['length'] != '-1') ? $_GET['length'] : "";
      $draw = $_GET['draw'];
      $status_id = $_GET['status_id'];
      $state_id = $_GET['state_id'];
      $country_id = $_GET['country_id'];
      $fromdate = $_GET['fromdate'];
      $todate = $_GET['todate'];
      $search = $_GET['search'];
      $city_id = $_GET['city_id'];
      $data = $this->badge->getdata_badge_table($order_by, $offset, $limit_t, $status_id, $state_id, $country_id, $fromdate, $todate, $search, $city_id);

      $count = $this->badge->getdata_badge_count($order_by, $status_id, $state_id, $country_id, $fromdate, $todate, $search, $city_id);
      $getuser = $this->manage_badge_data($data);
      $results = [
         "draw" => intval($draw),
         "iTotalRecords" => $count,
         "iTotalDisplayRecords" => $count,
         "aaData" => $getuser
      ];
      echo json_encode($results);
   }
   public function manage_badge_data($data)
   {
      $arr = array();
      $i = 0;
      foreach ($data as $key => $data) {
         $view = "<a href='" . route('BadgeDetail', ['id' => $data->id]) . "'><span class='tbl_row_new1 view_modd_dec'>VIEWDETAIL</span></a><br>";
         $active = "<a href='javascript:void(0)' onclick ='status(" . $data->id . ")'><span class='tbl_row_new1 view_modd_dec'>ACTIVATE</span></a>";
         $inactive = "<a href='javascript:void(0)' onclick = 'status(" . $data->id . ")'><span class='tbl_row_new1 view_modd_dec'>INACTIVATE</span></a>";



         $arr[$key]['badge_name'] = "<td><span class='tbl_row_new'>" . $data->badge_number . "</span></td>";
         $arr[$key]['department_name'] = "<td><span class='tbl_row_new'>" . $data->department_data->department_name . "</span></td>";
         $arr[$key]['badge_rating'] = "<td><span class='tbl_row_new'>0</span></td>";
         $arr[$key]['department_rating'] = "<td><span class='tbl_row_new'>0</span></td>";
         $arr[$key]['registered_on'] = "<td><span class='tbl_row_new'>" . date("Y-m-d", strtotime($data->created_at)) . "</span></td>";
         if ($data->status == 1) {
            $view1 = $view . $inactive;
         } else {
            $view1 = $view . $active;
         }
         $arr[$key]['view'] = "<td><span class='line_heightt'>" . $view1 . "</span></td>";
      }
      return $arr;
   }
   // ******change badge statusa as active/inacttive
   public function badge_status(Request $req)
   {
      $user_id = $req->user_id;
      $status_data = DepartmentBadge::where('id', $user_id)->first();
      $status = $status_data->status;
      if ($status == 1) {
         $user = DepartmentBadge::where('id', $user_id)->update(['status' => 2]);
      } else {
         $user = DepartmentBadge::where('id', $user_id)->update(['status' => 1]);
      }
      return redirect('/department_management/badge');
   }
   // **add badge data
   public function AddBadge(Request $req)
   {
      $data['department_id'] = $req->department_id;
      $data['badge_number'] = $req->badge_number;
      $insertBadge = DepartmentBadge::create($data);
      return redirect('/department_management/badge');
   }
   // ***badgeprofile data page
   public function BadgeDetail(Request $req)
   {
      $getDetail = DepartmentBadge::with('department_data.country_data')->with('department_data.state_data')->with('department_data.city_data')->whereId($req->id)->first();
      $data['data'] = $getDetail;
      return view('department_managenment.badgeProfile', $data);
   }
   public function postViewDetail(Request $request)
   {
      $user = User::select('id', 'first_name', 'last_name', 'user_name', 'email', 'mobil_no', 'dob', 'gender', 'ethnicity', 'image')->where('id', $request->user_id)->first();

      return view('post.post-detail', ['data' => $user]);
   }
   public function PostDepartmentDetail(Request $request)
   {
      // echo"<pre>"; print_r($request->all()); die;
      $order_by = $_GET['order'][0]['dir'];
      $columnIndex = $_GET['order'][0]['column'];
      $columnName = $_GET['columns'][$columnIndex]['data'];
      $columnName =  ($columnName == 'username') ? 'first_name' : 'created_at';
      $offset = $_GET['start'] ? $_GET['start'] : "0";
      $limit_t = ($_GET['length'] != '-1') ? $_GET['length'] : "";
      $draw = $_GET['draw'];
      // $status_id = $_GET['status_id'];
      $department_id = $_GET['department_id'];
      $user_id = $_GET['user_id'];
      $badge_id = $_GET['badge_id'];
      // $city_id = $_GET['city_id'];

      // $state_id = $_GET['state_id'];
      // $country_id = $_GET['country_id'];
      $fromdate = $_GET['fromdate'];
      $todate = $_GET['todate'];
      $search = $_GET['search'];
      $data = Post::getPost($search, $department_id,  $badge_id, $fromdate, $todate, $order_by, $limit_t, $offset, $user_id);
      $count  = 3;
      $getuser = $this->manage_post_view($data);
      $results = [
         "draw" => intval($draw),
         "iTotalRecords" => $count,
         "iTotalDisplayRecords" => $count,
         "aaData" => $getuser
      ];
      echo json_encode($results);
   }
   public function manage_post_view($postData)
   {
      $arr = array();
      $i = 0;
      foreach ($postData as $key => $data) {
         $active = "<button  class='btn btn-danger' onclick ='status(" . $data->post_id . ")'><span style='color:#fff' class='tbl_row_new1 view_modd_dec'>Delete1</span></button>";
         $data1 = "Posted On:- $data->created_at </br>  Likes:- 0 </br> Share:- 0 </br> Report:- 0 </br>Rating:- $data->rating </br> Cpmments:- 0 </br> Review:- Test";
         $flag = ($data->flag == 1) ? 'department' : 'badges';
         $arr[$key]['image'] = "<td><img class='profile-user-img img-fluid img-circle'
         src='$data->image' alt='User profile picture'></td>";
         $arr[$key]['userName'] = "<td><span class='tbl_row_new'>" . $data1 . "</span></br></td>";
         $view1 =  $active;
         $arr[$key]['action'] = "<td><span class='tbl_row_new'>" . $view1 . "</span></td>";
      }
      return $arr;
   }
   public function delete_post(Request $request)
   {
      $deletePost = Post::where('id', $request->post_id)->delete();
      return $deletePost;
   }
}
