<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function sendSms($message, $mobile)
    {
        $message .= "\n";
        $message .= ' لغو۱۱';

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://panel.asanak.com/webservice/v1rest/sendsms",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                'username' => 'ea4014110',
                'password' => '654321',
                'Source' => '989982001453',
                'Message' => $message,
                'destination' => $mobile
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        if (isset($response[0])) {
            $res = (int) $response[0];

            if ($res > 0)
                return response()->json(['message' => 'پیامک ارسال شد'], 200);
        } else
            return response()->json(['message' => 'مشکل در ارسال پیامک'], 401);
    }

}
