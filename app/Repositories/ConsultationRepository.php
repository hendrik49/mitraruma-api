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

    public function findById($id)
    {
        $model = $this->model->document($id)->snapshot();
        if ($model->data()) {
            $consultation = $model->data();
            $consultation['id'] = $model->id();
            return $consultation;
        }
        return null;
    }

    public function findCount($params)
    {

        $model = $this->model;
        $model = $this->filterBuilder($model, $params);
        $snapshot = $model->documents();

        $count = 0;
        foreach ($snapshot as $document) {
            $count++;
        }
        return $count;
    }

    public function find($params)
    {

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

    public function create($params)
    {
        $model = $this->model->newDocument();
        $model->set($params);
        
        $params['consultationId'] = $model->id();
        $this->model->document($model->id())->set($params);

        return $this->findById($model->id());
    }

    public function update($params, $id)
    {
        $this->model->document($id)->set($params);
        return $this->findById($id);
    }

    public function deleteById($id)
    {
        return $this->model->document($id)->delete();
    }

    private function filterBuilder($model, $params)
    {

        $model = $model->orderBy('createdAt', 'desc');
        if ($params['user_jwt_type'] == "admin")
            $model = $model->where('adminId', '=', (int)$params['user_id']);
        else if ($params['user_jwt_type'] == "vendor")
            $model = $model->where('applicatorId', '=', (int)$params['user_id']);
        else {
            $model = $model->where('userId', '=', (int)$params['user_id']);
        }
        if (isset($params['vendor_user_id'])) {
            $model = $model->where('applicatorId', '=',(int) $params['vendor_user_id']);
        }
        if (isset($params['consultation_id'])) {
            $model = $model->where('consultationId', '=', (int)$params['consultation_id']);
        }
        if (isset($params['order_number'])) {
            $model = $model->where('orderNumber', '=', (int) $params['order_number']);
        }
        if (isset($params['user_email'])) {
            $model = $model->where('email', '>=', $params['user_email']);
            $model = $model->where('email', '<', $params['user_email'] . 'z');
        }
        if (isset($params['limit'])) {
            $model = $model->limit($params['limit'] ?? 10);
        }
        if (isset($params['start_after'])) {
            $model = $model->startAfter([$params['start_after'] ?? '']);
        }
        if (isset($params['end_before'])) {
            $model = $model->endBefore([$params['end_before'] ?? '']);
            $model = $model->limitToLast($params['limit'] ?? 10);
        }


        return $model;
    }
}
