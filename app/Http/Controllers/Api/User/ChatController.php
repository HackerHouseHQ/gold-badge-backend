<?php

namespace App\Http\Controllers\Api\User;

use App\Chat;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function user_list(Request $request)
    {
        $users = User::WhereNotIn('id', [$request->user_id])->get();

        return response()->json($users);
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
