<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class UserAddressService
{
    /**
     * @var UserService
     */
    private $user;

    /**
     * @var \App\Repositories\UserAddressAttributeRepository
     */
    private $userAddr;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserService  $user
     * @return void
     */
    public function __construct(
        UserService $user,
        \App\Repositories\UserAddressAttributeRepository $userAddr
    ) {
        $this->user = $user;
        $this->userAddr = $userAddr;
    }

    public function index($params){

        $address = $this->userAddr->find($params);
        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Address not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $address,
        ];
    }

    public function show($id){

        $address = $this->userAddr->findById($id);
        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Address not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $address,
        ];
    }

    public function create($params){

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

        $user = $this->user->show($params['user_id']);
        if($user['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }

        $address = $this->userAddr->create($params);

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

        $user = $this->user->show($params['user_id']);
        if($user['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }

        $address = $this->userAddr->update($params, $id);

        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Address not found'],
            ];
        }
        return [
            'status' => 200,
            'data' => $address,
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

        $address = $this->userAddr->deleteById($id);
        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Address not found'],
            ];
        }

        return [
            'status' => 202 ,
            'data' => ['message' => 'Success deleted data'],
        ];
    }


}