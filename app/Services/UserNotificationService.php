<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class UserNotificationService
{
    /**
     * @var UserService
     */
    private $user;

    /**
     * @var \App\Repositories\UserNotificationRepository
     */
    private $userNotification;

    /**
     * Create a new controller instance.
     *
     * @param UserService $user
     * @param \App\Repositories\UserNotificationRepository $userNotification
     */
    public function __construct(
        \App\Services\UserService $user,
        \App\Repositories\UserNotificationRepository $userNotification
    ) {
        $this->user = $user;
        $this->userNotification = $userNotification;
    }

    public function get($params){

        $userNotification = $this->userNotification->find($params);
        if(!$userNotification) {
            return [
                'status' => 400,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $userNotification,
        ];
    }

    public function store($params){

        $validator = Validator::make($params, [
            'user_id' => 'required|int',
            'chat_room_id' => 'required|string',
            'type' => 'required|string',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $userNotification = $this->userNotification->create($params);

        return [
            'status' => 200,
            'data' => $userNotification,
        ];
    }

    public function getCount($params){

        $userNotification = $this->userNotification->count($params);
        return [
            'status' => 200,
            'data' => $userNotification,
        ];
    }


    public function destroyByParams($params){

        $cms = $this->userNotification->deleteByParams($params);
        if (!$cms) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 202,
            'data' => ['message' => 'Success read message'],
        ];

    }


}