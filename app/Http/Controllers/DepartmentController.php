<?php

namespace App\Http\Controllers;;

use Illuminate\Http\Request;

use DB;
use Storage;
use Auth;
use Session;
use Validator;
use Importer;


use App\Department;
use App\DepartmentBadge;
use App\Exports\DepartmentExport;
use Maatwebsite\Excel\Facades\Excel;

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
   public function department_list(Request $request)
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
      $search_arr = $request->get('search');
      $search = $search_arr['value'];

      $data = $this->user->getdata_table($order_by, $offset, $limit_t, $status_id, $state_id, $country_id, $fromdate, $todate, $search);
      $count = $this->user->getdata_count($order_by, $status_id, $state_id, $country_id, $fromdate, $todate, $search);
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
         $view = "<a href='" . route('DepartmentDetail', ['id' => $data->id]) . "'> <button type='button' class='btn btn-primary btn-sm'>VIEWDETAIL</button></a>";
         $active = "<a style='margin-left:5px;' href='javascript:void(0)' onclick ='status(" . $data->id . ")'><button type='button' class='btn btn-success btn-sm'>ACTIVATE</button></a>";
         $inactive = "<a style='margin-left:5px;' href='javascript:void(0)' onclick = 'status(" . $data->id . ")'><button type='button' class='btn btn-danger btn-sm's>INACTIVATE</button></a>";


         $arr[$key]['name'] = "<td><span class='tbl_row_new'>" . $data->department_name . "</span></td>";
         $arr[$key]['reviews'] = "<td><span class='tbl_row_new'>0</span></td>";
         $arr[$key]['rating'] = "<td><span class='tbl_row_new'>0</span></td>";
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


   //******add department data
   public function AddDepartment(Request $request)
   {
      if (!empty($request->department_file)) {
         $request->validate([
            'department_file' => 'required|mimes:csv,txt',
            'country' => 'required',
            'state'  => 'required',
            'city'   => 'required',
            'departmentImage' => 'image|mimes:jpeg,png,jpg|max:2048|nullable',

         ], [
            'mimes' => 'The file type must be in a csv format',
            'country.required' => 'Please select country.',
            'state.required'  => 'Please select state.',
            'city.required' => 'Please select city.'
         ]);
         $path = $request->file('department_file')->getRealPath();
         //  echo "<pre>"; print_r($request->state_file); die;

         $data1 =  Importer::make('Csv')->load($path)->getCollection();
         $datacount = count($data1);
         for ($i = 1; $i < $datacount; $i++) {
            // echo"<pre>"; print_r($data[$i][0]); 
            $data['department_name'] = $data1[$i][0];;
            $data['country_id'] = $request->country;
            $data['state_id'] = $request->state;
            $data['city_id'] = $request->city;
            if ($request->departmentImage) {
               $departmentImage = Storage::disk('public')->put('departname', $request->departmentImage);
               $data['image'] = $departmentImage;
            }
            $insertReason = Department::create($data);
         }
         return redirect('/department_management/department');
         // die;
      } else {
         $request->validate([
            'department_name' => 'required',
            'country' => 'required',
            'state'  => 'required',
            'city'   => 'required',
            'departmentImage' => 'image|mimes:jpeg,png,jpg|max:2048|nullable'
         ], [
            'country.required' => 'Please select country.',
            'state.required'  => 'Please select state.',
            'city.required' => 'Please select city.'
         ]);
         $data['department_name'] = $request->department_name;
         $data['country_id'] = $request->country;
         $data['state_id'] = $request->state;
         $data['city_id'] = $request->city;
         if ($request->departmentImage) {
            $departmentImage = Storage::disk('public')->put('departname', $request->departmentImage);
            $data['image'] = $departmentImage;
         }
         $insertData = Department::create($data);
         return redirect('/department_management/department');
      }
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
   public function department_profile_list(Request $request)
   {
      $order_by = $_GET['order'][0]['dir'];
      $columnIndex = $_GET['order'][0]['column'];
      $columnName = $_GET['columns'][$columnIndex]['data'];
      $columnName =  ($columnName == 'username') ? 'first_name' : 'created_at';
      $offset = $_GET['start'] ? $_GET['start'] : "0";
      $limit_t = ($_GET['length'] != '-1') ? $_GET['length'] : "";
      $draw = $_GET['draw'];
      //        $status_id = $_GET['status_id'];
      //        $state_id = $_GET['state_id'];
      //        $country_id = $_GET['country_id'];
      //        $fromdate = $_GET['fromdate'];
      //        $todate = $_GET['todate'];
      //        $search = $_GET['search'];
      //        $city_id = $_GET['city_id'];
      //  $data = $this->badge->getdata_badge_table($order_by, $offset, $limit_t,$status_id,$state_id,$country_id,$fromdate,$todate,$search,$city_id);

      //$count = $this->badge->getdata_badge_count($order_by,$status_id,$state_id,$country_id,$fromdate,$todate,$search,$city_id);
      $data = array(1, 2, 3);
      $count = 1;
      $getuser = $this->pro_data($data);
      $results = [
         "draw" => intval($draw),
         "iTotalRecords" => $count,
         "iTotalDisplayRecords" => $count,
         "aaData" => $getuser
      ];
      echo json_encode($results);
   }
   public function pro_data($data)
   {
      $arr = array();
      $i = 0;

      foreach ($data as $key => $data) {
         $arr[$key]['rating'] = "<td><span class='tbl_row_new'><span style='display: flex;'>5  <i class='fas fa-star custom_star_iconn' style='margin:3px;'></i></span></span></td>";
         $arr[$key]['reviews'] = "<td><span class='tbl_row_new' style='line-height:50px;display: block;'>test hjgdfjgsdhh huddhfjuhjdsh usddhsh  </span> <span style='    display: flex;
    justify-content: space-between;'><span>view post</span> <span>     John | 18 sept,20202</span></span></td>";
      }
      return $arr;
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
      $search_arr = $request->get('search');
      $search = $search_arr['value'];
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
         $view = "<a href='" . route('BadgeDetail', ['id' => $data->id]) . "'><button type='button' class='btn btn-primary btn-sm'>VIEWDETAIL</button></a>";
         $active = "<a style='margin-left:5px' href='javascript:void(0)' onclick ='status(" . $data->id . ")'><button type='button' class='btn btn-success btn-sm'>ACTIVATE</button></a>";
         $inactive = "<a style='margin-left:5px'  href='javascript:void(0)' onclick = 'status(" . $data->id . ")'><button type='button' class='btn btn-danger btn-sm'>INACTIVATE</button></a>";



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
   public function AddBadge(Request $request)
   {

      if (!empty($request->badge_file)) {
         $request->validate([
            'badge_file' => 'required|mimes:csv,txt',
            'department_id' => 'required',
         ], [
            'mimes' => 'The file type must be in a csv format',
            'department_id.required' => 'Please select department.',

         ]);
         $path = $request->file('badge_file')->getRealPath();
         //  echo "<pre>"; print_r($request->state_file); die;

         $data1 =  Importer::make('Csv')->load($path)->getCollection();
         $datacount = count($data1);
         for ($i = 1; $i < $datacount; $i++) {
            // echo"<pre>"; print_r($data[$i][0]); 
            $data['badge_number'] = $data1[$i][0];;
            $data['department_id'] = $request->department_id;

            $insertBadge = DepartmentBadge::create($data);
         }

         return redirect('/department_management/badge');
         // die;
      } else {
         $request->validate([
            'department_id' => 'required',
            'badge_number' => 'required'
         ], [
            'department_id.required' => 'Please select department.',

         ]);
         $data['department_id'] = $request->department_id;
         $data['badge_number'] = $request->badge_number;
         $insertBadge = DepartmentBadge::create($data);
         return redirect('/department_management/badge');
      }
   }
   // ***badgeprofile data page
   public function BadgeDetail(Request $req)
   {
      $getDetail = DepartmentBadge::with('department_data.country_data')->with('department_data.state_data')->with('department_data.city_data')->whereId($req->id)->first();
      $data['data'] = $getDetail;
      return view('department_managenment.badgeProfile', $data);
   }
   public function departmentExport()
   {
      $data = [];
      for ($i = 1; $i < 11; $i++) {
         $data[] = [['department' => 'Department' . $i]];
      }
      // $data = [['department' => 'Department']];


      return Excel::download(new DepartmentExport($data), 'department.csv');
   }
   public function badgeExport()
   {
      $data = [];
      for ($i = 1; $i < 11; $i++) {
         $data[] = [['badge' => 'Badge' . $i]];
      }
      // $data = [['department' => 'Department']];


      return Excel::download(new DepartmentExport($data), 'badge.csv');
   }
}
