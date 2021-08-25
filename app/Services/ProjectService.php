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

    public function index($params){

        $address = $this->projectService->find($params);
        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Serviceess not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $address,
        ];
    }

    public function show($id){

        $address = $this->projectService->findById($id);
        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Serviceess not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $address,
        ];
    }

    public function create($params){

        $validator = Validator::make($params, [
            'order_number' => 'required|numeric',
            'room_id' => 'required|string',
            'street' => 'required|string',
            'customer_name' => 'required|string',
            'customer_contact' => 'required|string',
            'description' => 'required|string',
            'status' => 'required',
            'substatus' => 'required',
            'estimated_budget'=> 'required',
            'service_type' => 'required|string'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $project = $this->project->show($params['project_id']);
        if($project['status'] != 200) {
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

    public function update($params, $id){

        $validator = Validator::make($params, [
            'city' => 'required|string',
            'zipcode' => 'required|string',
            'street' => 'required|string',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $project = $this->project->show($params['project_id']);
        if($project['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'Project not found'],
            ];
        }

        $address = $this->projectService->update($params, $id);

        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Serviceess not found'],
            ];
        }
        return [
            'status' => 200,
            'data' => $address,
        ];
    }

    public function destroy($id){

        $project = $this->project->show(1);
        if($project['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'Project not found'],
            ];
        }

        $address = $this->projectService->deleteById($id);
        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Serviceess not found'],
            ];
        }

        return [
            'status' => 202 ,
            'data' => ['message' => 'Success deleted data'],
        ];
    }


}