<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class VendorConsultationOrderStatusController extends Controller
{
    /**
     * @var \App\Services\ConsultationOrderStatusService
     */
    private $consultationOrderStatusService;

    /**
     * Create a new controller instance.
     *
     * @param \App\Services\ConsultationOrderStatusService $consultationOrderStatusService
     */
    public function __construct(
        \App\Services\ConsultationOrderStatusService $consultationOrderStatusService
    )
    {
        $this->consultationOrderStatusService = $consultationOrderStatusService;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->consultationOrderStatusService->show($id, 'vendor');

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

        $result = $this->consultationOrderStatusService->update($params, $id);

        return response()->json($result['data'], $result['status']);
    }

}
