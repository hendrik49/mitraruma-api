<?php

namespace App\Repositories;

use App\Helpers\FieldConverter;

class ChatRepository
{

    private $model;

    public function __construct(
        \App\Services\FirebaseService $firebase
    ) {
        $this->firebase = $firebase;
        $this->model = $firebase->database('chat');
    }

    public function findByRoomId($roomId)
    {
        $model = $this->firebase->database("chat/$roomId/data");
        $model = $model->orderBy('createdAt');
        $result = $model->documents();
        $chat = [];
        foreach ($result as $value) {
            $data = $value->data();
            array_push($chat, $data);
        }
        $chat = FieldConverter::keysToUnderscore($chat);
        return $chat;
    }   

    public function findFilesByRoomId($id)
    {
        $model = $this->firebase->database("chat/$id/data");
        $model = $model->where('file', '!=', 'null');
        $result = $model->documents();
        $chat = [];
        foreach ($result as $value) {
            $data = $value->data();
            array_push($chat, $data);
        }
        return $chat;
    }

    public function findByRoomIdAndId($roomId, $id)
    {
        $model = $this->firebase->database("chat/$roomId/data")->document($id)->snapshot();
        if ($model->data()) {
            $chat = $model->data();
            $chat['id'] = $model->id();
            return $chat;
        }
        return null;
    }

    public function findLastChatByRoomId($id)
    {
        $model = $this->firebase->database("chat/$id/data");
        $model = $model->orderBy('createdAt', 'DESC');
        $model = $model->limit(1);
        $result = $model->documents();
        $chat = [];
        foreach ($result as $value) {
            $data = $value->data();
            array_push($chat, $data);
        }
        return $chat;
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

    public function create($params, $roomId)
    {
        $model = $this->model->document($roomId);
        $chat = $model->collection('data')->newDocument();
        $chat->set($params);
        return $this->findByRoomIdAndId($roomId, $chat->id());
    }

    public function update($params, $id)
    {
        return $this->model->document($id)->set($params);
    }

    public function deleteById($id)
    {
        return $this->model->document($id)->delete();
    }

    private function filterBuilder($model, $params)
    {

        if (isset($params['user_id'])) {
            $model = $model->where('userId', '=', $params['user_id']);
        }
        if (isset($params['consultation_id'])) {
            $model = $model->where('consultationId', '=', $params['consultation_id']);
        }
        $model = $model->limit($params['limit'] ?? 10);
        $model = $model->orderBy('roomId');
        $model = $model->startAfter([$params['start_after'] ?? '']);

        return $model;
    }
}
