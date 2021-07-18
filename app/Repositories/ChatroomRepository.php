<?php

namespace App\Repositories;

class ChatroomRepository
{

    private $model;

    public function __construct(
        \App\Services\FirebaseService $firebase
    ) {
        $this->model = $firebase->database('chatroom');
    }

    public function findById($id){
        $model = $this->model->document($id)->snapshot();
        if($model->data()){
            $chatroom = $model->data();
            $chatroom['id'] = $model->id();
            return $chatroom;
        }
        return null;
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

    public function create($params) {
        $model = $this->model->newDocument();
        $model->set($params);
        return $this->findById($model->id());
    }

    public function update($params, $id){
        return $this->model->document($id)->set($params);
    }

    public function deleteById($id) {
        return $this->model->document($id)->delete();
    }

    private function filterBuilder($model, $params) {

        $model = $model->orderBy('createdAt' , 'desc');

        if(isset($params['user_id'])) {
            $model = $model->where('userId', '=', $params['user_id']);
        }
        if(isset($params['consultation_id'])) {
            $model = $model->where('consultationId', '=', $params['consultation_id']);
        }
        if(isset($params['room_type'])) {
            $model = $model->where('roomType', '=', $params['room_type']);
        }
        $model = $model->limit($params['limit'] ?? 10);
        if(isset($params['start_after'])) {
            $model = $model->startAfter([$params['start_after'] ?? '']);
        }

        return $model;

    }

}