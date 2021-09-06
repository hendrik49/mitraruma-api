<?php

namespace App\Services;

use App\Exports\ConsultationExport;
use App\Exports\CustomerConsultationExport;
use App\Exports\VendorConsultationExport;
use App\Helpers\OrderStatus;
use App\Http\Resources\ConsultationResource;
use App\Repositories\ConsultationRepository;
use App\Repositories\ProjectRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ConsultationService
{

    /**
     * @var ConsultationRepository
     */
    private $consultation;

    /**
     * @var ChatroomService
     */
    private $chatroom;

    /**
     * @var ChatManagementService
     */
    private $chatManagement;

    /**
     * @var ChatService
     */
    private $chat;

    /**
     * @var ProjectRepository
     */
    private $project;

    /**
     * @var UserService
     */
    private $user;

    /**
     * @var OrderStatusService
     */
    private $orderStatus;

    /**
     * @var ConsultationResource
     */
    private $consultationResource;

    /**
     * @var OrderStatus
     */
    private $orderStatusHelper;

    /**
     * @var Validator
     */
    private $validator = [
        'user_id' => 'required|integer',
        'admin_user_id' => 'nullable|integer',
        'vendor_user_id' => 'nullable|integer',
        'description' => 'required|string',
        'photos' => 'array',
        'estimated_budget' => 'numeric',
        'contact' => 'required|string',
        'street' => 'required|string',
        'service_type' => 'nullable|string',
        'orderNumber' => 'integer',
        'orderStatus' => 'integer',
    ];

    /**
     * Create a new controller instance.
     *
     * @param ConsultationRepository $consultation
     * @param ChatroomService $chatroom
     * @param ChatManagementService $chatManagement
     * @param ChatService $chat
     * @param OrderStatusService $orderStatus
     * @param UserService $user
     * @param ConsultationResource $consultationResource
     */
    public function __construct(
        ConsultationRepository $consultation,
        ChatroomService $chatroom,
        ChatManagementService $chatManagement,
        ChatService $chat,
        OrderStatusService $orderStatus,
        UserService $user,
        ConsultationResource $consultationResource,
        OrderStatus $orderStatusHelper,
        ProjectRepository $project
    ) {
        $this->consultation = $consultation;
        $this->chatroom = $chatroom;
        $this->chatManagement = $chatManagement;
        $this->chat = $chat;
        $this->orderStatus = $orderStatus;
        $this->user = $user;
        $this->consultationResource = $consultationResource;
        $this->orderStatusHelper = $orderStatusHelper;
        $this->projectRepo = $project;
    }

    public function index($params)
    {

        $consultation = $this->consultation->find($params);
        if (!$consultation) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $consultation = $this->consultationResource->fromFirebaseArray($consultation);

        return [
            'status' => 200,
            'data' => $consultation,
        ];
    }

    public function top($params)
    {

        $consultation = $this->consultation->find($params);
        if (!$consultation) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $consultation = $this->consultationResource->fromFirebaseArray($consultation);

        return [
            'status' => 200,
            'data' => $consultation,
        ];
    }

    public function show($id)
    {

        $consultation = $this->consultation->findById($id);
        if (!$consultation) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $consultation = $this->consultationResource->fromFirebase($consultation);

        return [
            'status' => 200,
            'data' => $consultation,
        ];
    }

    public function count($params)
    {

        $consultation = $this->consultation->findCount($params);

        return [
            'status' => 200,
            'data' => ["consultation" => $consultation],
        ];
    }

    public function create($params)
    {

        $validator = Validator::make($params, $this->validator);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        //get user admin
        $userAdmin = $this->user->findOne(['user_type' => 'admin']);
        if ($userAdmin['status'] == 404) {
            return [
                'status' => 404,
                'data' => ['message' => 'admin user not found on database']
            ];
        }
        $userAdmin = $userAdmin['data'];

        //create consultation
        $params['admin_user_id'] = $userAdmin['ID'];
        $params['admin_name'] = $userAdmin['display_name'];
        $params['user_email'] = $params['user_jwt_email'];
        $params['display_name'] = $params['user_jwt_name'];
        $params['order_status'] = 120;
        $params['created_at'] = Carbon::now('GMT+7')->format('Y-m-d\TH:i:s\Z');
        $params['updated_at'] = Carbon::now('GMT+7')->format('Y-m-d\TH:i:s\Z');
        $params['order_number'] = mt_rand(1000000, 9999999);
        $newParams = $this->consultationResource->toFirebase($params);
        $consultation = $this->consultation->create($newParams);
        $consultation = $this->consultationResource->fromFirebase($consultation);

        //create chatroom
        $params['admin_user_id'] = $userAdmin['ID'];
        $params['consultation_id'] = $consultation['id'];
        $params['room_type'] = 'admin-customer';
        $params['status'] = 'pre-purchase';
        $params['image_url'] = $params['user_jwt_picture'] ?? "";
        $params['name'] =  $consultation['name'] . '-AC-' . $params['order_number'];
        $params['text'] = 'Hai Admin saya berminat untuk berkonsultasi';
        $params['consultation_description'] = $consultation['description'];
        $chatroom = $this->chatroom->create($params);
        $chatroom = $chatroom['data'];

        //create order status
        $initOrderStatus  = $this->orderStatusHelper->initOrderStatus();
        $this->orderStatus->update($initOrderStatus, $chatroom['id']);

        $chatParams['user_id'] = $params['user_id'];
        $chatParams['chat'] = $consultation['id'];
        $chatParams['notification_chat'] = 'Hai Admin saya berminat untuk berkonsultasi';
        $chatParams['is_system'] = true;
        $chatParams['room_id'] = $chatroom['id'];
        $this->chat->create($chatParams, $chatroom['id']);

        //create sql porjects
        $project = array();
        $project['order_number'] = $params['order_number'];
        $project['user_id'] = $params['user_id'];
        $project['consultation_id'] = $params['consultation_id'];
        $project['admin_user_id'] = $params['admin_user_id'];
        $project['admin_name'] =  $params['admin_name'];
        $project['room_id'] = $chatroom['id'];
        $project['room_number'] = 'AC-' . $chatroom['room_id'];
        $project['street'] =  $params['street'];
        $project['customer_name'] =  $params['user_jwt_name'];
        $project['customer_contact'] =  $params['contact'];
        $project['description'] = $params['description'];
        $project['status'] =  $params['status'];
        $project['sub_status'] = $params['status'];
        $project['estimated_budget'] = $params['estimated_budget'];
        $project['service_type'] = isset($params['service_type']) ? $params['service_type'] : 'SERVICE';
        $this->projectRepo->create($project);

        return [
            'status' => 201,
            'data' => $consultation,
        ];
    }

    public function update($params, $id)
    {

        $validator = Validator::make($params, $this->validator);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $consultation = $this->consultation->findById($id);
        if ($consultation == null) {
            return [
                'status' => 404,
                'data' => ['message' => "Consultation data not found"]
            ];
        }
        $consultation = $this->consultationResource->fromFirebase($consultation);

        $params['updated_at'] = Carbon::now('GMT+7')->format('Y-m-d\TH:i:s\Z');
        if (sizeof($params['photos']) == 0) {
            $params['photos'] = $consultation['photos'];
        }

        $params['admin_user_id'] = $consultation['admin_user_id'];
        $params['admin_name'] = $consultation['admin_name'];
        $params['user_id'] = $consultation['user_id'];
        $params['vendor_user_id'] = $consultation['vendor_user_id'];
        $params['vendor_name'] = $consultation['vendor_name'];
        $params['order_number'] =  $consultation['order_number'];
        $params['order_status'] =  $consultation['order_status'];
        $params['order_status_name'] =  $consultation['order_status_name'];
        $params['user_email'] =  $consultation['user_email'];

        $clearTerminParams = $this->clearDataConsultationTermin($params);
        $params = $this->buildDataConsultationTermin($clearTerminParams, $params);
        $newParams = $this->consultationResource->toFirebase($params);

        $consultation = $this->consultation->update($newParams, $id);
        $consultation = $this->consultationResource->fromFirebase($consultation);
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

    public function destroy($id)
    {

        $user = $this->user->show(1);
        if ($user['status'] != 200) {
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

    public function showStatus($id)
    {

        $params['consultation_id'] = $id;
        $consultation = $this->chatroom->showByFilter($params);
        if (!$consultation) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $consultationStatus = [];
        foreach ($consultation['data'] as $data) {
            if (!isset($data['roomId'])) continue;
            $orderStatus = $this->orderStatus->show($data['roomId']);
            if ($orderStatus['status'] == 200) {
                array_push($consultationStatus, ['room_type' => $data['roomType'], 'value' => $orderStatus['data']]);
            }
        }

        return [
            'status' => 200,
            'data' => $consultationStatus,
        ];
    }

    public function showChatFiles($id)
    {

        $params['consultation_id'] = $id;
        $consultation = $this->chatroom->showByFilter($params);
        if (!$consultation) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }
        $chatFiles = [];
        foreach ($consultation['data'] as $data) {
            if (!isset($data['roomId'])) continue;
            $chat = $this->chatManagement->showFilesById($data['roomId']);
            if ($chat['status'] == 200) {
                array_push($chatFiles, ['room_type' => $data['roomType'], 'value' => $chat['data']]);
            }
        }

        return [
            'status' => 200,
            'data' => $chatFiles,
        ];
    }

    public function export($params)
    {

        $consultation = $this->consultation->find($params);
        if (!$consultation) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $consultation = $this->consultationResource->fromFirebaseArray($consultation);
        foreach ($consultation as $indexConsul => $consul) {

            $chatrooms = $this->chatroom->showByFilter(["consultation_id" => $consul["id"]]);
            $chatroomFlag = false;
            $chatroomType = "";
            $chatroomIndex = 0;
            if ($chatrooms['status'] == 200) {
                $chatrooms = $chatrooms['data'];
                foreach ($chatrooms as $indexChatroom => $chatroom) {
                    if ($chatroom['room_type'] == 'admin-vendor-customer') {
                        $chatroomFlag = true;
                        $chatroomIndex = $indexChatroom;
                        break;
                    } elseif ($chatroom['room_type'] == 'admin-vendor') {
                        $chatroomFlag = true;
                        $chatroomType = $chatroom['room_type'];
                        $chatroomIndex = $indexChatroom;
                    } elseif ($chatroomType != 'admin-vendor') {
                        $chatroomFlag = true;
                        $chatroomIndex = $indexChatroom;
                    }
                }
            }

            if (!$chatroomFlag) continue;
            $orderStatus = $this->orderStatus->show($chatrooms[$chatroomIndex]['id']);
            foreach ($orderStatus['data'] as $status) {
                if (!isset($status['list'])) continue;
                if (sizeof($status['list']) > 0) {
                    $consultation[$indexConsul]['order_status_name'] = $status['phase'];
                }
                foreach ($status['list'] as $list) {
                    if (strtoupper($list['activity']) == strtoupper("Start of Conversation")) {
                        $consultation[$indexConsul]['inquiry_date'] = $list['createdAt'];
                    } elseif (strpos(strtoupper($list['activity']), strtoupper('Survey'))) {
                        if (!isset($consultation[$indexConsul]['survey_date'])) {
                            $consultation[$indexConsul]['survey_date'] = $list['activity'] . " \n";
                        } else {
                            $consultation[$indexConsul]['survey_date'] .= $list['activity'] . " \n";
                        }
                    } elseif (strtoupper($list['activity']) == strtoupper("quotation Uploaded")) {
                        $consultation[$indexConsul]['quotation'] = $list['createdAt'];
                    } elseif (strtoupper($list['activity']) == strtoupper("Build of Quantity (BOQ) Uploaded")) {
                        $consultation[$indexConsul]['design'] = $list['createdAt'];
                    } elseif (strtoupper($list['activity']) == strtoupper("Signed Contract Uploaded by Customer")) {
                        $consultation[$indexConsul]['project_start_date'] = $list['createdAt'];
                    } elseif (strtoupper($list['activity']) == strtoupper("Acceptance and Check List to Ended The Project")) {
                        $consultation[$indexConsul]['handover_date'] = $list['createdAt'];
                    } elseif (strtoupper($list['activity']) == strtoupper("Last Payment Paid by Admin")) {
                        $consultation[$indexConsul]['project_end_date'] = $list['createdAt'];
                    }
                }
            }
        }

        if (isset($params['user_id'])) {
            $export = new CustomerConsultationExport($consultation);
            return Excel::download($export, 'consultation.xlsx');
        }
        if (isset($params['vendor_user_id'])) {
            $export = new VendorConsultationExport($consultation);
            return Excel::download($export, 'consultation.xlsx');
        } else {
            $export = new ConsultationExport($consultation);
            return Excel::download($export, 'consultation.xlsx');
        }
    }

    private function clearDataConsultationTermin($consultation)
    {
        for ($i = 1; $i <= 6; $i++) {
            $consultation['termin_customer_percentage_' . $i] = 0;
            $consultation['termin_customer_' . $i] = 0;
            $consultation['termin_customer_date_' . $i] = '';
            $consultation['termin_vendor_percentage_' . $i] = 0;
            $consultation['termin_vendor_' . $i] = 0;
            $consultation['termin_vendor_date_' . $i] = '';
        }
        return $consultation;
    }

    private function buildDataConsultationTermin($consultationClear, $consultation)
    {
        if (isset($consultation['termin_customer_count'])) {
            for ($i = 1; $i <= $consultation['termin_customer_count']; $i++) {
                $consultationClear['termin_customer_percentage_' . $i] = $consultation['termin_customer_percentage_' . $i];
                $consultationClear['termin_customer_' . $i] = $consultation['termin_customer_' . $i];
                $consultationClear['termin_customer_date_' . $i] = $consultation['termin_customer_date_' . $i];
            }
        }
        if (isset($consultation['termin_vendor_count'])) {
            for ($i = 1; $i <= $consultation['termin_vendor_count']; $i++) {
                $consultationClear['termin_vendor_percentage_' . $i] = $consultation['termin_vendor_percentage_' . $i];
                $consultationClear['termin_vendor_' . $i] = $consultation['termin_vendor_' . $i];
                $consultationClear['termin_vendor_date_' . $i] = $consultation['termin_vendor_date_' . $i];
            }
        }
        return $consultationClear;
    }
}
