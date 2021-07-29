<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ChatroomManagementService
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
     * @var ChatService
     */
    private $chatService;

    /**
     * @var ChatManagementService
     */
    private $chatManagementService;

    /**
     * @var ConsultationService
     */
    private $consultationService;

    /**
     * @var ChatroomService
     */
    private $chatroomService;

    /**
     * Create a new controller instance.
     *
     * @param UserService $user
     * @param UserNotificationService $userNotification
     * @param ChatService $chatService
     * @param ChatManagementService $chatManagementService
     * @param ConsultationService $consultationService
     * @param ChatroomService $chatroomService
     */
    public function __construct(
        UserService $user,
        UserNotificationService $userNotification,
        ChatService $chatService,
        ChatManagementService $chatManagementService,
        ConsultationService $consultationService,
        ChatroomService $chatroomService
    ) {
        $this->user = $user;
        $this->userNotification = $userNotification;
        $this->chatService = $chatService;
        $this->consultationService = $consultationService;
        $this->chatManagementService = $chatManagementService;
        $this->chatroomService = $chatroomService;
    }


    public function createRoomVendor($params)
    {

        $validator = Validator::make($params, [
            'consultation_id' => 'required|string',
            'vendor_user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $user = $this->user->show($params['vendor_user_id']);
        if ($user['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }
        $user = $user['data'];

        $consultation = $this->consultationService->show($params['consultation_id']);
        if ($consultation['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }
        $consultation = $consultation['data'];
        $consultation['vendor_user_id'] = $user['ID'];
        $consultation['vendor_name'] = $user['display_name'];
        $consultation = $this->consultationService->update($consultation, $consultation['id']);
        $consultation = $consultation['data'];

        $params['admin_user_id'] = $consultation['admin_user_id'];
        $params['vendor_user_id'] = $params['vendor_user_id'] ?? null;
        $params['consultation_id'] = $consultation['id'];
        $params['status'] = 'Pre-Purchase';
        $params['image_url'] = $user['user_picture_url'] ?? "";
        $params['name'] = $user['display_name'].'-AV-'.Carbon::now('GMT+7')->format('dmHi');
        $params['text'] = 'Halo bisa mengerjakan projek ini?';
        $params['consultation_description'] = $consultation['description'];
        $params['room_type'] = 'admin-vendor';
        $chatroom = $this->chatroomService->create($params);
        $chatroom = $chatroom['data'];

        $chatParams['user_id'] = $consultation['admin_user_id'];
        $chatParams['chat'] = $consultation['id'];
        $chatParams['notification_chat'] = 'Halo bisa mengerjakan projek ini?';
        $chatParams['is_system'] = true;
        $chatParams['room_id'] = $chatroom['id'];
        $this->chatService->create($chatParams, $chatroom['id']);

        return [
            'status' => 201,
            'data' => $chatroom,
        ];
    }


    public function createRoomVendorCustomer($consultationId)
    {

        $consultation = $this->consultationService->show($consultationId);
        if ($consultation['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }
        $consultation = $consultation['data'];

        $user = $this->user->show($consultation['user_id']);
        if ($user['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }
        $user = $user['data'];

        $params['admin_user_id'] = $consultation['admin_user_id'];
        $params['vendor_user_id'] = $consultation['vendor_user_id'];
        $params['user_id'] = $consultation['user_id'];
        $params['consultation_id'] = $consultation['id'];
        $params['status'] = 'Pre-Purchase';
        $params['image_url'] = $user['user_picture_url'] ?? "";
        $params['name'] = $user['display_name'].'-AVC-'.Carbon::now('GMT+7')->format('dmHi');
        $params['text'] = 'Halo saya siap berdiskusi dengan projek ini';
        $params['consultation_description'] = $consultation['description'];
        $params['room_type'] = 'admin-vendor-customer';
        $chatroom = $this->chatroomService->create($params);
        $chatroom = $chatroom['data'];

        $chatParams['user_id'] = $consultation['vendor_user_id'];
        $chatParams['chat'] = $consultation['id'];
        $chatParams['notification_chat'] = 'Halo saya siap berdiskusi dengan projek ini';
        $chatParams['is_system'] = true;
        $chatParams['room_id'] = $chatroom['id'];
        $this->chatService->create($chatParams, $chatroom['id']);

        return [
            'status' => 201,
            'data' => $chatroom,
        ];
    }


}