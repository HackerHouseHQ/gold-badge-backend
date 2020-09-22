<?php

namespace App\Http\Controllers;

use App\User;
use App\Department;
use App\DepartmentComment;
use App\DepartmentLike;
use App\DepartmentShare;
use App\Post;
use Illuminate\Http\Request;
use App\UserDepartmentRequest;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
  function __construct()
  {
    $this->user = new User;
    $this->UserRequest = new UserDepartmentRequest;
  }


  public function index()
  {
    return view('user_management.user');
  }
  public function user_list(Request $request)
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
    $state_id = $_GET['state_id'];
    $country_id = $_GET['country_id'];

    $fromdate = $_GET['fromdate'];
    $todate = $_GET['todate'];
    $data = $this->user->getdata_table($order_by, $offset, $limit_t, $fromdate, $todate, $status_id, $country_id, $state_id);
    $count = $this->user->getdata_count($order_by, $fromdate, $todate, $status_id, $country_id, $state_id);
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

      $view = "<a href='" . route('UserDetail', ['id' => $data->id]) . "'> <button type='button' class='btn btn-primary btn-sm'>VIEW</button></a>";
      $active = "<a style='margin-left:5px' href='javascript:void(0)' onclick ='status(" . $data->id . ")'><button type='button' class='btn btn-success btn-sm'>ACTIVATE</button></a>";
      $inactive = "<a style='margin-left:5px' href='javascript:void(0)' onclick = 'status(" . $data->id . ")'><button type='button' class='btn btn-danger btn-sm's>INACTIVATE</button></a>";




      $arr[$key]['name'] = "<td><span class='tbl_row_new'>" . $data->first_name . " " . $data->last_name . "</span></td>";
      $arr[$key]['contact'] = "<td><span class='tbl_row_new'>" . $data->mobile_country_code . "-" . $data->mobil_no . "</span></td>";
      $arr[$key]['email'] = "<td><span class='tbl_row_new'>" . $data->email . "</span></td>";
      $arr[$key]['username'] = "<td><span class='tbl_row_new'>" . $data->user_name . "</span></td>";
      $arr[$key]['registered_on'] = "<td><span class='tbl_row_new'>" . date("Y-m-d", strtotime($data->created_at)) . "</span></td>";
      $arr[$key]['review'] = "<td><span class='tbl_row_new'>" . $data->total_reviews . "</span></td>";
      // $arr[$key]['view'] = '<a href="#"><span class="line_heightt">view Detailes/<br>Inactive</a>';
      // $arr[$key]['view'] = $view;
      if ($data->status == 1) {
        $view1 = $view . $inactive;
      } else {
        $view1 = $view . $active;
      }
      $arr[$key]['view'] = "<td><span class='line_heightt'>" . $view1 . "</span></td>";
    }
    return $arr;
  }
  public function viewUserDetailModel(Request $req)
  {
    $data = Post::with('users')->with('departments')->where('id', $req->id)->first();
    $likeCount =  DepartmentLike::where('post_id', $data->id)->where('user_id', $data->user_id)->count();
    $shareCount = DepartmentShare::where('post_id', $data->id)->where('user_id', $data->user_id)->count();
    $commentCount  = DepartmentComment::where('post_id', $data->id)->where('user_id', $data->user_id)->count();
    $data['department_like'] = $likeCount;
    $data['department_share'] = $shareCount;
    $data['department_comment'] = $commentCount;
    return $data;
  }
  public function delete_post(Request $request)
  {
    $deletePost = Post::where('id', $request->post_id)->delete();
    return $deletePost;
  }
  public function userReviewList(Request $req)
  {
    $order_by = $_GET['order'][0]['dir'];
    $columnIndex = $_GET['order'][0]['column'];
    $columnName = $_GET['columns'][$columnIndex]['data'];
    $columnName =  ($columnName == 'username') ? 'first_name' : 'created_at';
    $offset = $_GET['start'] ? $_GET['start'] : "0";
    $limit_t = ($_GET['length'] != '-1') ? $_GET['length'] : "";
    $draw = $_GET['draw'];

    $data = $this->user->getdepdata_table($order_by, $offset, $limit_t);
    //dd($data);
    $count = $this->user->getdepdata_count($order_by);
    $getuser = $this->manage_review_data($data);
    $results = [
      "draw" => intval($draw),
      "iTotalRecords" => $count,
      "iTotalDisplayRecords" => $count,
      "aaData" => $getuser
    ];
    echo json_encode($results);
  }
  public function manage_review_data($data)
  {
    $arr = array();
    $i = 0;
    foreach ($data as $key => $data) {
      $view = "<a href='" . route('UserDetail', ['id' => $data->id]) . "'><span class='tbl_row_new1 view_modd_dec'>VIEWDETAIL</span></a><br>";
      $active = "<a href='javascript:void(0)' onclick ='status(" . $data->id . ")'><span class='tbl_row_new1 view_modd_dec'>ACTIVATE</span></a>";
      $inactive = "<a href='javascript:void(0)' onclick = 'status(" . $data->id . ")'><span class='tbl_row_new1 view_modd_dec'>INACTIVATE</span></a>";


      $arr[$key]['departmentName'] = "<td><span class='tbl_row_new'>" . $data->department_name . "</span></td>";
      $arr[$key]['BadgeNumber'] = "<td><span class='tbl_row_new'>" . $data->department_name . "</span></td>";
      $arr[$key]['rating'] = "<td><span class='tbl_row_new'>" . $data->department_name . "</span></td>";
      $arr[$key]['like'] = "<td><span class='tbl_row_new'>0</span></td>";
      $arr[$key]['share'] = "<td><span class='tbl_row_new'>0</span></td>";
      $arr[$key]['comment'] = "<td><span class='tbl_row_new'>0</span></td>";
      $arr[$key]['report'] = "<td><span class='tbl_row_new'>0</span></td>";
      // $arr[$key]['view'] = '<a href="#"><span class="line_heightt">view Detailes/<br>Inactive</a>';
      // $arr[$key]['view'] = $view;
      if ($data->status == 1) {
        $view1 = $view . $inactive;
      } else {
        $view1 = $view . $active;
      }
      $arr[$key]['action'] = "<td><span class='line_heightt'>" . $view1 . "</span></td>";
    }
    return $arr;
  }
  public function change_status(Request $req)
  {
    $user_id = $req->user_id;
    $status_data = User::where('id', $user_id)->first();
    $status = $status_data->status;
    if ($status == 1) {
      $user = User::where('id', $user_id)->update(['status' => 2]);
    } else {
      $user = User::where('id', $user_id)->update(['status' => 1]);
    }
    return redirect('/user_management/user');
  }
  public function UserDetailData(Request $req)
  {
    $order_by = $_GET['order'][0]['dir'];
    $columnIndex = $_GET['order'][0]['column'];
    $columnName = $_GET['columns'][$columnIndex]['data'];
    $columnName = ($columnName == 'username') ? 'first_name' : 'created_at';
    $offset = $_GET['start'] ? $_GET['start'] : "0";
    $limit_t = ($_GET['length'] != '-1') ? $_GET['length'] : "";
    $draw = $_GET['draw'];
    $user_id = $_GET['user_id'];
    // $search = $_GET['search'];
    // $type = $_GET['type'];
    $data = User::getPost($user_id, $offset, $limit_t);

    $count = User::getPostCount($user_id);
    $arr = array();
    foreach ($data as $key => $data) {
      $view = "<a href='javascript:void(0)' onclick ='viewUserDetailModel(" . $data->post_id . ")'><button type='button' class='btn btn-success btn-sm'>VIEW POST</button></a>";
      $active = "<a style='margin-left: 5px;' href='javascript:void(0)' onclick ='status(" . $data->post_id . ")'><button type='button' class='btn btn-danger btn-sm'>Delete</button></a>";
      $arr[$key]['department_name'] = "<td><span class='tbl_row_new'>" . $data->department_name . "</span></td>";
      $arr[$key]['badge_number'] = "<td><span class='tbl_row_new'>" . $data->badge_number . "</span></td>";
      $arr[$key]['rating'] = "<td><span class='tbl_row_new'>" . $data->rating . "</span></td>";
      $arr[$key]['date'] = "<td><span class='tbl_row_new'>" . date("d/m/y", strtotime($data->created_at)) . "</span></td>";
      $arr[$key]['likes'] = "<td><span class='tbl_row_new'>" . $data->department_like . "</span></td>";
      $arr[$key]['share'] = "<td><span class='tbl_row_new'>" . $data->department_share . "</span></td>";
      $arr[$key]['comment'] = "<td><span class='tbl_row_new'>" . $data->department_comment  . "</span></td>";
      $arr[$key]['report'] = "<td><span class='tbl_row_new'>" . $data->department_report  . "</span></td>";
      $view1 = $view . $active;
      $arr[$key]['action'] = "<td><span class='line_heightt'>" . $view1 . "</span></td>";
    }
    $results = [
      "draw" => intval($draw),
      "iTotalRecords" => $count,
      "iTotalDisplayRecords" => $count,
      "aaData" => $arr
    ];
    echo json_encode($results);
  }
  public function UserDetail(Request $req)
  {
    // echo"<pre>"; print_r($req->all()); die;
    $data['data'] = User::where('id', $req->id)->first();
    return view('user_management.UserDetail', $data);
  }
  public function UserDetailFollowingData(Request $req)
  {
    $order_by = $_GET['order'][0]['dir'];
    $columnIndex = $_GET['order'][0]['column'];
    $columnName = $_GET['columns'][$columnIndex]['data'];
    $columnName = ($columnName == 'username') ? 'first_name' : 'created_at';
    $offset = $_GET['start'] ? $_GET['start'] : "0";
    $limit_t = ($_GET['length'] != '-1') ? $_GET['length'] : "";
    $draw = $_GET['draw'];
    $user_id = $_GET['user_id'];
    $search_arr = $req->get('search');
    $search = $search_arr['value'];
    // $type = $_GET['type'];
    $data = User::getPostDepartmentFollowing($user_id, $search, $offset, $limit_t);
    $count = User::getPostDepartmentFollowingCount($user_id, $search);
    $arr = array();
    foreach ($data as $key => $data) {
      $view = "<a href='javascript:void(0)' onclick ='viewUserDetailModel(" . $data->post_id . ")'><button type='button' class='btn btn-success btn-sm'>VIEW POST</button></a>";
      $active = "<a style='margin-left:5px;' href='javascript:void(0)' onclick ='status(" . $data->post_id . ")'><button type='button' class='btn btn-danger btn-sm'>Delete</button></a>";
      $arr[$key]['department_name'] = "<td><span class='tbl_row_new'>" . $data->department_name . "</span></td>";
      $arr[$key]['reviews'] = "<td><span class='tbl_row_new'>" . "0" . "</span></td>";
      $arr[$key]['rating'] = "<td><span class='tbl_row_new'>" . $data->rating . "</span></td>";
      $view1 = $view . $active;
      $arr[$key]['action'] = "<td><span class='line_heightt'>" . $view1 . "</span></td>";
    }
    $results = [
      "draw" => intval($draw),
      "iTotalRecords" => $count,
      "iTotalDisplayRecords" => $count,
      "aaData" => $arr
    ];
    echo json_encode($results);
  }
  public function UserDetailFollowing(Request $req)
  {
    // echo"<pre>"; print_r($req->all()); die;
    $data['data'] = User::where('id', $req->id)->first();
    return view('user_management.UserDetailFollowing', $data);
  }
  public function UserDetailFollowingBadge(Request $req)
  {
    // echo"<pre>"; print_r($req->all()); die;
    $data['data'] = User::where('id', $req->id)->first();
    return view('user_management.UserDetailFollowingBadge', $data);
  }
  public function UserDetailFollowingBadgeData(Request $req)
  {
    $order_by = $_GET['order'][0]['dir'];
    $columnIndex = $_GET['order'][0]['column'];
    $columnName = $_GET['columns'][$columnIndex]['data'];
    $columnName = ($columnName == 'username') ? 'first_name' : 'created_at';
    $offset = $_GET['start'] ? $_GET['start'] : "0";
    $limit_t = ($_GET['length'] != '-1') ? $_GET['length'] : "";
    $draw = $_GET['draw'];
    $user_id = $_GET['user_id'];
    $search_arr = $req->get('search');
    $search = $search_arr['value'];

    // $type = $_GET['type'];
    $data = User::getPostBadge($user_id, $search, $offset, $limit_t);
    $count = User::getPostBadgeCount($user_id, $search);
    $arr = array();
    foreach ($data as $key => $data) {
      $view = "<a href='javascript:void(0)' onclick ='viewUserDetailModel(" . $data->post_id . ")'><button type='button' class='btn btn-success btn-sm'>VIEW POST</button></a>";
      $active = "<a style='margin-left:5px' href='javascript:void(0)'  onclick ='status(" . $data->post_id . ")'><button type='button' class='btn btn-success btn-sm'>Delete</button></a>";
      $arr[$key]['badge_number'] = "<td><span class='tbl_row_new'>" . $data->badge_number . "</span></td>";
      $arr[$key]['department_name'] = "<td><span class='tbl_row_new'>" . $data->department_name . "</span></td>";
      $arr[$key]['reviews'] = "<td><span class='tbl_row_new'>" . "0" . "</span></td>";
      $arr[$key]['rating'] = "<td><span class='tbl_row_new'>" . $data->rating . "</span></td>";
      $view1 = $view . $active;

      $arr[$key]['action'] = "<td><span class='line_heightt'>" . $view1 . "</span></td>";
    }
    $results = [
      "draw" => intval($draw),
      "iTotalRecords" => $count,
      "iTotalDisplayRecords" => $count,
      "aaData" => $arr
    ];
    echo json_encode($results);
  }
  public function departmentRequest()
  {
    return view('user_management.deprtmentRequest');
  }
  public function deprtmentPendingRequest()
  {
    return view('user_management.deprtmentPendingRequest');
  }
  public function deprtmentRejectRequest()
  {
    return view('user_management.deprtmentRejectRequest');
  }
  public function acceptDepartmentRequest(Request $request)
  {
    $deprtmentRequestId = $request->departId;
    //print_r($deprtmentRequestId);die;
    // $status_data = UserDepartmentRequest::where('id',$deprtmentRequestId)->first();
    // $status = $status_data->status;
    $user = UserDepartmentRequest::where('id', $deprtmentRequestId)->update(['status' => $request->status]);
    $requestData = UserDepartmentRequest::where('id', $deprtmentRequestId)->first();
    //print_r($requestData);die;
    if ($request->status == 1) {
      if ($user) {
        $data['department_name'] = $requestData->department_name;
        $data['country_id'] = $requestData->country_id;
        $data['state_id'] = $requestData->state_id;
        $data['city_id'] = $requestData->city_id;
        if ($request->departmentImage) {
          $departmentImage = Storage::disk('public')->put('departname', $request->departmentImage);
          $data['image'] = $departmentImage;
        }
        $insertData = Department::create($data);
        return redirect('/user_management/departmentRequest');
      }
    } else {
      return redirect('/user_management/deprtmentRejectRequest');
    }
    // if($status == 1){
    // $user = Department::where('id', $user_id)->update(['status' => 2]);
    // } else {
    // $user = Department::where('id', $user_id)->update(['status' => 1]);
    // }
  }

  public function UserRequestData(Request $request)
  {
    // echo"<pre>"; print_r($request->all()); die;
    $order_by = $_GET['order'][0]['dir'];
    $columnIndex = $_GET['order'][0]['column'];
    $columnName = $_GET['columns'][$columnIndex]['data'];
    $columnName = ($columnName == 'username') ? 'first_name' : 'created_at';
    $offset = $_GET['start'] ? $_GET['start'] : "0";
    $limit_t = ($_GET['length'] != '-1') ? $_GET['length'] : "";
    $draw = $_GET['draw'];
    $type = $_GET['type'];
    $search_arr = $request->get('search');
    $search = $search_arr['value'];
    $fromdate = (@$_GET['fromdate']) ? date('Y-m-d H:i:s', strtotime($_GET['fromdate'] . ' 00:00:00')) : '';
    $todate = (@$_GET['todate']) ? date('Y-m-d H:i:s', strtotime($_GET['todate'] . ' 00:00:00')) : '';
    /// $from = date('Y-m-d H:i:s' , strtotime($fromdate));
    //$to = date('Y-m-d H:i:s', strtotime($todate));
    // echo $to; die;
    $data = $this->UserRequest->getdata_table($order_by, $offset, $limit_t, $type, $search, $fromdate, $todate);
    // print_r($data); die;
    $count = $this->UserRequest->getdata_count($order_by, $type, $search);
    $getuser = $this->manage_request_data($data, $type);

    $results = [
      "draw" => intval($draw),
      "iTotalRecords" => $count,
      "iTotalDisplayRecords" => $count,
      "aaData" => $getuser
    ];
    echo json_encode($results);
  }
  public function manage_request_data($data, $type)
  {
    $arr = array();
    $i = 0;
    // if(!empty($data)){
    foreach ($data as $key => $data) {

      // $view = "<a href='".route('UserDetail',['id' => $data->id])."'><span class='tbl_row_new1 view_modd_dec'>VIEWDETAIL</span></a><br>";
      // $active = "<a href='javascript:void(0)' onclick ='status(".$data->id.")'><span class='tbl_row_new1 view_modd_dec'>ACTIVATE</span></a>";
      // $inactive = "<a href='javascript:void(0)' onclick = 'status(".$data->id.")'><span class='tbl_row_new1 view_modd_dec'>INACTIVATE</span></a>";
      if ($type == 0) {
        $accept = "<a href='javascript:void(0)' onclick ='status(" . $data->id . ',' . 1 . ")'><button type='button' class='btn btn-success btn-sm'>ACCEPT</button></a>";
        $reject = "<a style='margin-left:5px;' href='javascript:void(0)' onclick ='status(" . $data->id . ',' . 2 . ")'><button type='button' class='btn btn-danger btn-sm'>REJECT</button></a>";
        $arr[$key]['action'] = $accept . $reject;
      }
      $arr[$key]['d_name'] = "<td><span class='tbl_row_new'>" . $data->department_name . "</span></td>";
      $arr[$key]['country'] = "<td><span class='tbl_row_new'>" . $data->country->country_name . "</span></td>";
      $arr[$key]['state'] = "<td><span class='tbl_row_new'>" . $data->state->state_name . "</span></td>";
      $arr[$key]['city'] = "<td><span class='tbl_row_new'>" . @$data->city->city_name . "</span></td>";
      $arr[$key]['username'] = "<td><span class='tbl_row_new'>" . $data->userInfo->user_name . "</span></td>";
      $arr[$key]['reg_date'] = "<td><span class='tbl_row_new'>" . date("Y-m-d", strtotime($data->userInfo->created_at)) . "</span></td>";
      $arr[$key]['u_name'] = "<td><span class='tbl_row_new'>" . $data->userInfo->first_name . ' ' . $data->userInfo->last_name . "</span></td>";
      $arr[$key]['email'] = "<td><span class='tbl_row_new'>" . $data->userInfo->email . "</span></td>";
      $arr[$key]['contact'] = "<td><span class='tbl_row_new'>" . $data->userInfo->mobil_no . "</span></td>";

      // $arr[$key]['contact'] = "<td><span class='tbl_row_new'>".$data->mobile_country_code."-".$data->mobil_no."</span></td>";
      // $arr[$key]['email'] = "<td><span class='tbl_row_new'>".$data->email."</span></td>";
      // $arr[$key]['username'] = "<td><span class='tbl_row_new'>".$data->user_name."</span></td>";
      // $arr[$key]['reg_date'] = "<td><span class='tbl_row_new'>".date("Y-m-d", strtotime($data->created_at))."</span></td>";
      // $arr[$key]['view'] = "<td><span class='tbl_row_new'>0</span></td>";
      // $arr[$key]['view'] = '<a href="#"><span class="line_heightt">view Detailes/<br>Inactive</a>';
      // $arr[$key]['view'] = $view;
      // if($data->status == 1){
      // $view1= $view.$inactive ;
      // } else {
      // $view1= $view.$active ;
      // }
      // $arr[$key]['view'] = "<td><span class='line_heightt'>".$view1."</span></td>";
      // }

    }
    return $arr;
  }
}
