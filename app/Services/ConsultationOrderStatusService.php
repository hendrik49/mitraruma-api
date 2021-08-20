<?php

namespace App\Services;

use App\Helpers\OrderStatus;
use App\Http\Resources\ConsultationResource;
use App\Repositories\ConsultationRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ConsultationOrderStatusService
{
    /**
     * @var OrderStatus|OrderStatusService
     */
    private $orderStatus;

    /**
     * @var ConsultationResource
     */
    private $consultationResource;

    /**
     * @var ConsultationRepository
     */
    private $consultationRepository;

    /**
     * @var OrderStatusService
     */
    private $orderStatusService;

    /**
     * @var OrderStatus
     */
    private $orderStatusHelper;

    /**
     * @var UserNotificationService
     */
    private $userNotificationService;

    /**
     * Create a new controller instance.
     *
     * @param ConsultationRepository $consultationRepository
     * @param ConsultationResource $consultationResource
     * @param OrderStatusService $orderStatusService
     * @param OrderStatus $orderStatusHelper
     * @param UserNotificationService $userNotificationService
     */
    public function __construct(
        ConsultationRepository $consultationRepository,
        ConsultationResource $consultationResource,
        OrderStatusService $orderStatusService,
        OrderStatus $orderStatusHelper,
        UserNotificationService $userNotificationService
    )
    {
        $this->consultationRepository = $consultationRepository;
        $this->consultationResource = $consultationResource;
        $this->orderStatusService = $orderStatusService;
        $this->orderStatusHelper = $orderStatusHelper;
        $this->userNotificationService = $userNotificationService;
    }

    public function show($id, $userType = 'customer')
    {

        $consultation = $this->consultationRepository->findById($id);
        if (!$consultation) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $consultation = $this->consultationResource->fromFirebase($consultation);
        $orderStatus = $this->orderStatus->getConsultationStatus($consultation['order_status'], $userType);

        return [
            'status' => 200,
            'data' => $orderStatus,
        ];
    }


    public function update($params, $id)
    {

        $validator = Validator::make($params, [
            'order_status' => 'integer|required'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $consultation = $this->consultationRepository->findById($id);
        if (!$consultation) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $consultation['orderStatus'] = $params['order_status'];
        $consultation['updatedAt'] = Carbon::now('GMT+7')->format('Y-m-d\TH:i:s\Z');

        $consultation = $this->consultationRepository->update($consultation, $id);

        $consultation = $this->consultationResource->fromFirebase($consultation);

        $orderStatus = $this->orderStatusService->show($params['chatroom_id']);
        $orderStatus = $orderStatus['data'];
        $newOrderStatus = $this->orderStatusHelper->getOrderStatusByCode($params['order_status']);
        foreach ($orderStatus as $keyOrderStatus => $keyOrderValue) {
            if ($keyOrderValue['phase'] == $newOrderStatus['phase']) {
                array_push($orderStatus[$keyOrderStatus]['list'], ["activity" => $newOrderStatus['activity'], 'createdAt' => Carbon::now('GMT+7')->format('Y-m-d\TH:i:s\Z')]);
            }
        }
        $this->orderStatusService->update($orderStatus, $params['chatroom_id']);

        $userIds = [];
        if (isset($consultation['user_id']) && $params['user_id'] != $consultation['user_id']) {
            array_push($userIds, $consultation['user_id']);
        }
        if (isset($consultation['vendor_user_id']) && $params['user_id'] != $consultation['vendor_user_id']) {
            array_push($userIds, $consultation['vendor_user_id']);
        }
        if (isset($consultation['admin_user_id']) && $params['user_id'] != $consultation['admin_user_id']) {
            array_push($userIds, $consultation['admin_user_id']);
        }

        foreach ($userIds as $userId) {
            $this->userNotificationService->store(['user_id' => $userId, 'type' => 'notification', 'text' => $newOrderStatus['activity'] ,'chat_room_id' => $params['chatroom_id']]);
        }

        return [
            'status' => 200,
            'data' => $consultation,
        ];
    }

}