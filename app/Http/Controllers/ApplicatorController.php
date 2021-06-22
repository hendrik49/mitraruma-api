<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $result = $this->applicator->create($params);

        return response()->json($result['data'], $result['status']);
    }

}
