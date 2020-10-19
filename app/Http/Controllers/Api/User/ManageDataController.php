<?php

namespace App\Http\Controllers\Api\User;

use App\User;
use Exception;
use App\ReportReasson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
}
