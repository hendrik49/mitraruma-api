<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class ProjectService
{
    /**
     * @var UserService
     */
    private $user;

    /**
     * @var \App\Repositories\ProjectRepository
     */
    private $project;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserService  $user
     * @return void
     */
    public function __construct(
        UserService $user,
        \App\Repositories\ProjectRepository $project
    ) {
        $this->user = $user;
        $this->project = $project;
    }

    public function index($params){

        $project = $this->project->find($params);
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

    public function show($id){

        $project = $this->project->findById($id);
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

    public function create($params){

        $validator = Validator::make($params, [
            'user_id' => 'required|integer',
            'vendor_user_id' => 'integer',
            'description' => 'required|string',
            'images' => 'array',
            'estimated_budget' => 'numeric',
            'customer_name' => 'required|string',
            'customer_contact' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'sub_district' => 'required|string',
            'zipcode' => 'required|string',
            'street' => 'required|string',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $user = $this->user->show($params['user_id']);
        if($user['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }

        $params['status'] = 'PRE-PURCHASE';
        $params['sub_status'] = 'Start of conversation';
        $project = $this->project->create($params);

        return [
            'status' => 201,
            'data' => $project,
        ];
    }

    public function update($params, $id){

        $validator = Validator::make($params, [
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'sub_district' => 'required|string',
            'zipcode' => 'required|string',
            'street' => 'required|string',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $user = $this->user->show($params['user_id']);
        if($user['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }

        $project = $this->project->update($params, $id);

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

    public function destroy($id){

        $user = $this->user->show(1);
        if($user['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }

        $project = $this->project->deleteById($id);
        if (!$project) {
            return [
                'status' => 404,
                'data' => ['message' => 'Project not found'],
            ];
        }

        return [
            'status' => 202 ,
            'data' => ['message' => 'Success deleted data'],
        ];
    }


}