<?php

namespace App\Http\Controllers;

use DB;

use Auth;
use Session;
use Storage;
use App\City;
use Exporter;
use Importer;
use Validator;
use App\Country;

// use Excel;
use App\Ethnicity;
use App\Department;
use App\CountryState;
use App\GenderOption;
use App\ReportMessage;
use App\ReportReasson;
use App\Exports\CityExport;
use App\Exports\StateExport;
use Illuminate\Http\Request;
use App\Exports\ReportExport;
use App\Exports\CountryExport;
use App\Exports\EthnicityExport;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\LengthAwarePaginator;


class ManageDataController extends Controller
{
    function __construct()
    {
        $this->state = new CountryState;
    }

    // show country

    public function countries()
    {
        return view('manage_data.countries');
    }
    public function countries_list(Request $request)
    {
        // echo"<pre>"; print_r($request->all()); die;
        $order_by = $_GET['order'][0]['dir'];
        $columnIndex = $_GET['order'][0]['column'];
        $columnName = $_GET['columns'][$columnIndex]['data'];
        $columnName =  ($columnName == 'username') ? 'first_name' : 'created_at';
        $offset = $_GET['start'] ? $_GET['start'] : "0";
        $limit_t = ($_GET['length'] != '-1') ? $_GET['length'] : "";
        $draw = $_GET['draw'];
        $search_arr = $request->get('search');
        $search = $search_arr['value'];
        // $search= $request->role;
        $data = $this->state->getdata_table($order_by, $offset, $limit_t, $search);
        $count = $this->state->getdata_count($order_by, $search);
        $getuser = $this->manage_data($data, $offset);
        $results = [
            "draw" => intval($draw),
            "iTotalRecords" => $count,
            "iTotalDisplayRecords" => $count,
            "aaData" => $getuser
        ];
        echo json_encode($results);
    }
    public function manage_data($data, $offset)
    {
        $arr = array();
        $i = $offset;
        foreach ($data as $key => $data) {
            // $view = "<a href='".route('UserDetail',['id' => $data->id])."'><span class='tbl_row_new1 view_modd_dec'>View Country Department</span></a><br>";
            //  $view = "<a href='javascript:void(0)' onclick ='viewDepartmentModel1(".$data->id.")'><span class='tbl_row_new1 view_modd_dec'>View Country Department</span></a><br>";
            $view = "<a href='javascript:void(0)' onclick ='viewDepartmentModel1(" . $data->country_id . ")'><button type='button' class='btn btn-info btn-sm'>View Country Department</button></a>";
            //  $viewCity = "<a href='javascript:void(0)' onclick ='viewCityModel1(".$data->id.")'><span class='tbl_row_new1 view_modd_dec'>View City List</span></a>";
            $viewCity = "<a href='javascript:void(0)' onclick ='viewCityModel1(" . $data->state_id . ")'><button type='button' class='btn btn-success btn-sm'>View City List</button></a>";
            //$EditCity = "<a href='javascript:void(0)' onclick ='EditCityModel1(".$data->id.")'><span class='tbl_row_new1 view_modd_dec'>Edit City List</span></a>";
            $EditCity = "<a  style='margin:5px;' href='javascript:void(0)' onclick ='EditCityModel1(" . $data->state_id . ")'><button type='button' class='btn btn-primary btn-sm'>Edit City List</button></a>";
            $stateId = ($data->state_id) ?? "``";
            $countryId = ($data->country_id) ?? "``";
            $countryName = ($data->country_name) ?? "``";
            $stateName = ($data->state_name) ?? "`` ";
            $EditCountry = "<a  style='margin:5px;' href='javascript:void(0)' onclick ='EditCountryModel1(" . $countryId . ",`" . $countryName . "`)'><button type='button' class='btn btn-primary btn-sm'>Edit Country</button></a>";
            $EditState = "<a  style='margin:5px;' href='javascript:void(0)' onclick ='EditStateModel1(" . $stateId     . ",`" . $stateName . "`)'><button type='button' class='btn btn-primary btn-sm'>Edit State</button></a>";



            $arr[$key]['SN'] =  ++$i;
            $arr[$key]['country_name'] =  $data->country_name;
            $arr[$key]['state_name'] =  ($data->state_name) ?? "";
            $array_city = array();
            array_push($array_city, $data->city_name);
            $array_city = implode(",", $array_city);


            $arr[$key]['city_name'] =  $viewCity;

            $view1 = $view . $EditCity . $EditCountry . $EditState;
            // $arr[$key]['view'] = '<a href="#">view country department/<br>edit city list</a>';
            $arr[$key]['view'] =  $view1;
        }
        return $arr;
    }

