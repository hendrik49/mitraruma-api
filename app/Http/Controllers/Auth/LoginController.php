<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(
        \App\Services\JwtService $jwt
    ) {
        $this->jwt = $jwt;
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => ['required', 'regex:/[+](62)[0-9]/', 'string', 'exists:wp_users,user_phone_number'],
            'password' => 'required|string|min:6',
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    public function username()
    {
        return request()->has('user_phone_number') ? 'user_phone_number' : 'user_login';
    }

    public function showLoginForm(Request $request)
    {
        try {
            if ($request->has('token')) {
                $token = $request->query('token');
                $decoded = $this->jwt->decode($token);
                $user = User::where('user_phone_number', $decoded->phone)->orWhere('user_email', $decoded->email)->first();
                if ($user) {
                    Auth::login($user);
                    return Redirect::to('/home');
                } else {

                    $user = new User;
                    $user->ID =  $decoded->id;
                    $user->display_name =  $decoded->displayName;
                    $user->nice_name =  $decoded->userId;
                    $user->user_email =  $decoded->email;
                    $user->user_email =  $decoded->email;
                    $user->user_type =  $decoded->userType;                    
                    $user->user_phone_number = $decoded->phone;
                    $user->user_picture_url =  $decoded->picture;
                    $user->user_status = 1;
                    $user->save();
                    return Redirect::to('/home');
                    //return redirect()->route('login')->with('error', 'Failed to login. This account ' . $decoded->email . ' not exist');
                }
            } else {
                return view('auth.login');
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Failed to login. Token chat platform not valid');
        }
    }

    protected function authenticated(Request $request, $user)
    {
        //
    }
}
