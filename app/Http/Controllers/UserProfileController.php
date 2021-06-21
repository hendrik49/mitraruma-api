<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class UserProfileController extends Controller
{
    /**
     * @var \App\Services\UserService
     */
    private $user;

    /**
     * @var \App\Services\UserAddressService
     */
    private $userAddress;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserService  $user
     * @param  \App\Services\UserAddressService  $userAddress
     * @return void
     */
    public function __construct(
        \App\Services\UserService $user,
        \App\Services\UserAddressService $userAddress
    )
    {
        $this->user = $user;
        $this->userAddress = $userAddress;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $params = $request->all();
        $result = $this->user->show($params['user_id']);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $params = $request->all();

        $result = $this->user->update($params, $params['user_id']);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listAddress(Request $request)
    {
        $params = $request->all();
        $result = $this->userAddress->index($params);

        return response()->json($result['data'], $result['status']);
    }

}
