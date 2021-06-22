<?php

namespace App\Repositories;

use App\Models\WpUserAddress;

class UserAddressAttributeRepository
{

    public function findById($id){
        return WpUserAddress::where('ID', $id)->first();
    }

    public function find($params){
        $userExt = WpUserAddress::query();
        if(isset($params['user_id'])) {
            $userExt->where('user_id', $params['user_id']);
        }
        return $userExt->get();
    }

    public function create($params) {
        return WpUserAddress::create($params);
    }

    public function update($params, $id){

        $userExt = WpUserAddress::where('id', $id)->first();
        if(!$userExt) {
            return  $userExt;
        }

        if(isset($params['province'])) {
            $userExt->province = $params['province'];
        }
        if(isset($params['city'])) {
            $userExt->city = $params['city'];
        }
        if(isset($params['district'])) {
            $userExt->district = $params['district'];
        }
        if(isset($params['subdistrict'])) {
            $userExt->subdistrict = $params['subdistrict'];
        }
        if(isset($params['zipcode'])) {
            $userExt->zipcode = $params['zipcode'];
        }
        if(isset($params['street'])) {
            $userExt->street = $params['street'];
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
        $userExt = WpUserAddress::query();
        $userExt->where('id', $id);
        if(isset($params['user_id'])) {
            $userExt->where('user_id', $params['user_id']);

        }
        return $userExt->delete();
    }

    public function deleteById($id) {
        return WpUserAddress::where('id', $id)->delete();
    }

}