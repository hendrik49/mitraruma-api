<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserTokenController extends Controller
{
    /**
     * @var \App\Services\UserTokenService
     */
    private $userToken;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserTokenService  $userToken
     * @return void
     */
    public function __construct(
        \App\Services\UserTokenService $userToken
    )
    {
        $this->userToken = $userToken;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $params = $request->all();

        $result = $this->userToken->store($params);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $params = $request->all();

        $result = $this->userToken->destroy($params['user_id']);

        return response()->json($result['data'], $result['status']);
    }

}
