<?php

namespace App\Services;

use App\Http\Resources\ChatResource;
use App\Repositories\ChatRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ChatService
{

    /**
     * @var UserService
     */
    private $user;
    /**
     * @var ChatroomService
     */
    private $chatroomService;

    /**
     * @var NotificationService
     */
    private $notificationService;

    /**
     * @var UserTokenService
     */
    private $userTokenService;

    /**
     * @var UserNotificationService
     */
    private $userNotificationService;

    /**
     * @var ChatRepository
     */
    private $chat;

    /**
     * Create a new controller instance.
     *
     * @param UserService $user
     * @param ChatroomService $chatroomService
     * @param NotificationService $notificationService
     * @param UserTokenService $userTokenService
     * @param UserNotificationService $userNotificationService
     * @param ChatRepository $chat
     */
    public function __construct(
        UserService $user,
        ChatroomService $chatroomService,
        NotificationService $notificationService,
        UserTokenService $userTokenService,
        UserNotificationService $userNotificationService,
        ChatRepository $chat
    )
    {
        $this->user = $user;
        $this->chatroomService = $chatroomService;
        $this->notificationService = $notificationService;
        $this->userTokenService = $userTokenService;
        $this->userNotificationService = $userNotificationService;
        $this->chat = $chat;
    }

    public function index($params)
    {

        $chat = $this->chat->find($params);
        if (!$chat) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $chat,
        ];
    }

    public function show($id)
    {

        $chat = $this->chat->findByRoomId($id);
        if (!$chat) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $chat,
        ];
    }

    public function create($params, $roomId)
    {

        $validator = Validator::make($params, [
            'chat' => 'required|string',
            'is_system' => 'boolean',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $chatroom = $this->chatroomService->show($roomId);
        if ($chatroom['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'Chatroom not found'],
            ];
        }
        $chatroom = $chatroom['data'];
        $chatroom['date'] = Carbon::now()->format('Y-m-d\TH:i:s\Z');
        $chatroom['text'] = $params['chat'];
        if(!isset($params['is_system'])){
            $this->chatroomService->update($chatroom, $chatroom['id']);
        }

        $userIds = [];
        if(isset($chatroom['user_id']) && $params['user_id'] != $chatroom['user_id']) {
            array_push($userIds, $chatroom['user_id']);
        }
        if(isset($chatroom['vendor_user_id']) && $params['user_id'] != $chatroom['vendor_user_id']) {
            array_push($userIds, $chatroom['vendor_user_id']);
        }
        if(isset($chatroom['admin_user_id']) && $params['user_id'] != $chatroom['admin_user_id']) {
            array_push($userIds, $chatroom['admin_user_id']);
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

        $user = $this->user->show($params['user_id']);
        if ($user['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }
        $user = $user['data'];

        $params['room_id'] = $roomId;
        $params['user_type'] = $params['user_jwt_type'];        
        $params['user_email'] = $user['user_email'];
        $params['name'] = $user['display_name'];
        $params['created_at'] = Carbon::now()->format('Y-m-d\TH:i:s\Z');
        $newParams = ChatResource::toFirebase($params);
        $chat = $this->chat->create($newParams, $roomId);

        $this->notificationService->send($deviceTokens, array(
            "title" => "You have new message",
            "body" => $params['notification_chat'] ?? $params['chat'],
            "type" => "chat",
            "value" => [
                "chat_room" => $chatroom,
                "chat" => $chat
            ]
        ));

        foreach ($notificationUserIds as $notificationUserId) {
            $this->userNotificationService->store(['user_id' => $notificationUserId, 'text'=> $params['chat'], 'type' => 'chat', 'chat_room_id' => $roomId]);
        }

        return [
            'status' => 201,
            'data' => $chat,
        ];
    }

    public function readChat($params, $roomId)
    {

        $notification = $this->userNotificationService->destroyByParams(
            [
                'user_id' => $params['user_id'],
                'type' => 'chat',
                'chat_room_id' => $roomId
            ]
        );

        if (!$notification) {
            return [
                'status' => 200,
                'data' => ['message' => 'Already read the messages'],
            ];
        }

        return [
            'status' => 200,
            'data' => $notification,
        ];
    }


}