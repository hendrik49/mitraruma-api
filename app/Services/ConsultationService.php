<?php

namespace App\Services;

use App\Http\Resources\ConsultationResource;
use App\Repositories\ConsultationRepository;
use Illuminate\Support\Facades\Validator;

class ConsultationService
{

    /**
     * @var ConsultationRepository
     */
    private $consultation;

    /**
     * @var ChatroomService
     */
    private $chatroom;

    /**
     * @var ChatService
     */
    private $chat;

    /**
     * @var UserService
     */
    private $user;

    /**
     * @var OrderStatusService
     */
    private $orderStatus;

    /**
     * Create a new controller instance.
     *
     * @param ConsultationRepository $consultation
     * @param ChatroomService $chatroom
     * @param ChatService $chat
     * @param OrderStatusService $orderStatus
     * @param UserService $user
     * @return void
     */
    public function __construct(
        ConsultationRepository $consultation,
        ChatroomService $chatroom,
        ChatService $chat,
        OrderStatusService $orderStatus,
        UserService $user
    )
    {
        $this->consultation = $consultation;
        $this->chatroom = $chatroom;
        $this->chat = $chat;
        $this->orderStatus = $orderStatus;
        $this->user = $user;
    }

    public function index($params)
    {

        $consultation = $this->consultation->find($params);
        if (!$consultation) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $consultation = ConsultationResource::fromFirebaseArray($consultation);

        return [
            'status' => 200,
            'data' => $consultation,
        ];
    }

    public function show($id)
    {

        $consultation = $this->consultation->findById($id);
        if (!$consultation) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $consultation = ConsultationResource::fromFirebase($consultation);

        return [
            'status' => 200,
            'data' => $consultation,
        ];
    }

    public function count($params)
    {

        $consultation = $this->consultation->findCount($params);

        return [
            'status' => 200,
            'data' => ["consultation" => $consultation],
        ];
    }

    public function create($params)
    {

        $validator = Validator::make($params, [
            'user_id' => 'required|integer',
            'vendor_user_id' => 'integer',
            'description' => 'required|string',
            'photos' => 'array',
            'estimated_budget' => 'numeric',
            'contact' => 'required|string',
            'city' => 'required|string',
            'zipcode' => 'string',
            'street' => 'required|string',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $user = $this->user->show($params['user_id']);
        if ($user['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }
        $user = $user['data'];

        $params['user_email'] = $user['user_email'];
        $params['display_name'] = $user['display_name'];
        $newParams = ConsultationResource::toFirebase($params);
        $consultation = $this->consultation->create($newParams);

        $params['consultation_id'] = $consultation['id'];
        $params['room_type'] = 'admin-customer';
        $params['status'] = 'Pre-Purchase';
        $params['image_url'] = $user['user_picture_url'] ?? "";
        $params['text'] = 'Hai Admin saya berminat untuk berkonsultasi';
        $chatroom = $this->chatroom->create($params);
        $chatroom = $chatroom['data'];

        $chatParams['user_id'] = $user['ID'];
        $chatParams['chat'] = $consultation['id'];
        $chatParams['is_system'] = true;
        $chatParams['room_id'] = $chatroom['id'];
        $chat = $this->chat->create($chatParams, $chatroom['id']);

        return [
            'status' => 201,
            'data' => $consultation,
        ];
    }

    public function update($params, $id)
    {

        $validator = Validator::make($params, [
            'user_id' => 'required|integer',
            'vendor_user_id' => 'integer',
            'description' => 'required|string',
            'photos' => 'array',
            'estimated_budget' => 'numeric',
            'contact' => 'required|string',
            'city' => 'required|string',
            'zipcode' => 'string',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $user = $this->user->show($params['user_id']);
        if ($user['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }

        $params['email'] = $user['data']['user_email'];
        $consultation = $this->consultation->update($params, $id);
        if (!$consultation) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $consultation,
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

        $consultation = $this->consultation->deleteById($id);
        if (!$consultation) {
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

    public function showStatus($id)
    {

        $params['consultation_id'] = $id;
        $consultation = $this->chatroom->showByFilter($params);
        if (!$consultation) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $consultationStatus = [];
        foreach ($consultation['data'] as $data) {
            if(!isset($data['roomId'])) continue;
            $orderStatus = $this->orderStatus->show($data['roomId']);
            if ($orderStatus['status'] == 200) {
                array_push($consultationStatus, ['room_type' => $data['roomType'], 'value' => $orderStatus['data']]);
            }
        }

        return [
            'status' => 200,
            'data' => $consultationStatus,
        ];
    }

    public function showChatFiles($id)
    {

        $params['consultation_id'] = $id;
        $consultation = $this->chatroom->showByFilter($params);
        if (!$consultation) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }
        $chatFiles = [];
        foreach ($consultation['data'] as $data) {
            if(!isset($data['roomId'])) continue;
            $chat = $this->chat->showFilesById($data['roomId']);
            if ($chat['status'] == 200) {
                array_push($chatFiles, ['room_type' => $data['roomType'], 'value' => $chat['data']]);
            }
        }

        return [
            'status' => 200,
            'data' => $chatFiles,
        ];
    }


}