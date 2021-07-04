<?php

namespace App\Repositories;

class ConsultationRepository
{

    private $model;

    public function __construct(
        \App\Services\FirebaseService $firebase
    ) {
        $this->model = $firebase->database('consultation');
    }

    public function findById($id){
        $model = $this->model->document($id)->snapshot();
        if($model->data()){
            $consultation = $model->data();
            $consultation['id'] = $model->id();
            return $consultation;
        }
        return null;
    }

    public function find($params){

        $model = $this->model;
        $model = $this->filterBuilder($model, $params);
        $snapshot = $model->documents();

        $consultations = [];
        foreach ($snapshot as $document) {
            $consultation = $document->data();
            $consultation['id'] = $document->id();
            array_push($consultations, $consultation);
        }

        return $consultations;
    }

    public function create($params) {
        $model = $this->model->newDocument();
        $model->set($params);
        return $this->findById($model->id());
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
        if(isset($params['start_after'])) {
            $model = $model->orderBy('consultationId');
            $model = $model->startAfter([$params['start_after'] ?? '']);
        }
        if(isset($params['end_at'])) {
            $model = $model->endAt([$params['end_at'] ?? '']);
        }

        return $model;

    }

}