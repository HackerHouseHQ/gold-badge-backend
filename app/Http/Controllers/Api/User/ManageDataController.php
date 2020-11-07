<?php

namespace App\Http\Controllers\Api\User;

use App\User;
use Exception;
use App\Ethnicity;
use App\ReportReasson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ReportMessage;
use Illuminate\Support\Facades\Auth;

class ManageDataController extends Controller
{
    /**
     * reason question list .
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */
    public function reasonQuestionList()
    {
        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
            $reasonlist = ReportReasson::select('id as reason_id', 'name')->get();
            return res_success(trans('messages.successFetchList'), array('ratingList' => $reasonlist));
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    /**
     * Show ethnicity List.
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */

    public function getEthnicity()
    {
        try {
            $ethnicity = Ethnicity::all();
            return res_success(trans('messages.successFetchList'), (object) array('ethnicityList' => $ethnicity));
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    /**
     * Show report List.
     *
     * @return Json
     * @author Ratnesh Kumar 
     * 
     */

    public function getReport()
    {
        try {
            $report = ReportMessage::all();
            return res_success(trans('messages.successFetchList'), (object) array('reportList' => $report));
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
}
