<?php

namespace App\Services;

use App\Http\Resources\UserVendorResource;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Auth;

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

    private $user;

    /**
     * Create a new controller instance.
     *
     * @param \App\Services\OtpService $otp
     * @param \App\Services\JwtService $jwt
     * @param \App\Repositories\UserRepository $user
     * @return void
     */
    public function __construct(
        OtpService $otp,
        JwtService $jwt,
        \App\Repositories\UserRepository $user
    ) {
        $this->otp = $otp;
        $this->jwt = $jwt;
        $this->user = $user;
    }

    public function find($params)
    {

        $user = $this->user->find($params);
        if (!$user) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $user,
        ];
    }

    public function findVendor($params)
    {

        $params['user_type'] = 'vendor';
        $user = $this->user->find($params);
        if (!$user) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }


        return [
            'status' => 200,
            'data' => UserVendorResource::collection($user),
        ];
    }

    public function findOne($params)
    {

        $user = $this->user->findOne($params);
        if (!$user) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $user,
        ];
    }

    public function show($id)
    {
        $user = $this->user->findById($id);
        if (!$user) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $user,
        ];
    }

    public function count($params)
    {

        $user = $this->user->count($params);

        return [
            'status' => 200,
            'data' => ["user" => $user],
        ];
    }

    public function create($params)
    {

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

        $isUserExist = $this->user->findOne($params);
        if ($isUserExist) {
            return [
                'status' => 409,
                'data' => ['message' => 'User already exist'],
            ];
        }

        $user = $this->user->create($params);

        $otp = $this->otp->generateToken($user['ID']);

        self::sendMessage(' This is your Mitraruma OTP ' . $otp['otp'].'. It will expired in 60 minutes', $user['user_phone_number']);

        return [
            'status' => 201,
            'data' => [
                'message' => 'Please check your message',
                'value' => [
                    'ID' => $user['ID'],
                    'valid_date' => $otp['valid_date']
                ]
            ],
        ];
    }

    public function createIntegration($params)
    {

        $validator = Validator::make($params, [
            'user_phone_number' => 'required|regex:/[+](62)[0-9]/|unique:wp_users,user_phone_number',
            'user_type' => 'required',
            'user_email' => 'nullable|email',
            'display_name' => 'required:min:3',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $params['password'] = bcrypt($params['password']);
        $params['user_registered'] = date("Y-m-d H:i:s");
        $params['user_email'] =  $params['user_email'] ? $params['user_email'] : $params['user_phone_number'] . '@gmail.com';
        $params['user_login'] = $params['user_email'];

        $isUserExist = $this->user->findOne($params);
        if ($isUserExist) {
            return [
                'status' => 409,
                'data' => ['message' => 'User already exist'],
            ];
        }

        $user = $this->user->create($params);

        $otp = $this->otp->generateToken($user['ID']);

        self::sendMessage(' This is your Mitraruma OTP ' . $otp['otp'].'. It will expired in 60 minutes.', $user['user_phone_number']);

        return [
            'status' => 201,
            'data' => [
                'message' => 'Please check your message',
                'value' => [
                    'ID' => $user['ID'],
                    'valid_date' => $otp['valid_date']
                ]
            ],
        ];
    }

    public function createByEmail($params)
    {

        $validator = Validator::make($params, [
            'user_email' => 'required|email',
            'user_type' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $isUserExist = $this->user->findOne($params);
        if ($isUserExist) {
            return [
                'status' => 409,
                'data' => ['message' => 'User already exist'],
            ];
        }

        $user = $this->user->create($params);
    }

    public function update($params, $id)
    {

        $validator = Validator::make($params, [
            'user_phone_number' => 'regex:/[+](62)[0-9]/',
            'user_email' => 'email',
            'display_name' => 'string',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $isUserExist = $this->user->findOne($params);

        if ($isUserExist && $isUserExist['ID'] != $id) {
            return [
                'status' => 409,
                'data' => ['message' => 'User already exist'],
            ];
        }

        $user = $this->user->update($params, $id);
        if (!$user) {
            return [
                'status' => 404,
                'data' => ['message' => 'User not found'],
            ];
        }

        return [
            'status' => 200,
            'data' => $user,
        ];
    }


    public function destroy($id)
    {

        $user = $this->user->deleteById($id);
        if (!$user) {
            return [
                'status' => 404,
                'data' => ['message' => 'Data not found'],
            ];
        }

        return [
            'status' => 202,
            'data' => ['message' => 'Success deleted data'],
        ];
    }

    public function login($params)
    {

        $validator = Validator::make($params, [
            'user_phone_number' => 'required|regex:/[+](62)[0-9]/'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $user = $this->user->findOne($params);
        if (!$user) {
            return [
                'status' => 409,
                'data' => ['message' => 'User is not exist'],
            ];
        }

        $otp = $this->otp->generateToken($user['ID']);

        self::sendMessage(' This is your Mitraruma OTP ' . $otp['otp'].'. It will expired in 60 minutes', $user['user_phone_number']);

        return [
            'status' => 201,
            'data' => [
                'message' => 'Please check your message',
                'value' => [
                    'valid_date' => $otp['valid_date']
                ]
            ],
        ];
    }

    public function loginOtp($params)
    {

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

        $user = $this->user->findOne($params);
        if (!$user) {
            return [
                'status' => 409,
                'data' => ['message' => 'User is not exist'],
            ];
        }

        $params['user_id'] = $user['ID'];
        $otp = $this->otp->isOtpValid($params);
        if ($otp) {
            $token = $this->jwt->encode($user);
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

    public function verifyOtp($params)
    {

        $validator = Validator::make($params, [
            'user_phone_number' => 'required|regex:/[+](62)[0-9]/',
            'otp' => 'required|int|exists:wp_otps,otp'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $user = $this->user->findOne($params);
        if (!$user) {
            return [
                'status' => 409,
                'data' => ['message' => 'User is not exist'],
            ];
        }

        $params['user_id'] = $user['ID'];
        $otp = $this->otp->isOtpValid($params);
        if ($otp) {
            $user->user_status = 1;
            $user->save();

            $token = $this->jwt->encode($user);
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

    public function loginByEmail($params)
    {

        $validator = Validator::make($params, [
            'user_email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $user = $this->user->findOne($params);
        if (!$user) {
            return [
                'status' => 409,
                'data' => ['message' => 'User is not exist'],
            ];
        } else {
            $user->update($params);
            $user->save();
        }

        $token = $this->jwt->encode($user);
        return [
            'status' => 200,
            'data' => ['token' => $token],
        ];
    }

    public function loginByPassword($params)
    {

        $validator = Validator::make($params, [
            'user_login' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
            ];
        }

        $validatorEmail = Validator::make(['user_login' => $params['user_login']], [
            'user_login' => 'email'
        ]);

        $isEmail = !$validatorEmail->fails();
        $params['user_login'] = $isEmail ? $params['user_login'] : $params['user_login'] . '@gmail.com';

        try {
            $user = Auth::attempt($params);
            if (!$user) {
                return [
                    'status' => 401,
                    'data' => ['message' => 'Wrong password or user login'],
                ];
            } else {
                $user = $this->user->findOne($params);
            }
            if ($user->user_status != 0) {
                $token = $this->jwt->encode($user);
                return [
                    'status' => 200,
                    'data' => ['token' => $token, 'user' => $user],
                ];
            } else {
                return [
                    'status' => 400,
                    'data' => ['message' => "plese verify your phone number using sended OTP"],
                ];
            }
        } catch (\Exception $e) {
            return ['status' => 500, 'data' => ['message' => $e->getMessage()]];
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
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
