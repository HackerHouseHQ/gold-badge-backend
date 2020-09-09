<?php

namespace App\Helpers;

class Helper
{
    public static function sendFCM_notification($json)
    {

        $serverKey = 'AAAAAPKVu7g:APA91bGlDO3LGjeDGA5aSAQ8iUZl44_yRJ2WP_hiiF7HoNdkyaFSksRIisejhnMrpRWrFu-ajTZZzQGM_haItJ_ArBAVgJ_E3oB6J9ksR-yO6lWAJnl_ciXs97xAo9ZnzEBK1n0qdb8L';

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
