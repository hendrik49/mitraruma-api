<?php


namespace  App\Services;

use Carbon\Carbon;

class OtpService
{

    public function __construct(
        \App\Repositories\OtpRepository $otp
    ) {
        $this->otp = $otp;
    }

    public function generateToken($userId){
        $otp = rand(100000, 999999);
        $params['otp'] = $otp;
        $params['user_id'] = $userId;
        $params['valid_date'] = Carbon::now()->addMinute(60);

        $otp = $this->otp->create($params);

        return $otp;
    }

    public function isOtpValid($params){
        
        $otp = $this->otp->findOne($params);

        if($otp) {
            $this->otp->deleteByUserid($params['user_id']);
        }

        return $otp;
    }
}