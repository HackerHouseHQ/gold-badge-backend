<?php

namespace App\Http\Controllers\Api\User;

use App\User;
use Exception;
use App\Notification;
use App\SendNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InformationManagementController extends Controller
{
    //
    public function getNotification(Request $request)
    {
        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'),);
            }
            $data = SendNotification::select(DB::raw('DISTINCT(DATE(created_at)) as date'))->get();
            foreach ($data as $key => $value) {
                $notifications = SendNotification::where('created_at', 'LIKE', '%' . date('Y-m-d', strtotime($value->date)) . '%')->get();
                $value->notifications  = $notifications;
            }
            return res_success(trans('messages.successFetchList'), array('notificationList' => $data));
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
}