    public function add_country_page()
    {
        return view('manage_data.add_country');
    }
    // insert country
    public function add_country(Request $request)
    {
        if (!empty($request->country_file)) {
            $request->validate([
                'country_file' => 'required|mimes:csv,txt'
            ], [
                'mimes' => 'The file type must be in a csv format'
            ]);
            $path = $request->file('country_file')->getRealPath();
            //  echo "<pre>"; print_r($request->state_file); die;

            $data1 =  Importer::make('Csv')->load($path)->getCollection();
            $datacount = count($data1);
            for ($i = 1; $i < $datacount; $i++) {
                // echo"<pre>"; print_r($data[$i][0]);
                $data['country_name'] = $data1[$i][0];
                $insertCountry = Country::create($data);
            }
            return redirect('/manage_data/countries');
            // die;
        } else {
            $request->validate([
                'country_name'  => 'required|unique:countries',
            ]);
            $data['country_name'] = $request->country_name;
            $insertCountry = Country::create($data);
            return redirect('/manage_data/countries');
        }
    }
    public function viewCityModel($id)
    {
        $genderData = City::where('state_id', $id)->get();
        return response()->json($genderData, 200);
    }
    public function editCityModelView(Request $request)
    {
        // echo"<pre>"; print_r($request->all()); die;
        $data['city_name'] = $request->city_name;
        $updatedata = City::where('id', $request->city_id)->update($data);
        return redirect('/manage_data/countries');
    }

    public function add_state_page()
    {
        return view('manage_data.add_state');
    }
    // insert state
    public function add_state(Request $request)
    {
        $request->validate([
            'country_id' => 'required'
        ], [
            'country_id.required' => 'Please select country.'
        ]);

        if (!empty($request->state_file)) {
            $request->validate([
                'state_file' => 'required|mimes:csv,txt'
            ], [
                'mimes' => 'The file type must be in a csv format'
            ]);
            $path = $request->file('state_file')->getRealPath();
            //  echo "<pre>"; print_r($request->state_file); die;

            $data1 =  Importer::make('Csv')->load($path)->getCollection();
            $datacount = count($data1);
            for ($i = 1; $i < $datacount; $i++) {
                // echo"<pre>"; print_r($data[$i][0]);
                $data['country_id'] = $request->country_id;
                $data['state_name'] = $data1[$i][0];
                $insertCountry = CountryState::create($data);
            }
            return redirect('/manage_data/countries');
            // die;
        } else {
            $request->validate([
                'state_name'  => 'required|unique:country_states'
            ]);
            $data['country_id'] = $request->country_id;
            $data['state_name'] = $request->state_name;
            $insertCountry = CountryState::create($data);
            return redirect('/manage_data/countries');
        }
    }

    public function add_city_page()
    {
        return view('manage_data.add_city');
    }
    public function get_state(Request $request)
    {
        $country_id = $request->country_id;
        $state_data = CountryState::where('country_id', $country_id)->get()->toArray();
        $state_arr = array();
        foreach ($state_data as $key => $value) {
            $stateid = $value['id'];
            $name = $value['state_name'];
            $state_arr[] = array("id" => $stateid, "name" => $name);
        }
        echo json_encode($state_arr);
    }
    public function get_city(Request $request)
    {
        $state_id = $request->state_id;
        $state_data = City::where('state_id', $state_id)->get()->toArray();
        $state_arr = array();
        foreach ($state_data as $key => $value) {
            $stateid = $value['id'];
            $name = $value['city_name'];
            $state_arr[] = array("id" => $stateid, "name" => $name);
        }
        echo json_encode($state_arr);
    }
    public function add_city(Request $request)
    {
        $request->validate([
            'country_id' => 'required',
            'state_id'  => 'required',

        ], [
            'country_id.required' => 'Please select country.',
            'state_id.required' => 'Please select state.'
        ]);
        if (!empty($request->city_file)) {
            $request->validate([
                'city_file' => 'required|mimes:csv,txt'
            ], [
                'mimes' => 'The file type must be in a csv format.'
            ]);
            $path = $request->file('city_file')->getRealPath();
            $data1 =  Importer::make('Csv')->load($path)->getCollection();
            $datacount = count($data1);
            for ($i = 1; $i < $datacount; $i++) {
                // echo"sdf"; die;
                $data['country_id'] = $request->country_id;
                $data['state_id'] = $request->state_id;
                $data['city_name'] = $data1[$i][0];
                $insertCountry = City::create($data);
            }
            return redirect('/manage_data/countries');
        } else {
            $request->validate([
                'city_name' => 'required|unique:cities'
            ]);
            $data['country_id'] = $request->country_id;
            $data['state_id'] = $request->state_id;
            $data['city_name'] = $request->city_name;
            $insertCountry = City::create($data);
            return redirect('/manage_data/countries');
        }
    }


