<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class CmsService
{
    /**
     * @var \App\Repositories\CmsRepository
     */
    private $cms;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserService $user
     * @param  \App\Repositories\CmsRepository $cms
     * @return void
     */
    public function __construct(
        \App\Services\UserService $user,
        \App\Repositories\CmsRepository $cms
    ) {
        $this->user = $user;
        $this->cms = $cms;
    }

    public function index($params){

        $cms = $this->cms->find($params);
        if (!$cms) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $cms,
        ];
    }

    public function show($id){

        $cms = $this->cms->findById($id);
        if (!$cms) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $cms,
        ];
    }

    public function showByName($params){

        $cms = $this->cms->find($params);
        if (!$cms || sizeof($cms) == 0) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $cms[0],
        ];
    }

    public function create($params){

        $validator = Validator::make($params, [
            'name' => 'required|string',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $cms = $this->cms->create($params);

        return [
            'status' => 201,
            'data' => $cms,
        ];
    }

    public function update($params, $id){

        $validator = Validator::make($params, [
            'name' => 'required|string',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $cms = $this->cms->update($params, $id);
        if (!$cms) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $cms,
        ];
    }

    public function destroy($id){

        $user = $this->user->show(1);
        if($user['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }

        $cms = $this->cms->deleteById($id);
        if (!$cms) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 202,
            'data' => ['message' => 'Success deleted data'],
        ];

    }


}