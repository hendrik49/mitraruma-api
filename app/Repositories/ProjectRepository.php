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
        if(isset($params['room_id'])) {
            $Project->room_id = $params['room_id'];
        }
        if(isset($params['vendor_name'])) {
            $Project->vendor_name = $params['vendor_name'];
        }
        if(isset($params['vendor_email'])) {
            $Project->vendor_email = $params['vendor_email'];
        }
        if(isset($params['vendor_user_id'])) {
            $Project->vendor_user_id = $params['vendor_user_id'];
        }
        if(isset($params['vendor_contact'])) {
            $Project->vendor_contact = $params['vendor_contact'];
        }
        if(isset($params['room_type'])) {
            $Project->room_type = $params['room_type'];
        }
        
        try {
            $Project->save();
        }
        catch (\Throwable $e){
            report($e->getMessage());
        }

        return  $Project;
    }

    public function updateByConsulId($params, $id){

        $Project = WpProject::where('consultation_id', $id)->first();
        if(!$Project) {
            return  $Project;
        }

        if(isset($params['vendor_user_id'])) {
            $Project->vendor_user_id = $params['vendor_user_id'];
        }
        if(isset($params['room_id'])) {
            $Project->room_id = $params['room_id'];
        }
        if(isset($params['status'])) {
            $Project->status= $params['status'];
        }
        if(isset($params['sub_status'])) {
            $Project->sub_status= $params['sub_status'];
        }

        if(isset($params['phase'])) {
            $Project->status= $params['phase'];
        }
        if(isset($params['order_status'])) {
            $Project->sub_status = $params['order_status'];
            $Project->updated_at = date('Y-m-d H:i:s');
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
        if(isset($params['vendor_user_id'])) {
            $model = $model->where('vendor_user_id', '=', $params['vendor_user_id']);
        }
        if(isset($params['consultation_id'])) {
            $model = $model->where('consultation_id', '=', $params['consultation_id']);
        }
        if(isset($params['room_type'])) {
            $model = $model->where('room_type', '=', $params['room_type']);
        }

        return $model;

    }

}