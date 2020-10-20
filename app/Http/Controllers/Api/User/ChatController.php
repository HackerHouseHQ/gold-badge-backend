<?php

namespace App\Http\Controllers\Api\User;

use App\Chat;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\Factory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class ChatController extends Controller
{
    public function user_list(Request $request)
    {
        try {
            // check user is active or in active 
            $checkActive = User::whereId(Auth::user()->id)->where('status', ACTIVE)->first();
            if (!$checkActive) {
                throw new Exception(trans('messages.contactAdmin'), 401);
            }
            $siteUrl = env('APP_URL');
            $chat_list1 = Chat::select('room_id', 'message', 'sender_id', 'receiver_id', 'chats.created_at', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'users.id as user_id')
                ->leftJoin('users', 'users.id', '=', 'chats.sender_id')
                ->where('receiver_id', $request->user_id);
            $chat_list2 = Chat::select('room_id', 'message', 'sender_id', 'receiver_id', 'chats.created_at', 'users.user_name', DB::raw("CONCAT('$siteUrl','storage/uploads/user_image/', users.image) as user_image"), 'users.id as user_id')
                ->leftJoin('users', 'users.id', '=', 'chats.receiver_id')
                ->where('sender_id', $request->user_id);

            $data = $chat_list1->union($chat_list2)->latest()->get();;
            $arr = [];
            $room_id_array = [];
            foreach ($data as $key => $value) {
                if (!in_array($value['room_id'], $room_id_array)) {
                    $room_id_array[] = $value['room_id'];
                    $arr[] = $value;
                }
            }

            return res_success(trans('messages.successFetchList'), array('userList' => $arr));
        } catch (Exception $e) {
            return res_failed($e->getMessage(), $e->getCode());
        }
    }
    public function auth_user(Request $request)
    {
        $user = User::findOrfail($request->user_id);
        return response()->json($user);
    }


    public function user_chat_list(Request $request)
    {

        $chat_list = Chat::where(['sender_id' => $request->sender_id, 'receiver_id' => $request->receiver_id])
            ->OrWhere(['receiver_id' => $request->sender_id, 'sender_id' => $request->receiver_id])->get();

        return response()->json($chat_list);
    }


    public function send_message(Request $request)
    {

        // $data = Chat::create([
        //     'sender_id' => $request->sender_id,
        //     'receiver_id' => $request->receiver_id,
        //     'send_from' => $request->send_from,
        //     'message' => $request->message,
        // ]);
        //thats only
        $data = Chat::select('room_id', 'receiver_id', 'sender_id', 'message', 'created_at')->where('sender_id', 2)->where('receiver_id', 5)->get();
        return res(true, 'SUCCESS', $data);
    }
}