    // show enthcity
    public function ethnicity()
    {
        $ethnicityData = Ethnicity::simplePaginate(20);
        $data['data'] = $ethnicityData;
        return view('manage_data.ethnicity', $data);
    }
    // add ethnicity
    public function add_ethnicity_page()
    {
        return view('manage_data.add_ethnicity');
    }
    public function add_ethnicity(Request $request)
    {
        if (!empty($request->ethnicity_file)) {
            $request->validate([
                'ethnicity_file' => 'required|mimes:csv,txt'
            ], [
                'mimes' => 'The file type must be in a csv format'
            ]);
            $path = $request->file('ethnicity_file')->getRealPath();
            //  echo "<pre>"; print_r($request->state_file); die;

            $data1 =  Importer::make('Csv')->load($path)->getCollection();
            $datacount = count($data1);
            for ($i = 1; $i < $datacount; $i++) {
                // echo"<pre>"; print_r($data[$i][0]);
                $data['ethnicity_name'] = $data1[$i][0];
                $insertCountry = Ethnicity::create($data);
            }
            return redirect('/manage_data/ethnicity');
            // die;
        } else {
            $request->validate([
                'ethnicity_name' => 'required'
            ]);

            $data['ethnicity_name'] =   ucfirst($request->ethnicity_name);
            $InsertEthnicity = Ethnicity::Create($data);
            return redirect('/manage_data/ethnicity');
        }
    }
    public function DeleteEthnicity($id)
    {
        $DeleteEthnicity = Ethnicity::where('id', $id)->delete();
        return redirect('/manage_data/ethnicity');
    }
    public function Show_edit_ethnicity($id)
    {
        $genderData = Ethnicity::where('id', $id)->first();
        return response()->json($genderData, 200);
    }
    public function updatEthnicity(Request $request)
    {
        $data['ethnicity_name'] = ucfirst($request->name);
        $EthnicityData = Ethnicity::where('id', $request->id)->update($data);
        return redirect('/manage_data/ethnicity');
    }

    // show enthcity
    public function reportMessage()
    {
        $reportMessageData = ReportMessage::simplePaginate(20);
        $data['data'] = $reportMessageData;
        return view('manage_data.report-message', $data);
    }
    // add ReportMessage
    public function add_report_message_page()
    {
        return view('manage_data.add_report_message');
    }
    public function add_report_message(Request $request)
    {
        if (!empty($request->report_message_file)) {
            $request->validate([
                'report_message_file' => 'required|mimes:csv,txt'
            ], [
                'mimes' => 'The file type must be in a csv format'
            ]);
            $path = $request->file('report_message_file')->getRealPath();
            //  echo "<pre>"; print_r($request->state_file); die;

            $data1 =  Importer::make('Csv')->load($path)->getCollection();
            $datacount = count($data1);
            for ($i = 1; $i < $datacount; $i++) {
                // echo"<pre>"; print_r($data[$i][0]);
                $data['message'] = $data1[$i][0];
                $insertCountry = ReportMessage::create($data);
            }
            return redirect('/manage_data/report-message');
            // die;
        } else {
            $request->validate([
                'message' => 'required'
            ]);

            $data['message'] =   ucfirst($request->message);
            $InsertReportMessage = ReportMessage::Create($data);
            return redirect('/manage_data/report-message');
        }
    }
    public function DeleteReportMessage($id)
    {
        $DeleteReportMessage = ReportMessage::where('id', $id)->delete();
        return redirect('/manage_data/report-message');
    }
    public function Show_edit_report_message($id)
    {
        $ReportMessageData = ReportMessage::where('id', $id)->first();
        return response()->json($ReportMessageData, 200);
    }
    public function updatReportMessage(Request $request)
    {
        $data['message'] = ucfirst($request->message);
        $ReportMessageData = ReportMessage::where('id', $request->id)->update($data);
        return redirect('/manage_data/report-message');
    }


