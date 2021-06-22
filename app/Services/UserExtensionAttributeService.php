<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class UserExtensionAttributeService
{
    /**
     * @var UserService
     */
    private $user;
    /**
     * @var \App\Repositories\UserExtensionAttributeRepository
     */
    private $userExt;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserService  $user
     * @param  \App\Repositories\UserExtensionAttributeRepository $userExt
     * @return void
     */
    public function __construct(
        UserService $user,
        \App\Repositories\UserExtensionAttributeRepository $userExt
    ) {
        $this->user = $user;
        $this->userExt = $userExt;
    }

    public function index($params){

        $address = $this->userExt->find($params);
        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $address,
        ];
    }

    public function show($id){

        $address = $this->userExt->findById($id);
        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $address,
        ];
    }

    public function create($params){

        $validator = Validator::make($params, [
            'name' => 'required|string',
            'value' => 'required',
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

        $params['value'] =  json_encode($params['value']);
        $extensionAttribute =$this->userExt->create($params);

        $extensionAttribute['value'] = json_decode($extensionAttribute['value']);
        return [
            'status' => 201,
            'data' => $extensionAttribute,
        ];
    }

    public function update($params, $id){

        $validator = Validator::make($params, [
            'name' => 'required|string',
            'value' => 'required',
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

        $extensionAttribute = $this->userExt->update($params, $id);
        if (!$extensionAttribute) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $extensionAttribute,
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

        $extensionAttribute = $this->userExt->deleteById($id);
        if (!$extensionAttribute) {
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