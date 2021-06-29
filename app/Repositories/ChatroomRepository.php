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
        if(isset($params['user_id'])) {
            $model = $model->where('userId', '=', 1);
        }
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
        return $this->model->newDocument()->set($params);
    }

    public function update($params, $id){
        return $this->model->document($id)->set($params);
    }

    public function deleteById($id) {
        return $this->model->document($id)->delete();
    }

}