    // show option to give user gender
    public function gender()
    {
        $genderData = GenderOption::simplePaginate(20);
        $data['data'] = $genderData;
        return view('manage_data.gender', $data);
    }
    public function DeleteGender($id)
    {
        $Delete = GenderOption::where('id', $id)->delete();
        return redirect('/manage_data/gender');
    }
    public function Show_edit_gender($id)
    {
        $genderData = GenderOption::where('id', $id)->first();
        return response()->json($genderData, 200);
    }
    public function updateGender(Request $request)
    {
        $data['name'] = ucfirst($request->name);
        $genderData = GenderOption::where('id', $request->id)->update($data);
        return redirect('/manage_data/gender');
    }
    public function AddGender(Request $request)
    {
        // echo"<pre>"; print_r($request->all()); die;
        $data['name'] = ucfirst($request->name);
        $genderData = GenderOption::create($data);
        return redirect('/manage_data/gender');
    }

    // // show report reason option page
    public function report()
    {
        $reportData = ReportReasson::simplePaginate(20);
        $data['data'] = $reportData;
        return view('manage_data.report', $data);
    }
    public function DeleteReport($id)
    {
        $Delete = ReportReasson::where('id', $id)->delete();
        return redirect('/manage_data/report');
    }
    public function showAddReportform(Request $request)
    {
        return view('manage_data.add_report_reason');
    }
    public function Show_edit_report($id)
    {
        $genderData = ReportReasson::where('id', $id)->first();
        return response()->json($genderData, 200);
    }
    public function updatReport(Request $request)
    {
        $data['name'] = ucfirst($request->name);
        $genderData = ReportReasson::where('id', $request->id)->update($data);
        return redirect('/manage_data/report');
    }
    public function AddReport(Request $request)
    {

        // echo"<pre>"; print_r($request->all()); die;
        if (!empty($request->reason_file)) {
            $request->validate([
                'reason_file' => 'required|mimes:csv,txt'
            ], [
                'mimes' => 'The file type must be in a csv format'
            ]);
            $path = $request->file('reason_file')->getRealPath();
            //  echo "<pre>"; print_r($request->state_file); die;

            $data1 =  Importer::make('Csv')->load($path)->getCollection();
            $datacount = count($data1);
            for ($i = 1; $i < $datacount; $i++) {
                // echo"<pre>"; print_r($data[$i][0]);
                $data['name'] = $data1[$i][0];
                $insertReason = ReportReasson::create($data);
            }
            return redirect('/manage_data/report');
            // die;
        } else {
            $request->validate([
                'name' => 'required'
            ], [
                'name.required' => 'The reason name field is required.'
            ]);

            $data['name'] =   ucfirst($request->name);
            $InsertReason = ReportReasson::Create($data);
            return redirect('/manage_data/report');
        }
    }
    public function countryExport()
    {
        $data = [];
        for ($i = 1; $i < 11; $i++) {
            $data[] = [['country' => 'Country' . $i]];
        }
        // $data = [['department' => 'Department']];


        return Excel::download(new CountryExport($data), 'country.csv');
    }
    public function stateExport()
    {
        $data = [];
        for ($i = 1; $i < 11; $i++) {
            $data[] = [['state' => 'State' . $i]];
        }
        // $data = [['department' => 'Department']];


        return Excel::download(new StateExport($data), 'state.csv');
    }
    public function cityExport()
    {
        $data = [];
        for ($i = 1; $i < 11; $i++) {
            $data[] = [['city' => 'City' . $i]];
        }
        // $data = [['department' => 'Department']];


        return Excel::download(new CityExport($data), 'city.csv');
    }
    public function reportExport()
    {
        $data = [];
        for ($i = 1; $i < 11; $i++) {
            $data[] = [['report' => 'Report' . $i]];
        }
        // $data = [['department' => 'Department']];


        return Excel::download(new ReportExport($data), 'report.csv');
    }
    public function ethnicityExport()
    {
        $data = [];
        for ($i = 1; $i < 11; $i++) {
            $data[] = [['ethnicity' => 'Ethnicity' . $i]];
        }
        // $data = [['department' => 'Department']];


        return Excel::download(new EthnicityExport($data), 'ethnicity.csv');
    }
    public function editCountry(Request $request)
    {
        $request->validate([
            'country_name'  => 'required|unique:countries',
        ]);
        $editCountry = Country::where('id', $request->country_id)->update(['country_name' => $request->country_name]);
        return redirect('/manage_data/countries');
    }
    public function editState(Request $request)
    {
        $request->validate([
            'state_name'  => 'required|unique:country_states',
        ]);
        $editCountry = CountryState::where('id', $request->state_id)->update(['state_name' => $request->state_name]);
        return redirect('/manage_data/countries');
    }
    public function viewDeparmentModel(Request $request)
    {
        $countryId = $request->id;
        $departmnet = Department::getDepartmentwithCountry($countryId);
        return $departmnet;
    }
}
