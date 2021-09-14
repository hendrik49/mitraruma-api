<?php

namespace App\Services;

class FirebaseService
{
    private $database;

    public function __construct()
    {
        $this->database = app('firebase.firestore')->database();
    }

    public function database($model)
    {
        return $this->database->collection($model);
    }

    public  function setChatroomIdtoUser($data)
    {
        return $this->database
            ->collection("accounts")
            ->document($data->roomId)            
            ->collection("chatroom");
    }

    public function setChatroomIdtoAdmin($data)
    {
        return $this->database
            ->collection("accounts")
            ->document($data->roomId)            
            ->collection("chatroom");
    }

    public function setChatroomIdtoApplicator($data)
    {
        return $this->database
            ->collection("accounts")
            ->document($data->roomId)
            ->collection("chatroom");
    }
}
