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
        return $this->model->document($id)->snapshot()->data();
    }

    public function find($params){

        $model = $this->model;
        if(isset($params['user_id'])) {
            $model = $model->where('userId', '=', 1);
        }
        $snapshot = $model->documents();

        $consultation = [];
        foreach ($snapshot as $document) {
            array_push($consultation, $document->data());
        }

        return $consultation;
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