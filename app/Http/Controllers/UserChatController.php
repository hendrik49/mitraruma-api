<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserChatController extends Controller
{
    /**
     * @var \App\Services\ChatService
     */
    private $chat;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\ChatService  $chat
     * @return void
     */
    public function __construct(
        \App\Services\ChatService $chat
    )
    {
        $this->chat = $chat;
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

        $result = $this->chat->index($params);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $result = $this->chat->show($id);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $roomId
     * @return JsonResponse
     */
    public function store(Request $request, $roomId)
    {

        $params = $request->all();

        $result = $this->chat->create($params, $roomId);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $roomId
     * @return JsonResponse
     */
    public function readChat(Request $request, $roomId)
    {
        $result = $this->chat->readChat($request, $roomId);

        return response()->json($result['data'], $result['status']);
    }

}
