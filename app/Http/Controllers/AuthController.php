<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @var \App\Services\UserService
     */
    private $user;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserService  $user
     * @return void
     */
    public function __construct(
        \App\Services\UserService $user
    )
    {
        $this->user = $user;
    }

    /**
     * Login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $params = $request->all();

        $result = $this->user->login($params);

        return response()->json($result['data'], $result['status']);

    }

    /**
     * Login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginOtp(Request $request)
    {

        $params = $request->all();

        $result = $this->user->loginOtp($params);

        return response()->json($result['data'], $result['status']);

    }

}
