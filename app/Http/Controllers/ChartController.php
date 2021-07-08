<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    /**
     * @var \App\Services\CmsService
     */
    private $cms;

    /**
     * @var \App\Services\ConsultationService
     */
    private $consultation;

    /**
     * @var \App\Services\UserService
     */
    private $user;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\CmsService  $cms
     * @param  \App\Services\ConsultationService  $consultation
     * @param  \App\Services\UserService  $user
     * @return void
     */
    public function __construct(
        \App\Services\CmsService $cms,
        \App\Services\ConsultationService $consultation,
        \App\Services\UserService $user
    )
    {
        $this->cms = $cms;
        $this->consultation = $consultation;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function clientCount(Request $request)
    {
        $params = $request->all();

        $params['user_type'] = 'customer';
        $result = $this->user->count($params);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function applicatorCount(Request $request)
    {
        $params = $request->all();

        $params['user_type'] = 'vendor';
        $result = $this->user->count($params);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function consultationCount(Request $request)
    {
        $params = $request->all();

        $result = $this->consultation->count($params);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function orderStatus(Request $request)
    {
        $params = $request->all();

        $result = $this->cms->index($params);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function incomeMonth(Request $request)
    {
        $params = $request->all();

        $result = $this->cms->index($params);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectMonth(Request $request)
    {
        $params = $request->all();

        $result = $this->cms->index($params);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function projectByArea(Request $request)
    {
        $params = $request->all();

        $result = $this->cms->index($params);

        return response()->json($result['data'], $result['status']);
    }

}
