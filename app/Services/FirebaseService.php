<?php

namespace App\Services;

class FirebaseService
{
    private $database;

    public function __construct()
    {
        $this->database = app('firebase.firestore')->database();
    }

    public function database($model) {
        return $this->database->collection($model);
    }

}
