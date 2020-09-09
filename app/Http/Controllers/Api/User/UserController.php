<?php

namespace App\Http\Controllers\Api\User;

use App\City;
use App\User;
use Exception;
use App\Country;
use App\Department;
use App\CountryState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getCountryList()
    {
        /**
         * Show country List.
         *
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */
        try {
            $country = Country::select('id as country_id', 'country_nam')->get();
            if (count($country) > 0) {
                return res_success(trans('messages.successFetchList'), (object) array('countryList' => $country));
            } else {
                return res_success('No record found', (object) array('countryList' => $country));
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function getStateList(Request $request)
    {
        /**
         * Show state List.
         *
         * @param int $countryId
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */
        try {
            $countryId = $request->country_id;
            $state =  CountryState::select('id as state_id', 'country_id', 'state_name')->where('country_id',  $countryId)->get();
            if (count($state) > 0) {
                return res_success(trans('messages.successFetchList'), (object) array('stateList' => $state));
            } else {
                return res_success('No record found', (object) array('stateList' => $state));
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function getCityList(Request $request)
    {
        /**
         * Show city List.
         *
         * @param int $countryId , $stateId
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */
        try {
            $countryId = $request->country_id;
            $stateId = $request->state_id;
            $city = City::select('id as city_id', 'state_id', 'country_id', 'city_name')
                ->where('country_id', $countryId)
                ->where('state_id', $stateId)
                ->get();
            if (count($city) > 0) {
                return res_success(trans('messages.successFetchList'), (object) array('cityList' => $city));
            } else {
                return res_success('No record found', (object) array('cityList' => $city));
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function checkMobileNoExistence(Request $request)
    {
        /**
         * Check mobile number existence.
         *
         * @param int $mobileNumber
         * @return Json
         * @author Ratnesh Kumar 
         * 
         */
        try {
            $mobileNumber = $request->mobile_no;
            $checkmobile = User::where('mobil_no', $mobileNumber)->first();

            if (!empty($checkmobile)) {
                throw new Exception(trans('messages.recordExists'), DATA_EXISTS);
            } else {
                throw new Exception(trans('messages.numberNotExists'), NOT_EXISTS);
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function followDepartmentList(Request $request)
    {
        try {
            $countryId = $request->country_id;
            $stateId = $request->state_id;
            $department = Department::getDepartmentList($countryId, $stateId);
            if (count($department) > 0) {
                return res_success(trans('messages.successFetchList'), (object) array('departmentFollowList' => $department));
            } else {
                return res_success('No record found', (object) array('departmentFollowList' => $department));
            }
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
}
