<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class ProjectService
{
    /**
     * @var ProjectService
     */
    private $project;

    /**
     * @var \App\Repositories\ProjectRepository
     */
    private $projectService;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\ProjectService  $project
     * @return void
     */
    public function __construct(
        \App\Repositories\ProjectRepository $projectService
    ) {
        $this->projectService = $projectService;
    }

    public function index($params)
    {

        $address = $this->projectService->find($params);
        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Project not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $address,
        ];
    }

    public function findOne($params)
    {

        $address = $this->projectService->findOne($params);
        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Project not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $address,
        ];
    }

    public function show($id)
    {

        $address = $this->projectService->findById($id);
        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Project not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $address,
        ];
    }

    public function showByConsultation($id)
    {

        $address = $this->projectService->findByConsultationId($id);
        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Project not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $address,
        ];
    }

    public function create($params)
    {

        $validator = Validator::make($params, [
            'order_number' => 'required|numeric',
            'room_id' => 'required|string',
            'street' => 'required|string',
            'customer_name' => 'required|string',
            'customer_contact' => 'required|string',
            'description' => 'required|string',
            'status' => 'required',
            'sub_status' => 'required',
            'estimated_budget' => 'required',
            'service_type' => 'required|string'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $project = $this->projectService->find($params['project_id']);
        if ($project == null) {
            return [
                'status' => 404,
                'data' => ['message' => 'Project not found'],
            ];
        }

        $address = $this->projectService->create($params);

        return [
            'status' => 201,
            'data' => $address,
        ];
    }

    public function createChat($params)
    {

        $validator = Validator::make($params, [
            'order_number' => 'required|numeric',
            'room_id' => 'required|string',
            'user_id' => 'required',
            'street' => 'required|string',
            'customer_name' => 'required|string',
            'customer_contact' => 'required|string',
            'description' => 'required|string',
            'status' => 'required',
            'sub_status' => 'required',
            'estimated_budget' => 'required',
            'service_type' => 'required|string'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }
        $params['images'] = json_encode($params['images']);
        $address = $this->projectService->create($params);

        return [
            'status' => 201,
            'data' => $address,
        ];
    }

    public function updateChat($params)
    {

        $validator = Validator::make($params, [
            'vendor_user_id' => 'required',
            'consultation_id' => 'required|exists:wp_projects,consultation_id',
            'status' => 'required',
            'sub_status' => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }
        $address = $this->projectService->updateByConsulId($params, $params['consultation_id']);

        return [
            'status' => 201,
            'data' => $address,
        ];
    }

    public function update($params, $id)
    {

        $validator = Validator::make($params, [
            'city' => 'required|string',
            'zipcode' => 'nullable|string',
            'street' => 'required|string',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $project = $this->projectService->find($id);
        if ($project == null) {
            $project = $this->projectService->create($params);
        } else {

            $project = $this->projectService->update($params, $id);
        }
        if (!$project) {
            return [
                'status' => 404,
                'data' => ['message' => 'Project not found'],
            ];
        }
        return [
            'status' => 200,
            'data' => $project,
        ];
    }

    public function destroy($id)
    {

        $project = $this->projectService->find($id);
        if ($project == null) {
            return [
                'status' => 404,
                'data' => ['message' => 'Project not found'],
            ];
        }

        $address = $this->projectService->deleteById($id);
        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Project not found'],
            ];
        }

        return [
            'status' => 202,
            'data' => ['message' => 'Success deleted data'],
        ];
    }
}
