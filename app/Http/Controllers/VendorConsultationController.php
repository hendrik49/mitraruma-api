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

}
