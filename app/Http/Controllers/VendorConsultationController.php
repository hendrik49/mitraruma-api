<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendorConsultationController extends Controller
{
    /**
     * @var \App\Services\ConsultationService
     */
    private $consultation;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\ConsultationService  $consultation
     * @return void
     */
    public function __construct(
        \App\Services\ConsultationService $consultation
    )
    {
        $this->consultation = $consultation;
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
        $result = $this->consultation->index($params);

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
        $result = $this->consultation->show($id);

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        $params = $request->all();

        $params['vendor_user_id'] = $params['user_id'];
        $params['user_id'] = null;
        return $this->consultation->export($params);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showStatus($id)
    {
        $result = $this->consultation->showStatus($id);

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
        $result = $this->consultation->showChatFiles($id);

        return response()->json($result['data'], $result['status']);
    }


}
