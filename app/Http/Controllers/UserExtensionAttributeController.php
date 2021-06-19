<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class UserExtensionAttributeController extends Controller
{
    /**
     * @var \App\Services\UserExtensionAttributeService
     */
    private $userExt;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserExtensionAttributeService  $userExt
     * @return void
     */
    public function __construct(
        \App\Services\UserExtensionAttributeService $userExt
    )
    {
        $this->userExt = $userExt;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->userExt->index();

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

        $result = $this->userExt->create($params);

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
        $result = $this->userExt->show($id);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {

        $params = $request->all();

        $result = $this->userExt->update($params, $id);

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

        $result = $this->userExt->destroy($id);

        return response()->json($result['data'], $result['status']);
    }

}
