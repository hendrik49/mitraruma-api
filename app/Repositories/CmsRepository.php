<?php

namespace App\Repositories;

use App\Models\WpCms;

class CmsRepository
{

    public function findById($id){
        return WpCms::where('ID', $id)->first();
    }

    public function find($params){
        $cms = WpCms::query();
        $cms = $this->filterBuilder($cms, $params);

        return $cms->get();
    }

    public function create($params) {
        return WpCms::create($params);
    }

    public function update($params, $id){

        $cms = WpCms::where('id', $id)->first();
        if(!$cms) {
            return  $cms;
        }

        if(isset($params['value'])) {
            $cms->value = $params['value'];
        }
        try {
            $cms->save();
        }
        catch (\Throwable $e){
            report($e->getMessage());
        }

        return  $cms;
    }

    public function deleteByParams($params, $id) {
        $cms = WpCms::query();
        $cms->where('id', $id);
        if(isset($params['user_id'])) {
            $cms->where('user_id', $params['user_id']);

        }
        return $cms->delete();
    }

    public function deleteById($id) {
        return WpCms::where('id', $id)->delete();
    }

    private function filterBuilder($model, $params) {

        if(isset($params['name'])) {
            $model = $model->where('name', '=', $params['name']);
        }
        // $model = $model->where('name', '<>', 'area-coverage');

        return $model;

    }

}