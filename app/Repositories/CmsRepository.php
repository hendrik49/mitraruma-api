<?php

namespace App\Repositories;

use App\Models\WpCms;

class CmsRepository
{

    public function findById($id){
        return WpCms::where('ID', $id)->first();
    }

    public function find($params){
        $userExt = WpCms::query();

        return $userExt->get();
    }

    public function create($params) {
        return WpCms::create($params);
    }

    public function update($params, $id){

        $userExt = WpCms::where('id', $id)->first();
        if(!$userExt) {
            return  $userExt;
        }

        if(isset($params['value'])) {
            $userExt->value = $params['value'];
        }
        try {
            $userExt->save();
        }
        catch (\Throwable $e){
            report($e->getMessage());
        }

        return  $userExt;
    }

    public function deleteByParams($params, $id) {
        $userExt = WpCms::query();
        $userExt->where('id', $id);
        if(isset($params['user_id'])) {
            $userExt->where('user_id', $params['user_id']);

        }
        return $userExt->delete();
    }

    public function deleteById($id) {
        return WpCms::where('id', $id)->delete();
    }

}