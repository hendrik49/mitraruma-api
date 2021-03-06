<?php

namespace App\Services;

use App\Http\Resources\ChatroomResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Helpers\OrderStatus;
use App\Repositories\ProjectRepository;
use App\Http\Resources\ConsultationResource;
use App\Repositories\ConsultationRepository;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Http;

class ChatroomService
{
    /**
     * @var UserService
     */
    private $user;

    /**
     * @var UserNotificationService
     */
    private $userNotification;

    /**
     * @var ChatManagementService
     */
    private $chatManagement;

    /**
     * @var \App\Repositories\ChatroomRepository
     */
    private $chatroom;

    /**
     * @var OrderStatusService
     */
    private $orderStatusService;

    /**
     * @var OrderStatus
     */
    private $orderStatusHelper;

    /**
     * @var ProjectRepository
     */
    private $projectRepo;

    /**
     * @var NotificationService
     */
    private $notificationService;

    /**
     * @var UserTokenService
     */
    private $userTokenService;

    /**
     * @var ConsultationRepository
     */
    private $consultation;


    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserService $user
     * @param  \App\Services\UserNotificationService $userNotification
     * @param  \App\Services\ChatManagementService $chatManagement
     * @param  \App\Repositories\ChatroomRepository $chatroom
     * @return void
     */
    public function __construct(
        \App\Services\UserService $user,
        \App\Services\UserNotificationService $userNotification,
        \App\Services\ChatManagementService $chatManagement,
        \App\Repositories\ChatroomRepository $chatroom,
        OrderStatusService $orderStatusService,
        OrderStatus $orderStatusHelper,
        ProjectRepository $project,
        NotificationService $notificationService,
        UserTokenService $userTokenService,
        ConsultationRepository $consultation
    ) {
        $this->user = $user;
        $this->userNotification = $userNotification;
        $this->chatManagement = $chatManagement;
        $this->chatroom = $chatroom;
        $this->orderStatusService = $orderStatusService;
        $this->orderStatusHelper = $orderStatusHelper;
        $this->projectRepo = $project;
        $this->notificationService = $notificationService;
        $this->userTokenService = $userTokenService;
        $this->consultation = $consultation;
        $this->userNotificationService = $userNotification;
    }

    public function index($params)
    {

        $chatroom = $this->chatroom->find($params);
        if (!$chatroom) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $chatroom = ChatroomResource::fromFirebaseArray($chatroom);

        foreach ($chatroom as $key => $data) {
            $chatroom[$key]['unread_chat'] = $this->userNotification->getCount(['user_id' => $params['user_id'] ?? null, 'type' => 'chat', 'chat_room_id' => $data['id']])['data'];
        }

        return [
            'status' => 200,
            'data' => $chatroom,
        ];
    }

    public function show($id)
    {

        $chatroom = $this->chatroom->findById($id);
        if (!$chatroom) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $chatroom = ChatroomResource::fromFirebase($chatroom);

        return [
            'status' => 200,
            'data' => $chatroom,
        ];
    }

