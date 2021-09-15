<?php

namespace App\Services;

use App\Helpers\OrderStatus;
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
    private $userNotificationService;

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
     * @var OrderStatusService
     */
    private $orderStatusService;

    /**
     * @var OrderStatus
     */
    private $orderStatusHelper;

    /**
     * @var ProjectService
     */
    private $projectService;

    /**
     * @var NotificationService
     */
    private $notificationService;

    /**
     * @var UserTokenService
     */
    private $userTokenService;


    /**
     * Create a new controller instance.
     *
     * @param UserService $user
     * @param UserNotificationService $userNotification
     * @param ChatService $chatService
     * @param ChatManagementService $chatManagementService
     * @param ConsultationService $consultationService
     * @param ChatroomService $chatroomService
     * @param OrderStatusService $orderStatusService
     * @param OrderStatus $orderStatusHelper
     */
    public function __construct(
        UserService $user,
        UserNotificationService $userNotificationService,
        ChatService $chatService,
        ChatManagementService $chatManagementService,
        ConsultationService $consultationService,
        ChatroomService $chatroomService,
        OrderStatusService $orderStatusService,
        OrderStatus $orderStatusHelper,
        ProjectService $projectService,
        NotificationService $notificationService,
        UserTokenService $userTokenService
    ) {
        $this->user = $user;
        $this->userNotificationService = $userNotificationService;
        $this->chatService = $chatService;
        $this->consultationService = $consultationService;
        $this->chatManagementService = $chatManagementService;
        $this->chatroomService = $chatroomService;
        $this->orderStatusService = $orderStatusService;
        $this->orderStatusHelper = $orderStatusHelper;
        $this->projectService = $projectService;
        $this->notificationService = $notificationService;
        $this->userTokenService = $userTokenService;
    }


    public function createRoomVendor($params)
    {
        $validator = Validator::make($params, [
            'consultation_id' => 'required|string',
            'chatroom_id' => 'required|string',
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
        $user = $user['data']; //TODO need changes to integratrion

        $consultation = $this->consultationService->show($params['consultation_id']);
        if ($consultation['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'Consultation not found'],
            ];
        }

        $consultation = $consultation['data'];
        $consultation['vendor_user_id'] = $params['vendor_user_id'];
        $consultation['admin_user_id'] =  $consultation['admin_user_id'] ? $consultation['admin_user_id'] : $params['admin_user_id'];
        $consultation['admin_name'] =  $consultation['admin_name'] ? $consultation['admin_name'] : $params['user_jwt_name'];
        $consultation['vendor_name'] = $user['display_name'];
        $consultation['order_status'] = 130;
        $consultation['updated_at'] = Carbon::now()->format('Y-m-d\TH:i:s\Z');
        $consultation = $this->consultationService->update($consultation, $consultation['id']);
        $consultation = $consultation['data'];

        $params['user_id'] = $consultation['user_id'];
        $params['admin_user_id'] = $consultation['admin_user_id'];
        $params['vendor_user_id'] = $params['vendor_user_id'] ?? null;
        $params['consultation_id'] = $consultation['id'];
        $params['status'] = 'Pre-Purchase';
        $params['image_url'] = $user['user_picture_url'] ?? "";
        $params['name'] = $consultation['name'] . '-AV-' . $consultation['order_number'];
        $params['text'] = 'Halo bisa mengerjakan projek ini?';
        $params['consultation_description'] = $consultation['description'];
        $params['room_type'] = 'admin-vendor';
        $chatroom = $this->chatroomService->create($params);
        $chatroom = $chatroom['data'];

        $orderStatus = $this->orderStatusService->show($params['chatroom_id']);
        $orderStatus = isset($orderStatus['data']['data']) ? $orderStatus['data']['data'] : $orderStatus['data'];
        $newOrderStatus = $this->orderStatusHelper->getOrderStatusByCode(130);
        foreach ($orderStatus as $keyOrderStatus => $keyOrderValue) {
            if ($keyOrderValue['phase'] == $newOrderStatus['phase']) {
                array_push($orderStatus[$keyOrderStatus]['list'], ["activity" => $newOrderStatus['activity'], 'createdAt' => Carbon::now()->format('Y-m-d\TH:i:s\Z')]);
            }
        }
        $os['data'] = $orderStatus;
        $this->orderStatusService->update($os, $chatroom['id']);

        $chatParams['user_id'] = $consultation['admin_user_id'];
        $chatParams['chat'] = $consultation['id'];
        $chatParams['notification_chat'] = 'Halo bisa mengerjakan projek ini?';
        $chatParams['is_system'] = true;
        $chatParams['room_id'] = $chatroom['id'];
        $chatParams['user_type'] = 'admin';

        $this->chatService->create($chatParams, $chatroom['id']);

        $project  = $this->projectService->showByConsultation($consultation['id']);

        if ($project['status'] == 404) {
            return [
                'status' => 404,
                'data' => ['message' => 'Project not found'],
            ];
        }
        $project = $project['data'];
        $project = json_decode(json_encode($project), true);
        $project['room_number'] = 'AV-' . $chatroom['room_id'];
        $project['city'] =  $project['city'] ? $project['city'] : "Kota Bogor";

        $project['vendor_name'] = $user['display_name'];
        $project['vendor_user_id'] =  $user['ID'];
        $project['vendor_contact'] = $user['user_phone_number'];

        $resp = $this->projectService->update($project, $project['id']);

        if ($resp['status'] == 422) {
            return [
                'status' => 422,
                'data' => ['message' => $resp],
            ];
        }

        $userIds = [];
        if (isset($params['user_id'])) {
            array_push($userIds, $params['user_id']);
        }
        if (isset($params['vendor_user_id'])) {
            array_push($userIds, $params['vendor_user_id']);
        }

        $tokens = $this->userTokenService->get(['user_ids' => $userIds]);
        if ($tokens['status'] == 200) {
            $tokens = $tokens['data'];
        }

        $deviceTokens = [];
        $notificationUserIds = [];
        foreach ($tokens as $token) {
            array_push($notificationUserIds, $token['user_id']);
            array_push($deviceTokens, $token['device_token']);
        }

        $this->notificationService->send($deviceTokens, array(
            "title" => "Notifiksi Aplikator terpilih konsultasi" . $params['name'],
            "body" => "Aplikator " . $user['display_name'] . " dipilih untuk mengerjakan konsultasi No. " . $consultation['order_number'],
            "type" => "notification",
            "value" => [
                "chat_room" => $chatroom
            ]
        ));

        foreach ($notificationUserIds as $notificationUserId) {
            $this->userNotificationService->store(['user_id' => $notificationUserId, 'text' => "Aplikator " . $user['display_name'] . " dipilih untuk mengerjakan konsultasi No. " . $consultation['order_number'], 'type' => 'notification', 'chat_room_id' => $chatroom['id']]);
        }

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
                'data' => ['message' => 'Data not found'],
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

        $params['is_approve'] = true;
        $params['admin_user_id'] = $consultation['admin_user_id'];
        $params['vendor_user_id'] = $consultation['vendor_user_id'];
        $params['user_id'] = $consultation['user_id'];
        $params['consultation_id'] = $consultation['id'];
        $params['status'] = 'Pre-Purchase';
        $params['image_url'] = $user['user_picture_url'] ?? "";
        $params['name'] = $user['display_name'] . '-AVC-' . $consultation['order_number'];
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
        $chatParams['user_type'] = 'vendor';
        $this->chatService->create($chatParams, $chatroom['id']);

        //todo create notification

        $project  = $this->projectService->showByConsultation($consultation['id']);

        if ($project['status'] == 404) {
            return [
                'status' => 404,
                'data' => ['message' => 'Chat room not found'],
            ];
        }
        $project = $project['data'];
        $project = json_decode(json_encode($project), true);
        $project['room_number'] = 'AVC-' . $chatroom['room_id'];
        $project['city'] =  $project['city'] ? $project['city'] : "Kota Bogor";

        $resp = $this->projectService->update($project, $project['id']);

        if ($resp['status'] == 422) {
            return [
                'status' => 422,
                'data' => ['message' => $resp],
            ];
        }


        $userIds = [];
        if (isset($params['user_id'])) {
            array_push($userIds, $params['user_id']);
        }
        if (isset($params['admin_user_id'])) {
            array_push($userIds, $params['admin_user_id']);
        }

        $tokens = $this->userTokenService->get(['user_ids' => $userIds]);
        if ($tokens['status'] == 200) {
            $tokens = $tokens['data'];
        }

        $deviceTokens = [];
        $notificationUserIds = [];
        foreach ($tokens as $token) {
            array_push($notificationUserIds, $token['user_id']);
            array_push($deviceTokens, $token['device_token']);
        }

        $this->notificationService->send($deviceTokens, array(
            "title" => "Notifiksi Aplikator menyetujui mengerjakan konsultasi" . $params['name'],
            "body" => "Aplikator " . $consultation['vendor_name'] . " menyetujui untuk mengerjakan konsultasi " . $consultation['order_number'],
            "type" => "notification",
            "value" => [
                "chat_room" => $chatroom
            ]
        ));

        foreach ($notificationUserIds as $notificationUserId) {
            $this->userNotificationService->store(['user_id' => $notificationUserId, 'text' => "Aplikator " . $consultation['vendor_name'] . " menyetujui untuk mengerjakan konsultasi No. " . $consultation['order_number'], 'type' => 'notification', 'chat_room_id' => $chatroom['id']]);
        }

        return [
            'status' => 201,
            'data' => $chatroom,
        ];
    }

    public function createRoomVendorCustomerNew($consultationId, $roomId)
    {

        $consultation = $this->consultationService->show($consultationId);
        if ($consultation['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'Consultation not found'],
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

        $chatroom = $this->chatroomService->show($roomId);

        if ($chatroom['status'] == 404) {
            return [
                'status' => 404,
                'data' => ['message' => 'Chat room not found'],
            ];
        }

        $chatroom = $chatroom['data'];
        $chatroom['is_approve'] = true;
        //update old room vendor
        $chatroom = $this->chatroomService->update($chatroom, $chatroom['id']);

        $params['user_id'] = $consultation['user_id'];
        $params['admin_user_id'] = $consultation['admin_user_id'];
        $params['vendor_user_id'] = $consultation['vendor_user_id'];
        $params['user_id'] = $consultation['user_id'];
        $params['consultation_id'] = $consultation['id'];
        $params['status'] = 'Pre-Purchase';
        $params['image_url'] = $user['user_picture_url'] ?? "";
        $params['name'] =  $consultation['name'] . '-AVC-' . $consultation['order_number'];
        $params['text'] = 'Halo saya siap berdiskusi dengan projek ini';
        $params['consultation_description'] = $consultation['description'];
        $params['room_type'] = 'admin-vendor-customer';
        $chatroom = $this->chatroomService->create($params);
        $chatroom = $chatroom['data'];

        $orderStatus = $this->orderStatusService->show($roomId);
        $orderStatus = isset($orderStatus['data']['data']) ? $orderStatus['data']['data'] : $orderStatus['data'];
        $os['data'] = $orderStatus;
        $this->orderStatusService->update($os, $chatroom['id']);

        $chatParams['user_id'] = $consultation['vendor_user_id'];
        $chatParams['chat'] = $consultation['id'];
        $chatParams['notification_chat'] = 'Halo saya siap berdiskusi dengan projek ini';
        $chatParams['is_system'] = true;
        $chatParams['room_id'] = $chatroom['id'];
        $chatParams['user_type'] = 'vendor';
        $this->chatService->create($chatParams, $chatroom['id']);

        $project  = $this->projectService->showByConsultation($consultation['id']);

        if ($project['status'] == 404) {
            return [
                'status' => 404,
                'data' => ['message' => 'Chat room not found'],
            ];
        }
        $project = $project['data'];
        $project = json_decode(json_encode($project), true);
        $project['room_number'] = 'AVC-' . $chatroom['room_id'];
        $project['city'] =  $project['city'] ? $project['city'] : "Kota Bogor";
        $resp = $this->projectService->update($project, $project['id']);

        if ($resp['status'] == 422) {
            return [
                'status' => 422,
                'data' => ['message' => $resp],
            ];
        }
        //todo create notification

        $userIds = [];
        if (isset($params['user_id'])) {
            array_push($userIds, $params['user_id']);
        }
        if (isset($params['admin_user_id'])) {
            array_push($userIds, $params['admin_user_id']);
        }

        $tokens = $this->userTokenService->get(['user_ids' => $userIds]);
        if ($tokens['status'] == 200) {
            $tokens = $tokens['data'];
        }

        $deviceTokens = [];
        $notificationUserIds = [];
        foreach ($tokens as $token) {
            array_push($notificationUserIds, $token['user_id']);
            array_push($deviceTokens, $token['device_token']);
        }

        $this->notificationService->send($deviceTokens, array(
            "title" => "Notifiksi Aplikator menyetujui mengerjakan konsultasi" . $params['name'],
            "body" => "Aplikator " . $consultation['vendor_name'] . " menyetujui untuk mengerjakan konsultasi " . $consultation['order_number'],
            "type" => "notification",
            "value" => [
                "chat_room" => $chatroom
            ]
        ));

        foreach ($notificationUserIds as $notificationUserId) {
            $this->userNotificationService->store(['user_id' => $notificationUserId, 'text' => "Aplikator " . $consultation['vendor_name'] . " menyetujui untuk mengerjakan konsultasi No. " . $consultation['order_number'], 'type' => 'notification', 'chat_room_id' => $chatroom['id']]);
        }

        return [
            'status' => 201,
            'data' => $chatroom,
        ];
    }
}
