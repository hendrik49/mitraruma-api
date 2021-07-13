<?php

namespace App\Services;

use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;

class NotificationService
{

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserService $user
     * @param  \App\Repositories\CmsRepository $cms
     * @return void
     */
    public function __construct(
        \App\Services\UserService $user,
        \App\Repositories\CmsRepository $cms
    ) {
        $this->user = $user;
        $this->cms = $cms;
    }

    /**
     * Write code on Method
     *
     * @param $device_tokens
     * @param $message
     * @return response|bool|string
     */
    public function send($device_tokens, $message)
    {
        Log::info('firebase-send-notification', ["device_token" => $device_tokens, "message" => $message]);
        $SERVER_API_KEY = env('FIREBASE_SERVER_KEY');

        // payload data, it will vary according to requirement
        $data = [
            "registration_ids" => $device_tokens, // for single device id
            "data" => $message
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        curl_close($ch);
        $response = json_decode($response, true);
        Log::info('firebase-response-notification', $response);

        return $response;
    }


}