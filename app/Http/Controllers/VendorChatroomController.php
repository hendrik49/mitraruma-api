<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendorChatroomController extends Controller
{
    /**
     * @var \App\Services\ChatroomService
     */
    private $chatroom;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\ChatroomService  $chatroom
     * @return void
     */
    public function __construct(
        \App\Services\ChatroomService $chatroom
    )
    {
        $this->chatroom = $chatroom;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $params = $request->all();

        $params['vendor_user_id'] = $params['user_id'];
        $params['user_id'] = null;
        $result = $this->chatroom->index($params);

        return response()->json($result['data'], $result['status']);
    }

}
