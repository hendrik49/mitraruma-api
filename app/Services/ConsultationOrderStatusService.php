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
     * Create a new controller instance.
     *
     * @param ConsultationRepository $consultationRepository
     * @param ConsultationResource $consultationResource
     * @param OrderStatus $orderStatus
     */
    public function __construct(
        ConsultationRepository $consultationRepository,
        ConsultationResource $consultationResource,
        OrderStatus $orderStatus
    )
    {
        $this->consultationRepository = $consultationRepository;
        $this->consultationResource = $consultationResource;
        $this->orderStatus = $orderStatus;
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
        $orderStatus  =$this->orderStatus->getConsultationStatus($consultation['order_status'], $userType);

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

        $consultation['orderStatus'] =  $params['order_status'];
        $consultation['updatedAt'] =  Carbon::now('GMT+7')->format('Y-m-d\TH:i:s\Z');

        $consultation = $this->consultationRepository->update($consultation, $id);

        $consultation = $this->consultationResource->fromFirebase($consultation);
        return [
            'status' => 200,
            'data' => $consultation,
        ];
    }

}