<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showVendor(Request $request)
    {
        $params = $request->all();

        $result = $this->user->findVendor($params);

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
        $params['user_type'] =  'customer';

        DB::beginTransaction();
        $result = $this->user->create($params);
        if($result['status'] != 201) {
            DB::rollBack();
            return response()->json($result['data'], $result['status']);
        }

        DB::commit();
        return response()->json($result['data'], $result['status']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(Request $request)
    {

        $params = $request->all();

        DB::beginTransaction();
        $result = $this->user->destroyByUserLogin($params);
        if($result['status'] != 201) {
            DB::rollBack();
            return response()->json($result['data'], $result['status']);
        }

        DB::commit();
        return response()->json($result['data'], $result['status']);
    }


     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeIntegration(Request $request)
    {

        $params = $request->all();
        $params['user_type'] =  'customer';
        $params['user_picture_url'] = 'images/img-customer.jpeg';

        DB::beginTransaction();
        $result = $this->user->createIntegration($params);
        if($result['status'] != 201) {
            DB::rollBack();
            return response()->json($result['data'], $result['status']);
        }

        DB::commit();
        return response()->json($result['data'], $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $result = $this->user->show($id);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $result = $this->user->destroy($id);

        return response()->json($result['data'], $result['status']);
    }

}
