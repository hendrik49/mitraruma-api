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

        $orderStatus =$this->orderStatus->create($params);

        return [
            'status' => 201,
            'data' => $orderStatus,
        ];
    }

    public function update($params, $id){

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