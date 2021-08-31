<?php

namespace App\Repositories;

use App\Models\WpUserNotification;

class UserNotificationRepository
{

    public function findById($id){
        return WpUserNotification::where('ID', $id)->first();
    }

    public function find($params){
        $userNotification = WpUserNotification::query();
        $userNotification = $this->filterBuilder($userNotification, $params);

        return $userNotification->get();
    }

    public function count($params){
        $userNotification = WpUserNotification::query();
        $userNotification = $this->filterBuilder($userNotification, $params);

        return $userNotification->count();
    }

    public function create($params) {
        return WpUserNotification::create($params);
    }

    public function deleteByParams($params) {
        $userNotification = WpUserNotification::query();
        $userNotification =  $this->filterBuilder($userNotification, $params);
        $userNotification = $userNotification->delete();
        return $userNotification;
    }

    private function filterBuilder($model, $params) {

        if(isset($params['user_id'])) {
            $model = $model->where('user_id', '=', $params['user_id']);
        }
        if(isset($params['type'])) {
            $model = $model->where('type', '=', $params['type']);
        }
        if(isset($params['is_read'])) {
            $model = $model->where('is_read', '=', $params['is_read']);
        }
        if(isset($params['chat_room_id'])) {
            $model = $model->where('chat_room_id', '=', $params['chat_room_id']);
        }

        return $model;

    }

    public function update($params, $id){

        $notif = WpUserNotification::where('id', $id)->first();
        if(!$notif) {
            return  $notif;
        }

        if(isset($params['is_read'])) {
            $notif->is_read = $params['is_read'];
        }
        
        try {
            $notif->save();
        }
        catch (\Throwable $e){
            report($e->getMessage());
        }

        return  $notif;
    }

}