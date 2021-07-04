<?php

namespace App\Repositories;

class ChatRepository
{

    private $model;

    public function __construct(
        \App\Services\FirebaseService $firebase
    ) {
        $this->firebase = $firebase;
        $this->model = $firebase->database('chat');
    }

    public function findById($roomId){
        $model = $this->firebase->database("chat/$roomId/data");
        $result = $model->documents();
        $chat = [];
        foreach ($result as $value) {
            $data = $value->data();
            array_push($chat, $data);
        }
        return $chat;
    }

    public function findFilesById($id){
        $model = $this->firebase->database("chat/$id/data");
        $model = $model->where('file' ,'!=', 'null');
        $result = $model->documents();
        $chat = [];
        foreach ($result as $value) {
            $data = $value->data();
            array_push($chat, $data);
        }
        return $chat;
    }

    public function find($params){

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

    public function create($params, $roomId) {
        $model = $this->model->document($roomId);
        $model->collection('data')->newDocument()->set($params);
        return $this->findById($roomId);
    }

    public function update($params, $id){
        return $this->model->document($id)->set($params);
    }

    public function deleteById($id) {
        return $this->model->document($id)->delete();
    }

    private function filterBuilder($model, $params) {

        if(isset($params['user_id'])) {
            $model = $model->where('userId', '=', $params['user_id']);
        }
        if(isset($params['consultation_id'])) {
            $model = $model->where('consultationId', '=', $params['consultation_id']);
        }
        $model = $model->limit($params['limit'] ?? 10);
        $model = $model->orderBy('roomId');
        $model = $model->startAfter([$params['start_after'] ?? '']);

        return $model;

    }

}