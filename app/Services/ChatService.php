<?php

namespace App\Services;

use App\Http\Resources\ChatResource;
use Illuminate\Support\Facades\Validator;

class ChatService
{
    /**
     * @var \App\Repositories\ChatRepository
     */
    private $chat;
    /**
     * @var UserService
     */
    private $user;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserService $user
     * @param  \App\Repositories\ChatRepository $chat
     * @return void
     */
    public function __construct(
        \App\Services\UserService $user,
        \App\Repositories\ChatRepository $chat
    ) {
        $this->user = $user;
        $this->chat = $chat;
    }

    public function index($params){

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

    public function show($id){

        $chat = $this->chat->findById($id);
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

    public function create($params, $roomId){

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

        $user = $this->user->show($params['user_id']);
        if($user['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }
        $user = $user['data'];

        $params['room_id'] = $roomId;
        $params['user_email'] = $user['user_email'];
        $params['name'] = $user['display_name'];
        $newParams = ChatResource::toFirebase($params);
        $chat = $this->chat->create($newParams, $roomId);

        return [
            'status' => 201,
            'data' => $chat,
        ];
    }

    public function update($params, $id){

        $validator = Validator::make($params, [
            'name' => 'required|string',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $user = $this->user->show($params['user_id']);
        if($user['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }

        $params['user_email'] = $user['data']['user_email'];
        $chat = $this->chat->update($params, $id);
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

    public function destroy($id){

        $user = $this->user->show(1);
        if($user['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }

        $chat = $this->chat->deleteById($id);
        if (!$chat) {
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

    public function showFilesById($id){

        $chat = $this->chat->findFilesById($id);
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