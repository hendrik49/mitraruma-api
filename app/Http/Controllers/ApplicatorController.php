<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicatorController extends Controller
{
    /**
     * @var \App\Services\ApplicatorService
     */
    private $applicator;

    /**
     * Create a new controller instance.
     *
     * @param \App\Services\ApplicatorService $applicator
     */
    public function __construct(
        \App\Services\ApplicatorService $applicator
    )
    {
        $this->applicator = $applicator;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $params = $request->all();
        $params['user_type'] = 'vendor';

        DB::beginTransaction();
        $result = $this->applicator->create($params);
        if($result['status'] != 201) {
            DB::rollBack();
            return response()->json($result['data'], $result['status']);
        }

        DB::commit();
        return response()->json($result['data'], $result['status']);
    }

    public function storeIntegration(Request $request)
    {
        $params = $request->all();
        $params['user_type'] = 'vendor';
        $params['user_picture_url'] = '/images/img-applicator.png';
        $params['display_name'] = $params['display_name'] ? $params['display_name'] : $params["company_name"];

        DB::beginTransaction();
        $result = $this->applicator->create($params);
        if($result['status'] != 201) {
            DB::rollBack();
            return response()->json($result['data'], $result['status']);
        }

        DB::commit();
        return response()->json($result['data'], $result['status']);
    }

}
