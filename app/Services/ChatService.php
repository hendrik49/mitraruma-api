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
        $chatroom['last_chat'] = $params['chat'];
        $this->chatroomService->update($chatroom, $chatroom['id']);

        $userIds = [];
        if(isset($chatroom['user_id']) && $params['user_id'] != $chatroom['user_id']) {
            array_push($userIds, $chatroom['user_id']);
        }
        if(isset($chatroom['applicator_id']) && $params['user_id'] != $chatroom['applicator_id']) {
            array_push($userIds, $chatroom['applicator_id']);
        }
        if(isset($chatroom['admin_id']) && $params['user_id'] != $chatroom['admin_id']) {
            array_push($userIds, $chatroom['admin_id']);
        }

        $tokens = $this->userTokenService->get(['user_ids' => $userIds]);
        if ($tokens['status'] == 200) {
            $tokens = $tokens['data'];
        }

        $deviceTokens = [];
        foreach ($tokens as $token) {
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
        $params['user_email'] = $user['user_email'];
        $params['name'] = $user['display_name'];
        $params['created_at'] = Carbon::now('GMT+7')->format('Y-m-d\TH:i:s\Z');
        $newParams = ChatResource::toFirebase($params);
        $chat = $this->chat->create($newParams, $roomId);

        $this->notificationService->send($deviceTokens, array(
            "title" => "You have new message",
            "body" => $params['chat'],
            "type" => "chat",
            "value" => [
                "chat_room" => $chatroom,
                "chat" => $chat
            ]
        ));

        $this->userNotificationService->store(['user_id' => $params['user_id'], 'type' => 'chat', 'chat_room_id' => $roomId]);

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