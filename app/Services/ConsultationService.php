<?php

namespace App\Services;

use App\Exports\ConsultationExport;
use App\Exports\CustomerConsultationExport;
use App\Exports\VendorConsultationExport;
use App\Http\Resources\ConsultationResource;
use App\Repositories\ConsultationRepository;
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
     * @var UserService
     */
    private $user;

    /**
     * @var OrderStatusService
     */
    private $orderStatus;

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
        'orderNumber' => 'integer',
        'orderStatus' => 'integer',
    ];

    /**
     * Create a new controller instance.
     *
     * @param ConsultationRepository $consultation
     * @param ChatroomService $chatroom
     * @param ChatManagementService $chatManagement
     * @param OrderStatusService $orderStatus
     * @param UserService $user
     * @return void
     */
    public function __construct(
        ConsultationRepository $consultation,
        ChatroomService $chatroom,
        ChatManagementService $chatManagement,
        ChatService $chat,
        OrderStatusService $orderStatus,
        UserService $user
    )
    {
        $this->consultation = $consultation;
        $this->chatroom = $chatroom;
        $this->chatManagement = $chatManagement;
        $this->chat = $chat;
        $this->orderStatus = $orderStatus;
        $this->user = $user;
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

        $consultation = ConsultationResource::fromFirebaseArray($consultation);

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

        $consultation = ConsultationResource::fromFirebase($consultation);

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

        $user = $this->user->show($params['user_id']);
        if ($user['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }
        $user = $user['data'];

        //get user admin
        $userAdmin = $this->user->findOne(['user_type' => 'admin']);
        $userAdmin = $userAdmin['data'];

        //create consultation
        $params['admin_user_id'] = $userAdmin['ID'];
        $params['admin_name'] = $userAdmin['display_name'];
        $params['user_email'] = $user['user_email'];
        $params['display_name'] = $user['display_name'];
        $params['created_at'] = Carbon::now('GMT+7')->format('Y-m-d\TH:i:s\Z');
        $params['updated_at'] = Carbon::now('GMT+7')->format('Y-m-d\TH:i:s\Z');
        $params['order_number'] = mt_rand(1000000, 9999999);
        $newParams = ConsultationResource::toFirebase($params);
        $consultation = $this->consultation->create($newParams);
        $consultation = ConsultationResource::fromFirebase($consultation);

        //create chatroom
        $params['admin_user_id'] = $userAdmin['ID'];
        $params['consultation_id'] = $consultation['id'];
        $params['room_type'] = 'admin-customer';
        $params['status'] = 'Pre-Purchase';
        $params['image_url'] = $user['user_picture_url'] ?? "";
        $params['name'] = $user['display_name'].'-AC-'.Carbon::now('GMT+7')->format('dmHi');
        $params['text'] = 'Hai Admin saya berminat untuk berkonsultasi';
        $params['consultation_description'] = $consultation['description'];
        $chatroom = $this->chatroom->create($params);
        $chatroom = $chatroom['data'];

        $chatParams['user_id'] = $user['ID'];
        $chatParams['chat'] = $consultation['id'];
        $chatParams['notification_chat'] = 'Hai Admin saya berminat untuk berkonsultasi';
        $chatParams['is_system'] = true;
        $chatParams['room_id'] = $chatroom['id'];
        $this->chat->create($chatParams, $chatroom['id']);

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

        $params['updated_at'] = Carbon::now('GMT+7')->format('Y-m-d\TH:i:s\Z');
        $clearTerminParams = $this->clearDataConsultationTermin($params);
        $params = $this->buildDataConsultationTermin($clearTerminParams, $params);
        $newParams = ConsultationResource::toFirebase($params);

        $consultation = $this->consultation->update($newParams, $id);
        $consultation = ConsultationResource::fromFirebase($consultation);
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
            if(!isset($data['roomId'])) continue;
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
            if(!isset($data['roomId'])) continue;
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

        $consultation = ConsultationResource::fromFirebaseArray($consultation);
        foreach ($consultation as $indexConsul => $consul) {

            $chatrooms = $this->chatroom->showByFilter(["consultation_id" => $consul["id"]]);
            $chatroomFlag = false;
            $chatroomType = "";
            $chatroomIndex = 0;
            if($chatrooms['status'] == 200) {
                $chatrooms = $chatrooms['data'];
                foreach ($chatrooms as $indexChatroom => $chatroom) {
                    if($chatroom['room_type'] == 'admin-vendor-customer') {
                        $chatroomFlag =true;
                        $chatroomIndex = $indexChatroom;
                        break;
                    }
                    elseif ($chatroom['room_type'] == 'admin-vendor') {
                        $chatroomFlag =true;
                        $chatroomType = $chatroom['room_type'];
                        $chatroomIndex = $indexChatroom;
                    }
                    elseif($chatroomType != 'admin-vendor') {
                        $chatroomFlag =true;
                        $chatroomIndex = $indexChatroom;
                    }
                }
            }

            if (!$chatroomFlag) continue;
            $orderStatus = $this->orderStatus->show($chatrooms[$chatroomIndex]['id']);
            foreach ($orderStatus['data'] as $status) {
                $consultation[$indexConsul]['order_status_name'] = $status['phase'];
                foreach ($status['list'] as $list) {
                    if(strtoupper($list['activity']) == strtoupper("Start of Conversation")){
                        $consultation[$indexConsul]['inquiry_date'] = $list['createdAt'];
                    }
                    elseif(strpos(strtoupper($list['activity']), strtoupper('Survey'))){
                        if(!isset($consultation[$indexConsul]['survey_date'])) {
                            $consultation[$indexConsul]['survey_date'] = $list['activity']." \n";
                        }
                        else {
                            $consultation[$indexConsul]['survey_date'] .= $list['activity']." \n";
                        }
                    }
                    elseif(strtoupper($list['activity']) == strtoupper("quotation Uploaded")){
                        $consultation[$indexConsul]['quotation'] = $list['createdAt'];
                    }
                    elseif(strtoupper($list['activity']) == strtoupper("Build of Quantity (BOQ) Uploaded")){
                        $consultation[$indexConsul]['design'] = $list['createdAt'];
                    }
                    elseif(strtoupper($list['activity']) == strtoupper("Signed Contract Uploaded by Customer")){
                        $consultation[$indexConsul]['project_start_date'] = $list['createdAt'];
                    }
                    elseif(strtoupper($list['activity']) == strtoupper("Acceptance and Check List to Ended The Project")){
                        $consultation[$indexConsul]['handover_date'] = $list['createdAt'];
                    }
                    elseif(strtoupper($list['activity']) == strtoupper("Last Payment Paid by Admin")){
                        $consultation[$indexConsul]['project_end_date'] = $list['createdAt'];
                    }
                }
            }
        }

        if(isset($params['user_id'])) {
            $export = new CustomerConsultationExport($consultation);
            return Excel::download($export, 'consultation.xlsx');
        }
        if(isset($params['vendor_user_id'])) {
            $export = new VendorConsultationExport($consultation);
            return Excel::download($export, 'consultation.xlsx');
        }
        else{
            $export = new ConsultationExport($consultation);
            return Excel::download($export, 'consultation.xlsx');
        }

    }

    private function clearDataConsultationTermin($consultation) {
        for($i=1; $i<=6; $i++) {
            $consultation['termin_customer_percentage_'.$i] = 0;
            $consultation['termin_customer_'.$i] = 0;
            $consultation['termin_customer_date_'.$i] = '';
            $consultation['termin_vendor_percentage_'.$i] = 0;
            $consultation['termin_vendor_'.$i] = 0;
            $consultation['termin_vendor_date_'.$i] = '';
        }
        return $consultation;
    }

    private function buildDataConsultationTermin($consultationClear, $consultation) {
        for($i=1; $i<=$consultation['termin_customer_count']; $i++) {
            $consultationClear['termin_customer_percentage_'.$i] = $consultation['termin_customer_percentage_'.$i];
            $consultationClear['termin_customer_'.$i] = $consultation['termin_customer_'.$i];
            $consultationClear['termin_customer_date_'.$i] = $consultation['termin_customer_date_'.$i];
        }
        for($i=1; $i<=$consultation['termin_vendor_count']; $i++) {
            $consultationClear['termin_vendor_percentage_'.$i] = $consultation['termin_vendor_percentage_'.$i];
            $consultationClear['termin_vendor_'.$i] = $consultation['termin_vendor_'.$i];
            $consultationClear['termin_vendor_date_'.$i] = $consultation['termin_vendor_date_'.$i];
        }
        return $consultationClear;
    }


}