<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicatorController extends Controller
{
    /**
     * @var \App\Services\UserService
     */
    private $user;

    /**
     * Create a new controller instance.
     *
     * @param \App\Services\UserService $user
     * @return void
     */
    public function __construct(
        \App\Services\UserService $user
    )
    {
        $this->user = $user;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->all();
        $params['user_type'] = 'vendor';

        return response($this->user->create($params));
    }

}
