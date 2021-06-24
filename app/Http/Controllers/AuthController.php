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
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }

        $params['user_email'] = $user->getEmail();
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

}
