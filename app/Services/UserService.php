<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;

class UserService
{
    /**
     * @var OtpService
     */
    private $otp;

    /**
     * @var JwtService
     */
    private $jwt;

    private $user;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\OtpService  $otp
     * @param  \App\Services\JwtService  $jwt
     * @param  \App\Repositories\UserRepository  $user
     * @return void
     */
    public function __construct(
        OtpService $otp,
        JwtService $jwt,
        \App\Repositories\UserRepository $user
    ) {
        $this->otp = $otp;
        $this->jwt = $jwt;
        $this->user = $user;
    }

    public function show($id) {
        $user = $this->user->findById($id);
        if(!$user) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $user,
        ];

    }

    public function create($params){

        $validator = Validator::make($params, [
            'user_phone_number' => 'required|regex:/[+](62)[0-9]/',
            'user_type' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $isUserExist = $this->user->findOne($params);
        if($isUserExist) {
            return [
                'status' => 409,
                'data' => ['message' => 'User already exist'],
            ];
        }

        $user = $this->user->create($params);

        $otp = $this->otp->generateToken($user['ID']);

        self::sendMessage(' this is your Mitraruma OTP '.$otp['otp'], $user['user_phone_number']);

        return [
            'status' => 201,
            'data' => [
                'message' => 'Please check your message',
                'valid_date' => $otp['valid_date']
            ],
        ];
    }

    public function update($params, $id){

        $validator = Validator::make($params, [
            'user_phone_number' => 'regex:/[+](62)[0-9]/',
            'user_email' => 'email',
            'display_name' => 'string',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $isUserExist = $this->user->findOne($params);

        if($isUserExist && $isUserExist['ID'] != $id) {
            return [
                'status' => 409,
                'data' => ['message' => 'User already exist'],
            ];
        }

        $user = $this->user->update($params, $id);
        if(!$user) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $user,
        ];
    }

    public function login($params){

        $validator = Validator::make($params, [
            'user_phone_number' => 'required|regex:/[+](62)[0-9]/'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $user = $this->user->findOne($params);
        if(!$user) {
            return [
                'status' => 409,
                'data' => ['message' => 'User is not exist'],
            ];
        }

        $otp = $this->otp->generateToken($user['ID']);

        self::sendMessage(' this is your Mitraruma OTP '.$otp['otp'], $user['user_phone_number']);

        return [
            'status' => 201,
            'data' => [
                'message' => 'Please check your message',
                'valid_date' => $otp['valid_date']
            ],
        ];
    }

    public function loginOtp($params){

        $validator = Validator::make($params, [
            'user_phone_number' => 'required|regex:/[+](62)[0-9]/',
            'otp' => 'required|int'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $user = $this->user->findOne($params);
        if(!$user) {
            return [
                'status' => 409,
                'data' => ['message' => 'User is not exist'],
            ];
        }

        $params['user_id'] = $user['ID'];
        $otp = $this->otp->isOtpValid($params);
        if($otp) {
            $token = $this->jwt->encode($user);
            return [
                'status' => 200,
                'data' => ['token' => $token],
            ];

        } else {
            return [
                'status' => 400,
                'data' => ['message' => 'OTP is not valid']
            ];
        }
    }

    private function sendMessage($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        try {
            $client->messages->create($recipients, ['from' => $twilio_number, 'body' => $message]);
        }
        catch (Throwable $e) {
            report($e);
        }
    }

}