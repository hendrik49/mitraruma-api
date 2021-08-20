<?php

namespace App\Services;

use App\Http\Resources\UserNotificationResource;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * @var UserService
     */
    private $user;

    /**
     * @var \App\Repositories\CmsRepository
     */
    private $cms;

    /**
     * @var \App\Repositories\UserNotificationRepository
     */
    private $userNotificationRepository;

    /**
     * Create a new controller instance.
     *
     * @param \App\Services\UserService $user
     * @param \App\Repositories\CmsRepository $cms
     * @param \App\Repositories\UserNotificationRepository $userNotificationRepository
     */
    public function __construct(
        \App\Services\UserService $user,
        \App\Repositories\CmsRepository $cms,
        \App\Repositories\UserNotificationRepository $userNotificationRepository
    )
    {
        $this->user = $user;
        $this->cms = $cms;
        $this->userNotificationRepository = $userNotificationRepository;
    }

    public function index($params)
    {

        $params['type'] = 'notification';
        $notification = $this->userNotificationRepository->find($params);
        if (!$notification) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => UserNotificationResource::collection($notification),
        ];
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

        Log::info('firebase-response-notification', ["response" => $response]);
        $response = json_decode($response, true);

        return $response;
    }


}