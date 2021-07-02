<?php

namespace App\Services;

use App\Repositories\OrderStatusRepository;
use Illuminate\Support\Facades\Validator;

class OrderStatusService
{

    /**
     * @var orderStatusRepository
     */
    private $orderStatus;

    /**
     * @var UserService
     */
    private $user;

    /**
     * Create a new controller instance.
     *
     * @param  OrderStatusRepository $orderStatus
     * @param UserService $user
     * @return void
     */
    public function __construct(
        OrderStatusRepository $orderStatus,
        UserService $user
    ) {
        $this->orderStatus = $orderStatus;
        $this->user = $user;
    }

    public function index($params){

        $orderStatus = $this->orderStatus->find($params);
        if (!$orderStatus) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $orderStatus,
        ];
    }

    public function show($id){

        $orderStatus = $this->orderStatus->findById($id);
        if (!$orderStatus) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $orderStatus,
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

        $params['user_email'] = $user['data']['user_email'];
        $params['display_name'] = $user['data']['display_name'];
        $orderStatus =$this->orderStatus->create($params);

        return [
            'status' => 201,
            'data' => $orderStatus,
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
        $orderStatus = $this->orderStatus->update($params, $id);
        if (!$orderStatus) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $orderStatus,
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

        $orderStatus = $this->orderStatus->deleteById($id);
        if (!$orderStatus) {
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