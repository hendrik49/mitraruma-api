<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WpOtp;

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
