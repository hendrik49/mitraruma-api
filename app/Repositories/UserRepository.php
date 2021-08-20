<?php

namespace App\Repositories;

use App\Models\WpUser;

class UserRepository
{

    public function find($params){
        $user = WpUser::query();
        $user = $this->filterBuilder($user, $params);
        return $user->get();
    }

    public function findById($id){
        return WpUser::where('ID', $id)->first();
    }

    public function findOne($params){
        $user = WpUser::query();
        $user = $this->filterBuilder($user, $params);
        return $user->first();
    }

    public function count($params){
        $user = WpUser::query();
        $user = $this->filterBuilder($user, $params);
        return $user->count();
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

    public function deleteById($id) {
        return WpUser::where('id', $id)->delete();
    }

    private function filterBuilder($model, $params) {

        if(isset($params['user_email'])) {
            $model->where('user_email', $params['user_email']);
        }
        if(isset($params['user_phone_number'])) {
            $model->where('user_phone_number', $params['user_phone_number']);
        }
        if(isset($params['user_type'])) {
            $model->where('user_type', $params['user_type']);
        }

        return $model;

    }

}