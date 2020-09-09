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

if (!function_exists('sendFCM_notificatio')) {
    function sendFCM_notification($json)
    {

        $serverKey = 'AAAAkagE0Hg:APA91bHoomblEPnCIn8ulIYlmcP4-xYH2MOAXqXKvEjbG7wzMZSwnpXjPPEnE1MdmrgQUv9IgwfA3JsXIGKm9Obq-vviFZyucbAZyeA59XP1SWcyROelkfrh5yTd-gt2M_IVKaWqQjt9';

        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=' . $serverKey;


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $response = curl_exec($ch);

        curl_close($ch);
        if ($response === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        //echo "<pre>"; print_r($response);die;
        return $response;
        //s curl_close($ch);

    }
}
