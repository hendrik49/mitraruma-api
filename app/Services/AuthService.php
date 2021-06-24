<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Google_Client;

class AuthService
{
    /**
     * @var \App\Services\UserService
     */
    private $user;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserService  $user
     * @return void
     */
    public function __construct(
        \App\Services\UserService $user
    )
    {
        $this->user = $user;
    }

    public function loginGoogleByToken($params)
    {
        $client = new Google_Client(['client_id' => getenv('GOOGLE_CLIENT_APP_ID')]);  // Specify the CLIENT_ID of the app that accesses the backend
        try {

            $payload = $client->verifyIdToken($params['token']);
            if ($payload) {
                $params['user_email'] = $payload['email'];
                $userLogin = $this->user->loginByEmail($params);
                if ($userLogin['status'] == 200) {
                    return $userLogin;
                } else {
                    $params['user_type'] = 'customer';
                    $this->user->createByEmail($params);
                    return $this->user->loginByEmail($params);
                }
            } else {
                return [
                    'status' => 400,
                    'data' => ['message' => 'Invalid token']
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 400,
                'data' => ['message' => $e->getMessage()]
            ];
        }
    }

}