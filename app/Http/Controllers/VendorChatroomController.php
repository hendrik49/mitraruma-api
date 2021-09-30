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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showUsers($id)
    {
        $result = $this->chatroom->showUsers($id);

        return response()->json($result['data'], $result['status']);
    }

    public function showOrderStatus($id)
    {
        $result = $this->chatroom->showOrderStatus($id);

        return response()->json($result['data'], $result['status']);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $params = $request->all();

        $result = $this->chatroom->updateOrderStatus($params, $id);

        return response()->json($result['data'], $result['status']);
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showOrderStatusSelection($id)
    {
        $result = $this->chatroom->showOrderStatusSelection($id,'vendor');

        return response()->json($result['data'], $result['status']);
    }

    public function scheduleOrderStatus(Request $request, $id)
    {
        $params = $request->all();

        $result = $this->chatroom->scheduleOrderStatus($params, $id);

        return response()->json($result['data'], $result['status']);
    }

   public function getScheduleOrderStatus(Request $request, $id)
   {
       $params = $request->all();

       $result = $this->chatroom->getScheduleOrderStatus($params, $id);

       return response()->json($result['data'], $result['status']);
   }

}
