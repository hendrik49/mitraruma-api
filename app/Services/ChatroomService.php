<?php

namespace App\Services;

use App\Http\Resources\ChatroomResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ChatroomService
{
    /**
     * @var UserService
     */
    private $user;

    /**
     * @var UserNotificationService
     */
    private $userNotification;

    /**
     * @var ChatManagementService
     */
    private $chatManagement;

    /**
     * @var \App\Repositories\ChatroomRepository
     */
    private $chatroom;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserService $user
     * @param  \App\Services\UserNotificationService $userNotification
     * @param  \App\Services\ChatManagementService $chatManagement
     * @param  \App\Repositories\ChatroomRepository $chatroom
     * @return void
     */
    public function __construct(
        \App\Services\UserService $user,
        \App\Services\UserNotificationService $userNotification,
        \App\Services\ChatManagementService $chatManagement,
        \App\Repositories\ChatroomRepository $chatroom
    ) {
        $this->user = $user;
        $this->userNotification = $userNotification;
        $this->chatManagement = $chatManagement;
        $this->chatroom = $chatroom;
    }

    public function index($params){

        $chatroom = $this->chatroom->find($params);
        if (!$chatroom) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $chatroom = ChatroomResource::fromFirebaseArray($chatroom);

        foreach ($chatroom as $key => $data) {
            $chatroom[$key]['unread_chat'] = $this->userNotification->getCount(['user_id' => $params['user_id'] ?? null, 'type' => 'chat', 'chat_room_id' => $data['id']])['data'];
        }

        return [
            'status' => 200,
            'data' => $chatroom,
        ];
    }

    public function show($id){

        $chatroom = $this->chatroom->findById($id);
        if (!$chatroom) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $chatroom = ChatroomResource::fromFirebase($chatroom);

        return [
            'status' => 200,
            'data' => $chatroom,
        ];
    }

    public function create($params){

        $validator = Validator::make($params, [
            'admin_user_id' => 'integer',
            'vendor_user_id' => 'integer',
            'user_id' => 'integer',
            'consultation_id' => 'required|string',
            'date' => 'date',
            'image_url' => 'string',
            'is_approve' => 'boolean',
            'name' => 'string',
            'room_type' => 'required|string',
            'status' => 'required|string',
            'text' => 'string'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $dateNow=  Carbon::now('GMT+7')->format('Y-m-d\TH:i:s\Z');
        $params['date'] = $dateNow;
        $params['created_at'] = $dateNow;
        $newParams = ChatroomResource::toFirebase($params);
        $chatroom = $this->chatroom->create($newParams);

        return [
            'status' => 201,
            'data' => $chatroom,
        ];
    }

    public function update($params, $id){

        $validator = Validator::make($params, [
            'name' => 'string',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $newParams = ChatroomResource::toFirebase($params);
        $chatroom = $this->chatroom->update($newParams, $id);

        if (!$chatroom) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $chatroom,
        ];
    }

    public function destroy($id){

        $user = $this->user->show(1);
        if($user['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }

        $chatroom = $this->chatroom->deleteById($id);
        if (!$chatroom) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 202,
            'data' => ['message' => 'Success deleted data'],
        ];

    }

    public function showByFilter($params){

        $chatroom = $this->chatroom->find($params);
        if (!$chatroom) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $chatroom,
        ];
    }

    public function showUsers($id){

        $chatroom = $this->chatroom->findById($id);
        if (!$chatroom) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $chatroom = ChatroomResource::fromFirebase($chatroom);

        $user = [];
        if(isset($chatroom['user_id'])) {
            $userData = $this->user->show($chatroom['user_id']);
            $userData['status'] == 200 ? array_push($user, $this->user->show($chatroom['user_id'])['data']) : null;
        }
        if(isset($chatroom['vendor_user_id'])) {
            $vendorData = $this->user->show($chatroom['vendor_user_id']);
            $vendorData['status'] == 200 ? array_push($user, $this->user->show($chatroom['vendor_user_id'])['data']) : null;
        }
        if(isset($chatroom['admin_user_id'])) {
            $adminData = $this->user->show($chatroom['admin_user_id']);
            $adminData['status'] == 200 ? array_push($user, $this->user->show($chatroom['admin_user_id'])['data']) : null;
        }

        return [
            'status' => 200,
            'data' => $user,
        ];
    }


}