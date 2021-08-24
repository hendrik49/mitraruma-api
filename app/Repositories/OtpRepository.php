<?php

namespace App\Repositories;

use App\Models\WpOtp;
use Carbon\Carbon;

class OtpRepository
{

    public function findById($id){
        return WpOtp::where('ID', $id)->first();
    }

    public function findOne($params){
        $otp = WpOtp::query();
        if(isset($params['user_id'])) {
            $otp->where('user_id', $params['user_id']);
        }
        if(isset($params['otp'])) {
            $otp->where('otp', $params['otp']);
        }
        $otp->where('valid_date','>=',Carbon::now());
        return $otp->first();
    }

    public function create($params) {
        return WpOtp::create($params);
    }

    public function deleteByUserid($user_id) {
        return WpOtp::where('user_id', $user_id)->delete();
    }
}