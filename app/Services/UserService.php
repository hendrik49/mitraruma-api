<?php

namespace App\Services;

use App\Models\WpUser;
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

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\OtpService  $otp
     * @param  \App\Services\JwtService  $jwt
     * @return void
     */
    public function __construct(
        OtpService $otp,
        JwtService $jwt
    ) {
        $this->otp = $otp;
        $this->jwt = $jwt;
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

        $params['user_type'] =  'vendor';

        $isUserExist = WpUser::where('user_phone_number', $params['user_phone_number'])->first();
        if($isUserExist) {
            return [
                'status' => 409,
                'data' => ['message' => 'User already exist'],
            ];
        }

        $user = WpUser::create($params);

        $otp = $this->otp->generateToken($user['ID']);
        $otp = json_decode($otp)->otp;

        self::sendMessage(' this is your Mitraruma OTP '.$otp, $user['user_phone_number']);
        return [
            'status' => 201,
            'data' => ['message' => 'Please check your message'],
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

        $user = WpUser::where('user_phone_number', $params['user_phone_number'])->first();
        if(!$user) {
            return [
                'status' => 409,
                'data' => ['message' => 'User is not exist'],
            ];
        }

        $otp = $this->otp->generateToken($user['ID']);
        $otp = json_decode($otp)->otp;

        self::sendMessage(' this is your Mitraruma OTP '.$otp, $user['user_phone_number']);

        return [
            'status' => 201,
            'data' => ['message' => 'Please check your message'],
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

        $user = WpUser::where('user_phone_number', $params['user_phone_number'])->first();
        if(!$user) {
            return response(['message' => 'User is not exist'], 409)->header('Content-Type', 'application/json');
        }

        $params['user_id'] = $user['ID'];
        $otp = $this->otp->isOtpValid($params);
        if($otp) {
            $token = $this->jwt->generate($user);
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