<?php

namespace App\Repositories;

use App\Models\WpProject;

class ProjectRepository
{

    public function findById($id){
        return WpProject::where('ID', $id)->first();
    }

    public function find($params){
        $userExt = WpProject::query();
        if(isset($params['user_id'])) {
            $userExt->where('user_id', $params['user_id']);
        }
        return $userExt->get();
    }

    public function create($params) {
        return WpProject::create($params);
    }

    public function update($params, $id){

        $userExt = WpProject::where('id', $id)->first();
        if(!$userExt) {
            return  $userExt;
        }

        if(isset($params['description'])) {
            $userExt->description = $params['description'];
        }
        if(isset($params['estimated_budget'])) {
            $userExt->estimated_budget = $params['estimated_budget'];
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
        if(isset($params['sub_district'])) {
            $userExt->sub_district = $params['sub_district'];
        }
        if(isset($params['zipcode'])) {
            $userExt->zipcode = $params['zipcode'];
        }
        if(isset($params['street'])) {
            $userExt->street = $params['street'];
        }
        if(isset($params['status'])) {
            $userExt->status = $params['status'];
        }
        if(isset($params['sub_status'])) {
            $userExt->sub_status = $params['sub_status'];
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
        $userExt = WpProject::query();
        $userExt->where('id', $id);
        if(isset($params['user_id'])) {
            $userExt->where('user_id', $params['user_id']);

        }
        return $userExt->delete();
    }

    public function deleteById($id) {
        return WpProject::where('id', $id)->delete();
    }

}