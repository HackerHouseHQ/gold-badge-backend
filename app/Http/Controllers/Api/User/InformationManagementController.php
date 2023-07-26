<?php

namespace App\Http\Controllers\Api\User;

use App\User;
use Exception;
use App\Notification;
use App\SendNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\InformationData;
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
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
            if ($checkActive->notification_status == INACTIVE) {
                return res_success(trans('messages.successFetchList'), array('notificationList' => []));
            }

            $data = SendNotification::select(DB::raw('DISTINCT(DATE(created_at)) as date'))->latest()->get();
            foreach ($data as $key => $value) {
                $notifications = SendNotification::whereDate('created_at', date('Y-m-d', strtotime($value->date)))->latest()->get();
                $value->notifications  = $notifications;
            }
            return res_success(trans('messages.successFetchList'), array('notificationList' => $data));
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function information()
    {
        try {
            $data = InformationData::first();
            return res_success(trans('messages.successFetchList'), $data);
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function read_notification()

    {
        try {
            // update status of read notification
            $update = User::whereId(Auth::user()->id)->update(['read_notification' => 1]);
            return res_success('Read the notification.');
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }

    public function getStatusOfNotification()
    {
        try {
            $data = SendNotification::select(DB::raw('DISTINCT(DATE(created_at)) as date'))->latest()->get();
            $getUsernotificationStatus = User::select('read_notification')->whereId(Auth::user()->id)->first();
            if (empty($data)) {
                $getUsernotificationStatus->read_notification = 1;
            }
            return res_success('Notification status .', $getUsernotificationStatus);
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
}
