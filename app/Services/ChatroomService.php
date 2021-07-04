<?php

namespace App\Services;

use App\Http\Resources\ChatroomResource;
use Illuminate\Support\Facades\Validator;

class ChatroomService
{
    /**
     * @var \App\Repositories\ChatroomRepository
     */
    private $chatroom;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserService $user
     * @param  \App\Repositories\ChatroomRepository $chatroom
     * @return void
     */
    public function __construct(
        \App\Services\UserService $user,
        \App\Repositories\ChatroomRepository $chatroom
    ) {
        $this->user = $user;
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

        return [
            'status' => 200,
            'data' => $chatroom,
        ];
    }

    public function create($params){

        $validator = Validator::make($params, [
            'admin_id' => 'integer',
            'vendor_user_id' => 'integer',
            'user_id' => 'required|integer',
            'consultation_id' => 'required|string',
            'date' => 'date',
            'image_url' => 'string',
            'is_approve' => 'boolean',
            'name' => 'string',
            'room_type' => 'required|string',
            'status' => 'required|string',
            'text' => 'required|string'
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
        $newParams = ChatroomResource::toFirebase($params);
        $chatroom = $this->chatroom->create($newParams);

        return [
            'status' => 201,
            'data' => $chatroom,
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
        $newParams = ChatroomResource::toFirebase($params);
        $chatroom = $this->chatroom->update($params, $id);
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


}