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
        if(isset($params['user_id'])) {
            $model = $model->where('userId', '=', 1);
        }
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
        return $this->model->newDocument()->set($params);
    }

    public function update($params, $id){
        return $this->model->document($id)->set($params);
    }

    public function deleteById($id) {
        return $this->model->document($id)->delete();
    }

}