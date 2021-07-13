<?php

namespace App\Services;

use App\Http\Resources\ChatResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ChatManagementService
{
    /**
     * @var \App\Repositories\ChatRepository
     */
    private $chat;

    /**
     * @var NotificationService
     */
    private $notificationService;

    /**
     * @var UserService
     */
    private $user;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserService $user
     * @param  \App\Services\NotificationService $notificationService
     * @param  \App\Repositories\ChatRepository $chat
     * @return void
     */
    public function __construct(
        \App\Services\UserService $user,
        \App\Services\NotificationService $notificationService,
        \App\Repositories\ChatRepository $chat
    ) {
        $this->user = $user;
        $this->notificationService = $notificationService;
        $this->chat = $chat;
    }

    public function showLatest($id)
    {

        $chat = $this->chat->findLastChatByRoomId($id);
        if (!$chat) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $chat[0],
        ];
    }

    public function showFilesById($id){

        $chat = $this->chat->findFilesByRoomId($id);
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


}