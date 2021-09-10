<?php


namespace App\Services;

use Firebase\JWT\JWT;

class JwtService
{

    public function encode($params) {

        $jwt = JWT::encode($params, getenv('JWT_SECRET'));

        return $jwt;
    }

    public function decode($params) {

        $jwt = JWT::decode($params, getenv('JWT_SECRET_CHAT'), array('HS256'));

        return $jwt;
    }

}