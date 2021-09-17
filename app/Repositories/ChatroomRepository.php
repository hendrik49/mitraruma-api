<?php

namespace App\Repositories;

class ChatroomRepository
{

    private $model;

    public function __construct(
        \App\Services\FirebaseService $firebase
    ) {
        $this->model = $firebase->database('chatroom');
        $this->modelAccounts = $firebase->database('accounts');
        $this->firebase = $firebase;
    }

    public function findById($id)
    {
        $model = $this->model->document($id)->snapshot();
        if ($model->data()) {
            $chatroom = $model->data();
            $chatroom['id'] = $model->id();
            return $chatroom;
        }
        return null;
    }

    public function deleteById($id)
    {
        return $this->model->document($id)->delete();
    }

    public function find($params)
    {

        $model = $this->model;
        $model = $this->filterBuilder($model, $params);
        $snapshot = $model->documents();

        $chatrooms = [];
        foreach ($snapshot as $document) {
            $chatroom = $document->data();
            $chatroom['id'] = $document->id();
            array_push($chatrooms, $chatroom);
        }

        return $chatrooms;
    }

    public function create($params)
    {
        $model = $this->model->document($params['roomId']);
        $model->set($params);

        if ($params['roomType'] == "admin-customer") {
            $modelUser = $this->modelAccounts->document($params['userId']);
            $room = $modelUser->collection('chatroom')->newDocument();
            $roomNew = array();
            $roomNew['roomId'] = $model->id();
            $room->set($roomNew);

            $modelAdmin = $this->modelAccounts->document($params['adminId']);
            $roomAdmin = $modelAdmin->collection('chatroom')->newDocument();
            $roomNew = array();
            $roomNew['roomId'] = $model->id();
            $roomAdmin->set($roomNew);
        }else if ($params['roomType'] == "admin-vendor") {
            $modelUser = $this->modelAccounts->document($params['applicatorId']);
            $room = $modelUser->collection('chatroom')->newDocument();
            $roomNew = array();
            $roomNew['roomId'] = $model->id();
            $room->set($roomNew);

            $modelAdmin = $this->modelAccounts->document($params['adminId']);
            $roomAdmin = $modelAdmin->collection('chatroom')->newDocument();
            $roomNew = array();
            $roomNew['roomId'] = $model->id();
            $roomAdmin->set($roomNew);
        }else{

            $modelUser = $this->modelAccounts->document($params['userId']);
            $room = $modelUser->collection('chatroom')->newDocument();
            $roomNew = array();
            $roomNew['roomId'] = $model->id();
            $room->set($roomNew);

            $modelV = $this->modelAccounts->document($params['applicatorId']);
            $roomV = $modelV->collection('chatroom')->newDocument();
            $roomNew = array();
            $roomNew['roomId'] = $model->id();
            $roomV->set($roomNew);

            $modelAdmin = $this->modelAccounts->document($params['adminId']);
            $roomAdmin = $modelAdmin->collection('chatroom')->newDocument();
            $roomNew = array();
            $roomNew['roomId'] = $model->id();
            $roomAdmin->set($roomNew);
        }

        return $this->findById($model->id());
    }

    public function update($params, $id){
        $this->model->document($id)->set($params);
        return $this->findById($id);
    }

    private function filterBuilder($model, $params)
    {

        $model = $model->orderBy('date', 'desc');

        if (isset($params['user_id'])) {
            $model = $model->where('userId', '=', $params['user_id']);
        }
        if (isset($params['vendor_user_id'])) {
            $model = $model->where('applicatorId', '=', $params['vendor_user_id']);
        }
        if (isset($params['consultation_id'])) {
            $model = $model->where('consultationId', '=', $params['consultation_id']);
        }
        if (isset($params['room_type'])) {
            $model = $model->where('roomType', '=', $params['room_type']);
        }
        $model = $model->limit($params['limit'] ?? 10);
        if (isset($params['start_after'])) {
            $model = $model->startAfter([$params['start_after'] ?? '']);
        }

        return $model;
    }
}
