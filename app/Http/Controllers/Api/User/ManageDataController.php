<?php

namespace App\Http\Controllers\Api\User;

use Exception;
use App\ReportReasson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManageDataController extends Controller
{
    public function reasonQuestionList()
    {
        try {
            $reasonlist = ReportReasson::select('id as reason_id', 'name')->get();
            return res_success(trans('messages.successFetchList'), array('ratingList' => $reasonlist));
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
}
