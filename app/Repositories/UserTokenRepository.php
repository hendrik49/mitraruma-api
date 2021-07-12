<?php

namespace App\Repositories;

use App\Models\WpUserToken;

class UserTokenRepository
{

    public function find($params){
        $userToken = WpUserToken::query();
        $userToken = $this->filterBuilder($userToken, $params);

        return $userToken->get();
    }

    public function findOne($params){
        $userToken = WpUserToken::query();
        $userToken = $this->filterBuilder($userToken, $params);

        return $userToken->first();
    }

    public function create($params) {
        return WpUserToken::create($params);
    }

    public function update($params, $id){

        $userToken = WpUserToken::where('id', $id)->first();
        if(!$userToken) {
            return  $userToken;
        }

        if(isset($params['device_token'])) {
            $userToken->device_token = $params['device_token'];
        }
        try {
            $userToken->save();
        }
        catch (\Throwable $e){
            report($e->getMessage());
        }

        return  $userToken;
    }

    public function deleteByParams($params, $id) {
        $userToken = WpUserToken::query();
        $userToken->where('id', $id);
        if(isset($params['user_id'])) {
            $userToken->where('user_id', $params['user_id']);

        }
        return $userToken->delete();
    }

    public function deleteById($id) {
        return WpUserToken::where('id', $id)->delete();
    }

    private function filterBuilder($model, $params) {

        if(isset($params['user_id'])) {
            $model = $model->where('user_id', '=', $params['user_id']);
        }
        if(isset($params['user_ids'])) {
            $model = $model->whereIn('user_id', $params['user_ids']);
        }

        return $model;

    }

}