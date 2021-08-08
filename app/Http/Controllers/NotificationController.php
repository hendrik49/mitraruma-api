<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    /**
     * @var \App\Services\NotificationService
     */
    private $notification;

    public function __construct(
        \App\Services\NotificationService $notification
    )
    {
        $this->notification = $notification;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $params = $request->all();

        $result = $this->notification->index($params);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Create a new controller instance.
     *
     * @return \App\Services\response|bool|\Illuminate\Http\JsonResponse|string
     */
    public function send(Request $request)
    {
        $result = $this->notification->send([$request->device_token], array(
            "title" => "Sample Message",
            "body" => "This is Test message body"
        ));

        return response()->json($result, 200);
    }
}
