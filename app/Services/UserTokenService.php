<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class UserTokenService
{
    /**
     * @var UserService
     */
    private $user;

    /**
     * @var \App\Repositories\UserTokenRepository
     */
    private $userToken;

    /**
     * Create a new controller instance.
     *
     * @param UserService $user
     * @param \App\Repositories\UserTokenRepository $userToken
     */
    public function __construct(
        \App\Services\UserService $user,
        \App\Repositories\UserTokenRepository $userToken
    ) {
        $this->user = $user;
        $this->userToken = $userToken;
    }

    public function get($params){

        $userToken = $this->userToken->find($params);
        if(!$userToken) {
            return [
                'status' => 400,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $userToken,
        ];
    }

    public function store($params){

        $validator = Validator::make($params, [
            'device_token' => 'required|string',
            'user_id' => 'required|int',
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

        $userToken = $this->userToken->findOne($params);
        if($userToken) {
            $userToken = $this->userToken->update($params, $userToken['id']);
        }
        else {
            $userToken = $this->userToken->create($params);
        }

        return [
            'status' => 200,
            'data' => $userToken,
        ];
    }

    public function destroy($id){

        $cms = $this->userToken->deleteById($id);
        if (!$cms) {
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