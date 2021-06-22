<?php

namespace App\Repositories;

use App\Models\WpUser;

class UserRepository
{

    public function findById($id){
        return WpUser::where('ID', $id)->first();
    }

    public function findOne($params){
        $user = WpUser::query();
        if(isset($params['user_email'])) {
            $user->where('user_email', $params['user_email']);
        }
        if(isset($params['user_phone_number'])) {
            $user->where('user_phone_number', $params['user_phone_number']);
        }
        return $user->first();
    }

    public function create($params) {
        return WpUser::create($params);
    }

    public function update($params, $id){

        $user = WpUser::where('id', $id)->first();
        if(!$user) {
            return  $user;
        }

        if(isset($params['user_email'])) {
            $user->user_email = $params['user_email'];
        }
        if(isset($params['user_phone_number'])) {
            $user->user_phone_number = $params['user_phone_number'];
        }
        if(isset($params['display_name'])) {
            $user->display_name = $params['display_name'];
        }
        try {
            $user->save();
        }
        catch (\Throwable $e){
            report($e->getMessage());
        }

        return  $user;
    }

}