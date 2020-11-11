<?php

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

if (!function_exists('res')) {
    function res($status = 200, $msg = '', $data = [])
    {
        return response()->json([
            'status'     =>  $status,
            'message'    =>  $msg,
            'data'       =>  (object) $data
        ]);
    }
}

if (!function_exists('res_success')) {
    function res_success($msg = 'Success!', $data = [])
    {
        return response()->json([
            'status'     =>  200,
            'message'    =>  $msg,
            'data'       =>  (object) $data
        ]);
    }
}

if (!function_exists('res_validation_error')) {
    function res_validation_error($validator)
    {
        return response()->json([
            'status'     =>  PARAM_ERROR,
            'message'    =>  $validator->messages()->first(),
            'data'       =>  (object) []
        ]);
    }
}

if (!function_exists('res_failed')) {
    function res_failed($msg = 'Failed!', $status = 422)
    {
        return response()->json([
            'status'     =>  $status,
            'message'    =>  $msg,
            'data'       =>  (object) []
        ]);
    }
}
function formatDate($date = '', $format = 'Y-m-d')
{
    if ($date == '' || $date == null)
        return;

    return date($format, strtotime($date));
}

/**
 * @param Request $request
 * @return string $url
 */
function uploadImage($file, $subfolder = 'AllImages')
{
    $url = '';
    list($width, $height) = [0, 0];
    if ($file) {

        $imageDetail = getimagesize($file);
        list($width, $height) = getimagesize($file);

        //check for valid image extension
        $ext = $file->getClientOriginalExtension();
        if (!in_array($ext, ['png', 'jpg', 'jpeg', 'gif'])) {
            throw new Exception(trans('messages.invalidExtension'));
        }
        //check for upload folder existance
        $path = public_path() . '/uploads/' . $subfolder;
        if (!file_exists($path)) {
            File::makeDirectory($path, $mode = 777, true, true);
        }
        //upload file to folder
        if ($file) {
            $new_name = time() . $file->getClientOriginalName();
            Storage::disk('local')->put($new_name, file_get_contents($file));
            $url = '/uploads/' . $subfolder . '/' . $new_name;
        }
    }
    $response = [
        'url' => $url,
        'width' => $width,
        'height' => $height
    ];
    return $response;
}

/**
 *
 * @param type $response
 * @return type
 */
function sendResponse(array $response, $code)
{
    return (new Response($response, $code))->send();
}

if (!function_exists('sendFCM_notification')) {

    function sendFCM_notification($title, $message, $ids)
    {
        $url = env('FCM_URL');
        $fields = array(
            'registration_ids' => $ids,
            'notification' => array(
                "body" => $message,
                "title" => $title,
                "icon" => "myicon"
            )
        );
        $fields = json_encode($fields);
        $headers = array(
            'Authorization: key=' . env('FCM_API_KEY'),
            'Accept: application/json',
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        dd($result);
        curl_close($ch);

        return $result;
    }
}

if (!function_exists('sendFCM')) {

    function sendFCM($title, $message, $user)
    {

        try {
            DB::table('notifications')->insert([
                'user_id' => $user->id,
                'message' => $message,
                'created_at' => Carbon::now()->toDateTimeString()
            ]);
            if ($user->device_token) {
                return sendFCM_notification($title, $message, ['c3-zJTkASX-0ihGmos5CMP:APA91bGXvIf9Z84UZgGdBr0WLodXOIFYkGcRKqiorTsxrK7m2luuhWJCBDsy6ApK2dECm8EaY7dvw8ZhpHOuHM3rjI246bvjipHz5EOmZ8IyYAaUbLulcf1N9iNfwfs5qU5uQI-RriCD']);
            }
            return null;
        } catch (Exception $e) {
        }
    }
}
