<?php

namespace App\Services;

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


    public function create($params)
    {

        $validator = Validator::make($params, [
            'consultation_id' => 'required|string',
            'vendor_user_id' => 'required|integer',
            'room_type' => 'required|string',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $consultation = $this->consultationService->show($params['consultation_id']);
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

        $userAdmin = $this->user->findOne(['user_type' => 'admin']);
        $userAdmin = $userAdmin['data'];
        $params['admin_id'] = $userAdmin['ID'];
        $params['vendor_id'] = $params['vendor_user_id'] ?? null;
        $params['user_id'] = $user['ID'];
        $params['consultation_id'] = $consultation['id'];
        $params['status'] = 'Pre-Purchase';
        $params['image_url'] = $user['user_picture_url'] ?? "";
        $chatroom = $this->chatroomService->create($params);
        $chatroom = $chatroom['data'];

        $chatParams['user_id'] = $userAdmin['ID'];
        $chatParams['chat'] = $consultation['id'];
        $chatParams['is_system'] = true;
        $chatParams['room_id'] = $chatroom['id'];
        $this->chatService->create($chatParams, $chatroom['id']);

        return [
            'status' => 201,
            'data' => $chatroom,
        ];
    }



}