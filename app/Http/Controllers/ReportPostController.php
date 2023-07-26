<?php

namespace App\Http\Controllers;

use App\DepartmentReport;
use App\ReportPost;
use Illuminate\Http\Request;

class ReportPostController extends Controller
{
    function __construct()
    {
        $this->postTable = new DepartmentReport;
    }
    public function report(Request $request)
    {
        return view('reported_post.reported_post');
    }
    public function report_post_list(Request $request)
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
        $search_arr = $request->get('search');
        $search = $search_arr['value'];
        $data = $this->postTable->getdata_table($order_by, $offset, $limit_t, $status_id, $state_id, $country_id, $fromdate, $todate, $search, $department_id, $badge_id, $city_id);
        $count = $this->postTable->getdata_count($status_id, $state_id, $country_id, $fromdate, $todate, $search, $department_id, $badge_id);
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
            $view = "<a href='javascript:void(0)' onclick ='viewUserDetailModel(" . $data->post_id . ")'><button type='button' class='btn btn-success btn-sm'>VIEW POST</button></a>";
            $active = "<a style='margin-left:5px;' href='javascript:void(0)' onclick ='status(" . $data->post_id . ")'><button type='button' class='btn btn-danger btn-sm'>Delete</button></a>";
            // $inactive = "<a href='javascript:void(0)' onclick = 'status(" . $data->id . ")'><span class='tbl_row_new1 view_modd_dec'>INACTIVATE</span></a>";
            $flag = ($data->flag == 1) ? 'department' : 'badges';
            $arr[$key]['userName'] =  $data->user_name;
            $arr[$key]['fullName'] =  $data->first_name . " " . $data->last_name;
            $arr[$key]['postedAbout'] =  $flag;
            $arr[$key]['postedOn'] =  date("d/m/y", strtotime($data->created_at));
            $arr[$key]['rating'] =   number_format((float)$data->rating, 1, '.', '');
            $arr[$key]['report'] =  $data->report_count;

            $view1 = $view . $active;

            $arr[$key]['action'] = $view1;
        }
        return $arr;
    }
}
