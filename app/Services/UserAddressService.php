<?php

namespace App\Services;

use App\Models\WpUserAddress;
use Illuminate\Support\Facades\Validator;

class UserAddressService
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

    public function index($params){

        $address = WpUserAddress::where('user_id', $params['user_id'])->get();
        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Address not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $address,
        ];
    }

    public function show($id){

        $address = WpUserAddress::where('id', $id)->first();
        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Address not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $address,
        ];
    }

    public function create($params){

        $validator = Validator::make($params, [
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'subdistrict' => 'required|string',
            'zipcode' => 'required|string',
            'street' => 'required|string',
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

        $address = WpUserAddress::create($params);

        return [
            'status' => 201,
            'data' => $address,
        ];
    }

    public function update($params, $id){

        $validator = Validator::make($params, [
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'subdistrict' => 'required|string',
            'zipcode' => 'required|string',
            'street' => 'required|string',
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

        $address = WpUserAddress::where('id', $id)->first();
        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Address not found'],
            ];
        }

        $address->province = $params['province'];
        $address->city = $params['city'];
        $address->district = $params['district'];
        $address->subdistrict = $params['subdistrict'];
        $address->zipcode = $params['zipcode'];
        $address->street = $params['street'];
        $address->save();

        return [
            'status' => 200,
            'data' => $address,
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

        $address = WpUserAddress::where('id', $id)->first();
        if (!$address) {
            return [
                'status' => 404,
                'data' => ['message' => 'Address not found'],
            ];
        }
        $address->delete();

        return [
            'status' => 202 ,
            'data' => ['message' => 'Success deleted data'],
        ];
    }


}