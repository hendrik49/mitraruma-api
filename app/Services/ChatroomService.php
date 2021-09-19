<?php

namespace App\Services;

use App\Http\Resources\ChatroomResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Helpers\OrderStatus;
use App\Repositories\ProjectRepository;

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
     * @var OrderStatusService
     */
    private $orderStatusService;

    /**
     * @var OrderStatus
     */
    private $orderStatusHelper;

    /**
     * @var ProjectRepository
     */
    private $projectRepo;


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
        \App\Repositories\ChatroomRepository $chatroom,
        OrderStatusService $orderStatusService,
        OrderStatus $orderStatusHelper,
        ProjectRepository $project
    ) {
        $this->user = $user;
        $this->userNotification = $userNotification;
        $this->chatManagement = $chatManagement;
        $this->chatroom = $chatroom;
        $this->orderStatusService = $orderStatusService;
        $this->orderStatusHelper = $orderStatusHelper;
        $this->projectRepo = $project;
    }

    public function index($params)
    {

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

    public function show($id)
    {

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

    public function create($params)
    {

        $validator = Validator::make($params, [
            'admin_user_id' => 'nullable|integer',
            'vendor_user_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
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

        $dateNow =  Carbon::now()->format('Y-m-d\TH:i:s\Z');
        $params['room_id'] = mt_rand(1000000, 9999999);
        $params['date'] = $dateNow;
        $params['created_at'] = $dateNow;
        $newParams = ChatroomResource::toFirebase($params);
        $chatroom = $this->chatroom->create($newParams);
        $chatroom = ChatroomResource::fromFirebase($chatroom);

        return [
            'status' => 201,
            'data' => $chatroom,
        ];
    }

    public function update($params, $id)
    {

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
        $chatroom = ChatroomResource::fromFirebase($chatroom);

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

    public function destroy($id)
    {

        $user = $this->user->show(1);
        if ($user['status'] != 200) {
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

    public function showByFilter($params)
    {

        $chatroom = $this->chatroom->find($params);
        if (!$chatroom) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }
        $chatroom = ChatroomResource::fromFirebaseArray($chatroom);

        return [
            'status' => 200,
            'data' => $chatroom,
        ];
    }

    public function showUsers($id)
    {

        $chatroom = $this->chatroom->findById($id);
        if (!$chatroom) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $chatroom = ChatroomResource::fromFirebase($chatroom);

        $user = [];
        if (isset($chatroom['user_id'])) {
            $userData = $this->user->show($chatroom['user_id']);
            $userData['status'] == 200 ? array_push($user, $this->user->show($chatroom['user_id'])['data']) : null;
        }
        if (isset($chatroom['vendor_user_id'])) {
            $vendorData = $this->user->show($chatroom['vendor_user_id']);
            $vendorData['status'] == 200 ? array_push($user, $this->user->show($chatroom['vendor_user_id'])['data']) : null;
        }
        if (isset($chatroom['admin_user_id'])) {
            $adminData = $this->user->show($chatroom['admin_user_id']);
            $adminData['status'] == 200 ? array_push($user, $this->user->show($chatroom['admin_user_id'])['data']) : null;
        }

        return [
            'status' => 200,
            'data' => $user,
        ];
    }

    public function showChatFiles($id)
    {
        $chatroom = $this->chatroom->findById($id);

        $chat = $this->chatManagement->showFilesById($chatroom['id']);

        $chatFiles = [];
        if ($chat['status'] == 200) {
            $chatFiles =  $chat['data'];
        }

        return [
            'status' => 200,
            'data' => $chatFiles,
        ];
    }

    public function showOrderStatus($id)
    {

        $orderStatus = $this->orderStatusService->show($id);

        if ($orderStatus['status'] == 404) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $orderStatus = $orderStatus['data'];

        return [
            'status' => 200,
            'data' => $orderStatus
        ];
    }

    public function showOrderStatusSelection($name, $userType = 'customer')
    {

        $orderStatus = $this->orderStatusHelper->getConsultationStatusByName($name, $userType);

        return [
            'status' => 200,
            'data' => $orderStatus,
        ];
    }

    public function updateOrderStatus($params, $id)
    {

        $validator = Validator::make($params, [
            'consultation_id' => 'required|string',
            'phase' => 'required|string',
            'order_status' => 'required',
            'file' => 'nullable',
            'type' => 'required|string',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $orderStatus = $this->orderStatusService->show($id);

        if ($orderStatus['status'] == 404) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }
        $orderStatus = $orderStatus['data'];
        $newStatus = $this->orderStatusHelper->updateOrderStatusByCode($orderStatus, $params);
        $orderStatus = $this->orderStatusService->update($newStatus, $id);

        $project = $this->projectRepo->findOne($params);

        if ($project) {
            $project['sub_status'] = $params['order_status'];
            $project['status'] = $params['phase'];
            $project['updated_at'] = date('Y-m-d H:i:s');
            $this->projectRepo->update($project, $project->id);
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
            "title" => "Order status diupdate ke kode ".$params['order_status'],
            "body" => $params['user_jwt_name'] . " membuat order status kode " . $params['order_status'] . " di room id " . $id,
            "type" => "notification",
            "value" => [
                "chat_room" => ""
            ]
        ));

        foreach ($notificationUserIds as $notificationUserId) {
            $this->userNotificationService->store(['user_id' => $notificationUserId, 'text' => "Aplikator " . $params['user_jwt_name'] . " membuat order status kode. " . $params['order_status'] . " di room id " . $id, 'type' => 'notification', 'chat_room_id' => $id]);
        }

        $orderStatus = $this->orderStatusService->show($id);
        $orderStatus = $orderStatus['data'];
        return [
            'status' => 200,
            'data' => $orderStatus
        ];
    }
}