    public function create($params)
    {

        $validator = Validator::make($params, [
            'admin_user_id' => 'nullable|integer',
            'vendor_user_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'consultation_id' => 'required|string',
            'date' => 'date',
            'image_url' => 'string',
            'is_approve' => 'boolean',
            'name' => 'string',
            'room_type' => 'required|string',
            'status' => 'required|string',
            'text' => 'string'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $dateNow =  Carbon::now()->format('Y-m-d\TH:i:s\Z');
        $params['room_id'] = mt_rand(1000000, 9999999);
        $params['date'] = $dateNow;
        $params['created_at'] = $dateNow;
        $newParams = ChatroomResource::toFirebase($params);
        $chatroom = $this->chatroom->create($newParams);
        $chatroom = ChatroomResource::fromFirebase($chatroom);

        return [
            'status' => 201,
            'data' => $chatroom,
        ];
    }

    public function update($params, $id)
    {

        $validator = Validator::make($params, [
            'name' => 'string',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $newParams = ChatroomResource::toFirebase($params);
        $chatroom = $this->chatroom->update($newParams, $id);
        $chatroom = ChatroomResource::fromFirebase($chatroom);

        if (!$chatroom) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $chatroom,
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

        $chatroom = $this->chatroom->deleteById($id);
        if (!$chatroom) {
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

    public function showByFilter($params)
    {

        $chatroom = $this->chatroom->find($params);
        if (!$chatroom) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }
        $chatroom = ChatroomResource::fromFirebaseArray($chatroom);

        return [
            'status' => 200,
            'data' => $chatroom,
        ];
    }

    public function showUsers($id)
    {

        $chatroom = $this->chatroom->findById($id);
        if (!$chatroom) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $chatroom = ChatroomResource::fromFirebase($chatroom);

        $user = [];
        if (isset($chatroom['user_id'])) {
            $userData = $this->user->show($chatroom['user_id']);
            $userData['status'] == 200 ? array_push($user, $this->user->show($chatroom['user_id'])['data']) : null;
        }
        if (isset($chatroom['vendor_user_id'])) {
            $vendorData = $this->user->show($chatroom['vendor_user_id']);
            $vendorData['status'] == 200 ? array_push($user, $this->user->show($chatroom['vendor_user_id'])['data']) : null;
        }
        if (isset($chatroom['admin_user_id'])) {
            $adminData = $this->user->show($chatroom['admin_user_id']);
            $adminData['status'] == 200 ? array_push($user, $this->user->show($chatroom['admin_user_id'])['data']) : null;
        }

        return [
            'status' => 200,
            'data' => $user,
        ];
    }

    public function showChatFiles($id)
    {
        $chatroom = $this->chatroom->findById($id);

        $chat = $this->chatManagement->showFilesById($chatroom['id']);

        $chatFiles = [];
        if ($chat['status'] == 200) {
            $chatFiles =  $chat['data'];
        }

        return [
            'status' => 200,
            'data' => $chatFiles,
        ];
    }

    public function showOrderStatus($id)
    {

        $orderStatus = $this->orderStatusService->show($id);

        if ($orderStatus['status'] == 404) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $orderStatus = $orderStatus['data'];

        return [
            'status' => 200,
            'data' => $orderStatus
        ];
    }

    public function showOrderStatusSelection($name, $userType = 'customer')
    {

        $orderStatus = $this->orderStatusHelper->getConsultationStatusByName($name, $userType);

        return [
            'status' => 200,
            'data' => $orderStatus,
        ];
    }

    public function updateOrderStatus($params, $id)
    {

        $validator = Validator::make($params, [
            'consultation_id' => 'required|string',
            'phase' => 'required|string',
            'order_status' => 'required',
            'file' => 'nullable',
            'type' => 'required|string',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $orderStatus = $this->orderStatusService->show($id);

        if ($orderStatus['status'] == 404) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }
        $orderStatus = $orderStatus['data'];
        $newStatus = $this->orderStatusHelper->updateOrderStatusByCode($orderStatus, $params);
        $orderStatus = $this->orderStatusService->update($newStatus, $id);

        if ($params['user_jwt_type'] == "vendor") {
            $params['vendor_user_id'] = $params['user_id'];
            $params['user_id'] = null;
        }
        $project = $this->projectRepo->findOne($params);

        if ($project) {
            $project['sub_status'] = $params['order_status'];
            $project['status'] = $params['phase'];
            $project['updated_at'] = date('Y-m-d H:i:s');
            $this->projectRepo->update($project, $project->id);

            $consultation = $this->consultation->findById($params['consultation_id']);
            if ($consultation == null) {
                return [
                    'status' => 404,
                    'data' => ['message' => "Consultation data not found"]
                ];
            }
            $consultation['orderStatus'] = $params['order_status'];
            $consultation = $this->consultation->update($consultation, $params['consultation_id']);

            $userIds = [];
            if ($project->user_id) {
                array_push($userIds, $project->user_id);
            }
            if ($project->vendor_user_id) {
                array_push($userIds, $project->vendor_user_id);
            }

            if ($project->admin_user_id) {
                array_push($userIds, $project->admin_user_id);
            }

            $tokens = $this->userTokenService->get(['user_ids' => $userIds]);
            if ($tokens['status'] == 200) {
                $tokens = $tokens['data'];
            }

            $deviceTokens = [];
            $notificationUserIds = [];
            foreach ($tokens as $token) {
                array_push($notificationUserIds, $token['user_id']);
                array_push($deviceTokens, $token['device_token']);
            }

            $os = new OrderStatus;
            $osName = $os->getActivityByCode($params['order_status']);

            $this->notificationService->send($deviceTokens, array(
                "title" => "Order status diupdate ke kode " . $params['order_status'],
                "body" => $params['user_jwt_name'] . " membuat order status: " . $osName . " di room id " . $id,
                "type" => "notification",
                "value" => [
                    "chat_room" => ""
                ]
            ));

            foreach ($notificationUserIds as $notificationUserId) {
                $this->userNotificationService->store(['user_id' => $notificationUserId, 'text' => $params['user_jwt_name'] . " membuat order status: " . $osName . " di room id " . $id, 'type' => 'notification', 'chat_room_id' => $id]);
                $user = $this->user->show($notificationUserId);

                if ($user['status'] != 404) {
                    $this->sendMessage($params['user_jwt_name'] . " membuat order status: " . $osName . " di room id " . $id, $user['data']['user_phone_number']);
                }
            }
        }

        $orderStatus = $this->orderStatusService->show($id);
        $orderStatus = $orderStatus['data'];
        return [
            'status' => 200,
            'data' => $orderStatus
        ];
    }

    private function sendMessage($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        try {
            return $client->messages->create($recipients, ['from' => $twilio_number, 'body' => $message]);
        } catch (\Throwable $e) {
            report($e);
            return $e;
        }
    }

    public function paymentOrderStatus($params, $id)
    {

        $validator = Validator::make($params, [
            'consultation_id' => 'required|string',
            'phase' => 'required|string',
            'order_status' => 'required',
            'file' => 'nullable',
            'amount' => 'nullable|numeric',
            'type' => 'required|string',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $orderStatus = $this->orderStatusService->show($id);

        if ($orderStatus['status'] == 404) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }


        if ($params['user_jwt_type'] == "vendor") {
            $params['vendor_user_id'] = $params['user_id'];
            $params['user_id'] = null;
        }

        $project = $this->projectRepo->findByConsultationId($params['consultation_id']);

        if ($project) {
            $params['uniq_id'] = $project->uniq_id;
            $resp = $this->postSignPayment($params);
            if (!isset($resp['success']) || !$resp['success']) {
                return [
                    'status' => 404,
                    'data' => ['message' => $resp],
                ];
            }
            $params['payment_link'] =  isset($resp['data']['invoice_url']) ? $resp['data']['invoice_url'] : "";
            $orderStatus = $orderStatus['data'];
            $newStatus = $this->orderStatusHelper->updateOrderStatusByCode($orderStatus, $params);
            $orderStatus = $this->orderStatusService->update($newStatus, $id);

            $project['sub_status'] = $params['order_status'];
            $project['status'] = $params['phase'];
            $project['updated_at'] = date('Y-m-d H:i:s');

            if ($params['order_status'] == 160) {
                $params['booking_fee'] = $params['amount'];
                $project['booking_fee'] = $params['amount'];
            } else if ($params['order_status'] == 330) {
                $params['termin_customer_1'] = $params['amount'];
                $project['termin_customer_1'] = $params['amount'];
            } else if ($params['order_status'] == 430) {
                $params['termin_customer_2'] = $params['amount'];
                $project['termin_customer_2'] = $params['amount'];
            } else if ($params['order_status'] == 460) {
                $params['termin_customer_3'] = $params['amount'];
                $project['termin_customer_3'] = $params['amount'];
            } else if ($params['order_status'] == 331) {
                $params['termin_vendor_1'] = $params['amount'];
                $project['termin_vendor_1'] = $params['amount'];
            } else if ($params['order_status'] == 431) {
                $params['termin_vendor_2'] = $params['amount'];
                $project['termin_vendor_2'] = $params['amount'];
            } else if ($params['order_status'] == 470) {
                $params['termin_vendor_3'] = $params['amount'];
                $project['termin_vendor_3'] = $params['amount'];
            }
            $this->projectRepo->update($project, $project->id);

            $os = new OrderStatus;
            $osName = $os->getActivityByCode($params['order_status']);

            $paramPayment = array();
            $paramPayment['user_id'] = $params['user_id'];
            $paramPayment['code'] = $params['order_status'];
            $paramPayment['amount'] = $params['amount'];
            $paramPayment['room_id'] = $id;
            $paramPayment['status'] = 'pending';
            $paramPayment['phase'] = $params['phase'];
            $paramPayment['consultation_id'] = $params['consultation_id'];
            $paramPayment['uniq_id'] = $params['uniq_id'];
            $paramPayment['activity'] = $osName;
            $paramPayment['link'] = $params['payment_link'];

            $this->projectRepo->createPayment($paramPayment);

            $consultation = $this->consultation->findById($params['consultation_id']);
            if ($consultation == null) {
                return [
                    'status' => 404,
                    'data' => ['message' => "Consultation data not found"]
                ];
            }
            $consultation['orderStatus'] = $params['order_status'];
            $consultation = $this->consultation->update($consultation, $params['consultation_id']);

            $userIds = [];
            if ($project->user_id) {
                array_push($userIds, $project->user_id);
            }
            if ($project->vendor_user_id) {
                array_push($userIds, $project->vendor_user_id);
            }

            if ($project->admin_user_id) {
                array_push($userIds, $project->admin_user_id);
            }

            $tokens = $this->userTokenService->get(['user_ids' => $userIds]);
            if ($tokens['status'] == 200) {
                $tokens = $tokens['data'];
            }

            $deviceTokens = [];
            $notificationUserIds = [];
            foreach ($tokens as $token) {
                array_push($notificationUserIds, $token['user_id']);
                array_push($deviceTokens, $token['device_token']);
            }

            $os = new OrderStatus;
            $osName = $os->getActivityByCode($params['order_status']);

            $this->notificationService->send($deviceTokens, array(
                "title" => "Order status diupdate ke kode " . $params['order_status'],
                "body" => $params['user_jwt_name'] . " membuat order status: " . $osName . " di room id " . $id,
                "type" => "notification",
                "value" => [
                    "chat_room" => ""
                ]
            ));

            foreach ($notificationUserIds as $notificationUserId) {
                $this->userNotificationService->store(['user_id' => $notificationUserId, 'text' => $params['user_jwt_name'] . " membuat order status: " . $osName . " di room id " . $id, 'type' => 'notification', 'chat_room_id' => $id]);
                $user = $this->user->show($notificationUserId);

                if ($user['status'] != 404) {
                    $this->sendMessage($params['user_jwt_name'] . " membuat order status: " . $osName . " di room id " . $id, $user['data']['user_phone_number']);
                }
            }
        }

        $orderStatus = $this->orderStatusService->show($id);
        $orderStatus = $orderStatus['data'];
        $orderStatus['payment_link'] = isset($resp['data']['invoice_url']) ? $resp['data']['invoice_url'] : "";

        return [
            'status' => 200,
            'data' => $orderStatus
        ];
    }

    public function scheduleOrderStatus($params, $id)
    {

        $validator = Validator::make($params, [
            'consultation_id' => 'required|string',
            'title' => 'required|string',
            'order_status' => 'required',
            'type'=>'required',
            'location' => 'required|string',
            'start_date' => 'required|date_format:Y-m-d H:i:s',
            'end_date' => 'required|date_format:Y-m-d H:i:s',
            'link' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $orderStatus = $this->orderStatusService->show($id);

        if ($orderStatus['status'] == 404) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $project = $this->projectRepo->findByConsultationId($params['consultation_id']);
        if (!$project) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data consultation not found'],
            ];
        }
        $orderStatus = $orderStatus['data'];
        $newStatus = $this->orderStatusHelper->updateOrderStatusByCode($orderStatus, $params);
        $orderStatus = $this->orderStatusService->update($newStatus, $id);

        $os = new OrderStatus;
        $osName = $os->getActivityByCode($params['order_status']);

        $paramSchedule = array();
        $paramSchedule['user_id'] = $project->user_id;
        $paramSchedule['admin_id'] = $project->admin_user_id;
        $paramSchedule['vendor_id'] = $project->vendor_user_id;
        $paramSchedule['code'] = $params['order_status'];
        $paramSchedule['location'] = $params['location'];
        $paramSchedule['room_id'] = $id;
        $paramSchedule['status'] = 'pending';
        $paramSchedule['title'] = $params['title'];
        $paramSchedule['consultation_id'] = $params['consultation_id'];
        $paramSchedule['start_date'] = $params['start_date'];
        $paramSchedule['end_date'] = $params['end_date'];
        $paramSchedule['link'] = isset($params['link'])?$params['link']:'';

        $this->projectRepo->createSchedule($paramSchedule);

        $userIds = [];
        if ($project->user_id) {
            array_push($userIds, $project->user_id);
        }
        if ($project->vendor_user_id) {
            array_push($userIds, $project->vendor_user_id);
        }

        if ($project->admin_user_id) {
            array_push($userIds, $project->admin_user_id);
        }

        $tokens = $this->userTokenService->get(['user_ids' => $userIds]);
        if ($tokens['status'] == 200) {
            $tokens = $tokens['data'];
        }

        $deviceTokens = [];
        $notificationUserIds = [];
        foreach ($tokens as $token) {
            array_push($notificationUserIds, $token['user_id']);
            array_push($deviceTokens, $token['device_token']);
        }

        $os = new OrderStatus;
        $osName = $os->getActivityByCode($params['order_status']);

        $this->notificationService->send($deviceTokens, array(
            "title" => "Order status diupdate ke kode " . $params['order_status'],
            "body" => $params['user_jwt_name'] . " membuat order status: " . $osName . " di room id " . $id,
            "type" => "notification",
            "value" => [
                "chat_room" => ""
            ]
        ));

        foreach ($notificationUserIds as $notificationUserId) {
            $this->userNotificationService->store(['user_id' => $notificationUserId, 'text' => $params['user_jwt_name'] . " membuat order status: " . $osName . " di room id " . $id, 'type' => 'notification', 'chat_room_id' => $id]);
            $user = $this->user->show($notificationUserId);

            if ($user['status'] != 404) {
                $this->sendMessage($params['user_jwt_name'] . " membuat order status: " . $osName . " di room id " . $id, $user['data']['user_phone_number']);
            }
        }


        $orderStatus = $this->orderStatusService->show($id);
        $orderStatus = $orderStatus['data'];
        $orderStatus['payment_link'] = isset($resp['data']['invoice_url']) ? $resp['data']['invoice_url'] : "";

        return [
            'status' => 200,
            'data' => $orderStatus
        ];
    }

    public function getScheduleOrderStatus($params, $id)
    {

        $schedule = $this->projectRepo->findSchedulesByRoomId($id);
        if (!$schedule) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }
        
        return [
            'status' => 200,
            'data' => $schedule
        ];
    }



    public function postSignPayment($params)
    {
        try {

            $headers = [
                'Content-Type'          => 'application/json'
            ];

            $json =  [
                "username" =>  env('PAYMENT_USERNAME', "master-mitra@gmail.com"),
                "password" => env('PAYMENT_PASSWORD', "userdp2021")
            ];

            $response = Http::withHeaders($headers)->post(env('PAYMENT_MITRARUMA', 'https://dev-test.mitraruma.com') . '/api/login', $json);

            $data =  json_decode($response->getBody(), true);

            if ($response->getStatusCode() == 200) {
                $token = $data['data']['token'];
                $res = $this->postPayment($token, $params);
                return $res;
            } else {
                return $data;
            }
        } catch (\Exception $e) {
            $message = $e->getMessage() . ". Line " . $e->getLine();
            return $message;
        }
    }

    public function postPayment($token, $params)
    {
        try {

            $headers = [
                'Content-Type'   => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ];

            $json =  [
                "invoice_no" => "CHAT/INVOICE/" . mt_rand(1000000, 9999999),
                "customer_email" => $params['user_jwt_email'],
                "description" => $params['phase'] . '-' . $params['order_status'],
                "amount" => $params['amount']
            ];

            $response = Http::withHeaders($headers)->post(env('PAYMENT_MITRARUMA', 'https://dev-test.mitraruma.com') . '/api/payment/initialize-invoice/' . $params['uniq_id'], $json);

            $data =  json_decode($response->getBody(), true);
            if ($response->getStatusCode() == 200) {
                $res = $this->postPaymentXendit($token, $data);
                return $res;
            } else {
                return $data;
            }
        } catch (\Exception $e) {
            $message = $e->getMessage() . ". Line " . $e->getLine();
            return $message;
        }
    }

    public function postPaymentXendit($token, $params)
    {
        try {

            $headers = [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ];

            $json =  [
                "uniq_id" => $params['data']['uniq_id']
            ];

            $response = Http::withHeaders($headers)->post(env('PAYMENT_MITRARUMA', 'https://dev-test.mitraruma.com') . '/api/payment/generate-invoice', $json);

            $data =  json_decode($response->getBody(), true);
            return $data;
        } catch (\Exception $e) {
            $message = $e->getMessage() . ". Line " . $e->getLine();
            return $message;
        }
    }
}
