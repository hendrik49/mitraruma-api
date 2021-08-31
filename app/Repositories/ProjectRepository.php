<?php

namespace App\Repositories;

use App\Models\WpProject;

class ProjectRepository
{

    public function findById($id){
        return WpProject::find($id);
    }

    public function findByConsultationId($id){
        return WpProject::where('consultation_id',$id)->first();
    }

    public function find($params){
        $Project = WpProject::query();
        $Project = $this->filterBuilder($Project, $params);

        return $Project->get();
    }

    public function findOne($params){
        $Project = WpProject::query();
        $Project = $this->filterBuilder($Project, $params);

        return $Project->first();
    }

    public function create($params) {
        return WpProject::create($params);
    }

    public function update($params, $id){

        $Project = WpProject::where('id', $id)->first();
        if(!$Project) {
            return  $Project;
        }

        if(isset($params['device_token'])) {
            $Project->device_token = $params['device_token'];
        }
        if(isset($params['room_number'])) {
            $Project->room_number = $params['room_number'];
        }
        if(isset($params['vendor_name'])) {
            $Project->vendor_name = $params['vendor_name'];
        }
        if(isset($params['vendor_user_id'])) {
            $Project->vendor_user_id = $params['vendor_user_id'];
        }
        if(isset($params['vendor_contact'])) {
            $Project->vendor_contact = $params['vendor_contact'];
        }
        
        try {
            $Project->save();
        }
        catch (\Throwable $e){
            report($e->getMessage());
        }

        return  $Project;
    }

    public function deleteByParams($params, $id) {
        $Project = WpProject::query();
        $Project->where('id', $id);
        if(isset($params['user_id'])) {
            $Project->where('user_id', $params['user_id']);

        }
        return $Project->delete();
    }

    public function deleteById($id) {
        return WpProject::where('id', $id)->delete();
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