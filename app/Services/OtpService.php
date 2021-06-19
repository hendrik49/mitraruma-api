<?php


namespace  App\Services;

use App\Models\WpOtp;

class OtpService
{

    public function generateToken($userId){
        $otp = rand(100000, 999999);
        $params['otp'] = $otp;
        $params['user_id'] = $userId;

        $otp = WpOtp::create($params);

        return $otp;
    }

    public function isOtpValid($params){
        $otp = WpOtp::where('otp', $params['otp'])
        ->where('user_id', $params['user_id'])->first();

        if($otp) {
            WpOtp::where('user_id', $params['user_id'])->delete();
        }

        return $otp;
    }
}