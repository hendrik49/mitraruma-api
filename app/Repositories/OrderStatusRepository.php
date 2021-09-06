<?php

namespace App\Repositories;

class OrderStatusRepository
{

    private $model;

    public function __construct(
        \App\Services\FirebaseService $firebase
    ) {
        $this->model = $firebase->database('orderStatus');
    }

    public function findById($id){
        $model = $this->model->document($id)->snapshot();
        
        if($model->data()){
            $consultationStatus = $model->data();
            ksort($consultationStatus);
            return $consultationStatus;
        }
        return null;
    }

    public function find($params){

        $model = $this->model;
        $model = $this->filterBuilder($model, $params);
        $snapshot = $model->documents();

        $consultationStatuss = [];
        foreach ($snapshot as $document) {
            $consultationStatus = $document->data();
            $consultationStatus['id'] = $document->id();
            array_push($consultationStatuss, $consultationStatus);
        }

        return $consultationStatuss;
    }

    public function create($params) {
        return $this->model->newDocument()->set($params);
    }

    public function update($params, $id){
        return $this->model->document($id)->set($params);
    }

    public function deleteById($id) {
        return $this->model->document($id)->delete();
    }

    private function filterBuilder($model, $params) {

        if(isset($params['user_id'])) {
            $model = $model->where('userId', '=', $params['user_id']);
        }
        if(isset($params['consultation_id'])) {
            $model = $model->where('consultationId', '=', $params['consultation_id']);
        }
        $model = $model->limit($params['limit'] ?? 10);
        $model = $model->orderBy('roomId');
        $model = $model->startAfter([$params['start_after'] ?? '']);

        return $model;

    }

}