<?php

namespace App\Http\Controllers\Api\User;

use Exception;
use App\Notification;
use App\SendNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InformationManagementController extends Controller
{
    //
    public function getNotification(Request $request)
    {
        try {
            $data = SendNotification::all();
            return res_success(trans('messages.successFetchList'), array('notificationList' => $data));
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
}
