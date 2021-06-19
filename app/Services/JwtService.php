<?php


namespace App\Services;

use Firebase\JWT\JWT;

class JwtService
{

    public function generate($params) {

        $jwt = JWT::encode($params, getenv('JWT_SECRET'));

        return $jwt;
    }

}