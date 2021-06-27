<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class ConsultationService
{
    /**
     * @var UserService
     */
    private $user;

    /**
     * @var \App\Repositories\ConsultationRepository
     */
    private $consultation;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserService $user
     * @param  \App\Repositories\ConsultationRepository $consultation
     * @return void
     */
    public function __construct(
        \App\Services\UserService $user,
        \App\Repositories\ConsultationRepository $consultation
    ) {
        $this->user = $user;
        $this->consultation = $consultation;
    }

    public function index($params){

        $consultation = $this->consultation->find($params);
        if (!$consultation) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $consultation,
        ];
    }

    public function show($id){

        $consultation = $this->consultation->findById($id);
        if (!$consultation) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $consultation,
        ];
    }

    public function create($params){

        $validator = Validator::make($params, [
            'user_id' => 'required|integer',
            'vendor_user_id' => 'integer',
            'description' => 'required|string',
            'photos' => 'array',
            'estimated_budget' => 'numeric',
            'contact' => 'required|string',
            'city' => 'required|string',
            'zipcode' => 'required|string',
            'address' => 'required|string',
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

        $params['email'] = $user['data']['user_email'];
        $extensionAttribute =$this->consultation->create($params);

        return [
            'status' => 201,
            'data' => $extensionAttribute,
        ];
    }

    public function update($params, $id){

        $validator = Validator::make($params, [
            'user_id' => 'required|integer',
            'vendor_user_id' => 'integer',
            'description' => 'required|string',
            'photos' => 'array',
            'estimated_budget' => 'numeric',
            'contact' => 'required|string',
            'city' => 'required|string',
            'zipcode' => 'required|string',
            'address' => 'required|string',
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

        $params['email'] = $user['data']['user_email'];
        $consultation = $this->consultation->update($params, $id);
        if (!$consultation) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $consultation,
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

        $consultation = $this->consultation->deleteById($id);
        if (!$consultation) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 202,
            'data' => ['message' => 'Success deleted data'],
        ];

    }


}