<?php

namespace App\Services;

use App\Models\WpUserExtensionAttribute;
use Illuminate\Support\Facades\Validator;

class UserExtensionAttributeService
{
    /**
     * @var UserService
     */
    private $user;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserService  $user
     * @return void
     */
    public function __construct(
        UserService $user
    ) {
        $this->user = $user;
    }

    public function index(){

        $address = WpUserExtensionAttribute::where('user_id', 1)->get();
        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $address,
        ];
    }

    public function show($id){

        $address = WpUserExtensionAttribute::where('id', $id)->first();
        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $address,
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

        $user = $this->user->show($params['user_id']);
        if($user['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }

        $params['value'] =  json_encode($params['value']);
        $extensionAttribute = WpUserExtensionAttribute::create($params);

        $extensionAttribute['value'] = json_decode($extensionAttribute['value']);
        return [
            'status' => 201,
            'data' => $extensionAttribute,
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

        $user = $this->user->show($params['user_id']);
        if($user['status'] != 200) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }

        $extensionAttribute = WpUserExtensionAttribute::where('id', $id)->first();
        if (!$extensionAttribute) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        $params['value'] =  json_encode($params['value']);

        $extensionAttribute->name = $params['name'];
        $extensionAttribute->value = $params['value'];
        $extensionAttribute->save();

        $extensionAttribute['value'] = json_decode($extensionAttribute['value']);

        return [
            'status' => 200,
            'data' => $extensionAttribute,
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

        $extensionAttribute = WpUserExtensionAttribute::where('id', $id)->first();
        if (!$extensionAttribute) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }
        $extensionAttribute->delete();

        return [
            'status' => 202,
            'data' => ['message' => 'Success deleted data'],
        ];
    }


}