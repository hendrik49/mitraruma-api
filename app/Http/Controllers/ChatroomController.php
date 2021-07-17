<?php

namespace App\Http\Controllers;

use App\Services\ChatroomManagementService;
use App\Services\ChatroomService;
use Illuminate\Http\Request;

class ChatroomController extends Controller
{
    /**
     * @var ChatroomService
     */
    private $chatroom;

    /**
     * @var ChatroomManagementService
     */
    private $chatroomManagementService;

    /**
     * Create a new controller instance.
     *
     * @param ChatroomService $chatroom
     * @param ChatroomManagementService $chatroomManagementService
     */
    public function __construct(
        ChatroomService $chatroom,
        ChatroomManagementService $chatroomManagementService
    )
    {
        $this->chatroom = $chatroom;
        $this->chatroomManagementService = $chatroomManagementService;
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

        $result = $this->chatroom->index($params);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->chatroom->show($id);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $params = $request->all();

        $result = $this->chatroom->create($params);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeVendorRoom(Request $request)
    {

        $params = $request->all();
        $params['room_type'] = 'admin-vendor';

        $result = $this->chatroomManagementService->create($params);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $params = $request->all();

        $result = $this->chatroom->update($params, $id);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {

        $result = $this->chatroom->destroy($id);

        return response()->json($result['data'], $result['status']);
    }

}
