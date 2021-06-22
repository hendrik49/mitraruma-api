<?php

namespace App\Repositories;

use App\Models\WpUserExtensionAttribute;

class UserExtensionAttributeRepository
{

    public function findById($id){
        return WpUserExtensionAttribute::where('ID', $id)->first();
    }

    public function find($params){
        $userExt = WpUserExtensionAttribute::query();
        if(isset($params['user_id'])) {
            $userExt->where('user_id', $params['user_id']);
        }
        return $userExt->get();
    }

    public function create($params) {
        return WpUserExtensionAttribute::create($params);
    }

    public function update($params, $id){

        $userExt = WpUserExtensionAttribute::where('id', $id)->first();
        if(!$userExt) {
            return  $userExt;
        }

        if(isset($params['value'])) {
            $params['value'] =  json_encode($params['value']);
            $userExt->value = $params['value'];
        }
        try {
            $userExt->save();
        }
        catch (\Throwable $e){
            report($e->getMessage());
        }

        $userExt['value'] = json_decode($userExt['value']);

        return  $userExt;
    }

    public function deleteByParams($params, $id) {
        $userExt = WpUserExtensionAttribute::query();
        $userExt->where('id', $id);
        if(isset($params['user_id'])) {
            $userExt->where('user_id', $params['user_id']);

        }
        return $userExt->delete();
    }

    public function deleteById($id) {
        return WpUserExtensionAttribute::where('id', $id)->delete();
    }

}