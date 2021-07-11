<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserChatroomController extends Controller
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showChatFiles($id)
    {
        $result = $this->chatroom->showChatFiles($id);

        return response()->json($result['data'], $result['status']);
    }

}
