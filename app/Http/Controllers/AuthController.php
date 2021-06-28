<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * @var \App\Services\UserService
     */
    private $user;

    /**
     * @var \App\Services\AuthService
     */
    private $auth;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\UserService  $user
     * @param  \App\Services\AuthService  $auth
     * @return void
     */
    public function __construct(
        \App\Services\UserService $user,
        \App\Services\AuthService $auth
    )
    {
        $this->user = $user;
        $this->auth = $auth;
    }

    /**
     * Login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $params = $request->all();

        $result = $this->user->login($params);

        return response()->json($result['data'], $result['status']);

    }

    /**
     * Login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginOtp(Request $request)
    {

        $params = $request->all();

        $result = $this->user->loginOtp($params);

        return response()->json($result['data'], $result['status']);

    }

    /**
     * Login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginByEmail(Request $request)
    {

        $params = $request->all();

        $result = $this->user->loginByEmail($params);

        return response()->json($result['data'], $result['status']);

    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loginGoogleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }

        $params['user_email'] = $user->getEmail();
        $params['user_picture_url'] = $user->getAvatar();
        $userLogin = $this->user->loginByEmail($params);
        if($userLogin['status'] == 200) {
            return response()->json($userLogin['data'], $userLogin['status']);
        }
        else {
            $params['user_type'] = 'customer';
            $this->user->createByEmail($params);
            return $userLogin = $this->user->loginByEmail($params);
        }
    }

    /**
     * Obtain the user information from Google.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginGoogleToken(Request $request)
    {

        $params = $request->all();
        $userAgent = strtoupper($request->header('user-agent'));

        $result = $this->auth->loginGoogleByToken($params, $userAgent);

        return response()->json($result['data'], $result['status']);

    }

}
