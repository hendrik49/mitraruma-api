<?php

namespace App\Services;

use App\Http\Resources\UserVendorResource;
use App\Models\WpUser;
use App\Models\WpProject;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

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

    private $project;


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
        \App\Repositories\ProjectRepository $project,
        \App\Repositories\UserRepository $user
    ) {
        $this->otp = $otp;
        $this->jwt = $jwt;
        $this->user = $user;
        $this->projectRepo = $project;
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


    public function showSchedule($params)
    {
        if ($params['user_jwt_type'] == "customer")
            $user = $this->projectRepo->findSchedulesByUserId($params['user_id']);
        else if ($params['user_jwt_type'] == "vendor")
            $user = $this->projectRepo->findSchedulesByVendorId($params['user_id']);
        else
            $user = $this->projectRepo->findSchedulesByAdminId($params['user_id']);

        if (!$user->count()) {
            return [
                'status' => 404,
                'data' => ['message' => 'Schedule not found'],
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

        self::sendMessage(' This is your Mitraruma OTP ' . $otp['otp'] . '. It will expired in 60 minutes', $user['user_phone_number']);

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

        try {

            DB::beginTransaction();

            $validator = Validator::make($params, [
                'user_phone_number' => 'required|regex:/[+](62)[0-9]/|unique:wp_users,user_phone_number',
                'user_type' => 'required',
                'user_email' => 'nullable|email',
                'display_name' => 'required:min:3',
                'password' => 'required|min:6',
                'company_name' => 'nullable|min:3'
            ]);

            if ($validator->fails()) {
                return [
                    'status' => 422,
                    'data' => ['message' => $validator->errors()->first()]
                ];
            }

            $resp = $this->postSignUpAPI($params);

            $isUserExist = $this->user->findOne($params);

            if ($resp['errorCode']) {
                return [
                    'status' => 400,
                    'data' => ['message' => $resp['error']],
                ];
            }

            $params['password'] = bcrypt($params['password']);
            $params['user_registered'] = date("Y-m-d H:i:s");
            $params['user_email'] =  $params['user_email'] ? $params['user_email'] : $params['user_phone_number'] . '@gmail.com';
            $params['user_login'] = $params['user_email'];
            $params['ID'] = $resp['userId'];

            if ($isUserExist) {
                return [
                    'status' => 409,
                    'data' => ['message' => 'User already exist'],
                ];
            }

            $user = $this->user->create($params);

            $otp = $this->otp->generateToken($user['ID']);

            $resp = $this->sendMessage(' This is your Mitraruma OTP ' . $otp['otp'] . '. It will expired in 60 minutes.', $user['user_phone_number']);

            if ($resp==null) {

                DB::rollBack();
                return [
                    'status' => 400,
                    'data' => ['message' => "not a valid phone number."],
                ];
            }

            DB::commit();

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
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 500,
                'data' => ['message' => $e->getMessage()]
            ];
        }
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

        $isUserExist = $this->user->findById($id);

        if ($isUserExist == null) {
            return [
                'status' => 404,
                'data' => ['message' => 'User is not found'],
            ];
        }
        if (isset($params['user_email']) && $isUserExist->user_email == $params['user_email']) {
            unset($params['user_email']);
        }
        if (isset($params['user_phone_number']) && $isUserExist->user_phone_number == $params['user_phone_number']) {
            unset($params['user_phone_number']);
        }
        $validator = Validator::make($params, [
            'user_phone_number' => 'nullable|regex:/[+](62)[0-9]/|unique:wp_users,user_phone_number',
            'user_email' => 'nullable|email|unique:wp_users,user_email',
            'display_name' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 422,
                'data' => ['message' => $validator->errors()->first()]
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

    public function destroyByUserLogin($params)
    {

        $user = $this->user->deleteByUserLogin($params);
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

        self::sendMessage(' This is your Mitraruma OTP ' . $otp['otp'] . '. It will expired in 60 minutes', $user['user_phone_number']);

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

    public function resendOtp($params)
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

        $this->sendMessage(' This is your Mitraruma OTP ' . $otp['otp'] . '. It will expired in 60 minutes.', $user['user_phone_number']);

        if ($otp) {
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
        } else {
            return [
                'status' => 400,
                'data' => ['message' => 'Phone number is not valid']
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
                'data' => ['token' => $token, 'message' => 'otp verified successfully'],
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
            //$user->update($params);
            //$user->save();
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
        $resp = $this->postSignInAPI($params, $isEmail);

        if (isset($resp['errorCode']) || $resp == null) {
            $error = $resp['error'];
            if ($resp['errorCode'] == 'IDP_API_EXCEPTION')
                $error = "Wrong Password";
            elseif ($resp['errorCode'] == 'UNABLE_TO_GET_USER_FROM_DB')
                $error = "Wrong Phone Number or Email";

            return [
                'status' => 400,
                'data' => ['message' =>  $error],
            ];
        }

        $params['user_login'] = $isEmail ? $params['user_login'] : $params['user_login'] . '@gmail.com';

        $userExsist = $this->user->findOne($params);

        try {
            $user = Auth::attempt($params);
            if (!$user && $userExsist) {
                return [
                    'status' => 401,
                    'data' => ['message' => 'Wrong password or user login'],
                ];
            } else {
                $queryParam['ID'] = $resp['userId'];
                $user = $this->user->findOne($queryParam);

                if ($user == null && $userExsist == null)  {
                    $paramNew['user_phone_number'] = $resp['phoneNo'];
                    $paramNew['user_type'] = $resp['buyerType'] == 'CUSTOMER' ? 'customer' : 'vendor';
                    $paramNew['ID'] = $resp['userId'];
                    $paramNew['user_email'] = $params['user_login'];
                    $paramNew['user_login'] = $params['user_login'];
                    $paramNew['display_name'] = $resp['fullName'];
                    $paramNew['password'] = bcrypt($params['password']);
                    $paramNew['company_name'] = '';
                    $paramNew['user_status'] = 1;
                    $paramNew['user_picture_url'] = '/images/img-customer.jpeg';
                    $paramNew['user_registered'] = date('y-m-d');

                    $user = $this->user->create($paramNew);
                    if ($user == null) {
                        return [
                            'status' => 400,
                            'data' => ['message' =>  $resp == null ? 'External API Integration error' : $resp['error']],
                        ];
                    }
                }else{
                    $user = $userExsist;
                }
            }
            if ($user->user_status != 0) {
                $token = $this->jwt->encode($user);
                return [
                    'status' => 200,
                    'data' => ['token' => $token, 'externalUser' => $resp, 'user' => $user],
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
            return $client->messages->create($recipients, ['from' => $twilio_number, 'body' => $message]);
        } catch (\Throwable $e) {
            report($e);
            return $e;
        }
    }

    public function postSignUpAPI($params)
    {
        try {
            $client = new GuzzleHttp\Client(['base_uri' => env('API_MITRARUMA', 'https://qa.mitraruma.com/')]);

            $headers = [
                'Content-Type'          => 'application/json'
            ];

            $json =  [
                "userType" => "BUYER",
                "buyerType" => $params['user_type'] == 'customer' ? 'CUSTOMER' : 'APPLICATOR',
                "fullName" => $params['display_name'],
                "phoneNo" => $params['user_phone_number'],
                "useremail" =>  $params['user_email'],
                "password" =>  $params['password'],
                "phoneCountryCode" => "+62"
            ];

            $response = $client->post('buyer-service/auth/signup', [
                'headers' => $headers,
                'json' => $json
            ]);

            $data =  json_decode($response->getBody(), true);
            return $data;
        } catch (\Exception $e) {
            $message = $e->getMessage() . ". Line " . $e->getLine();
            return $message;
        }
    }

    public function resetPasswordLink($params)
    {
        try {

            $validator = Validator::make($params, [
                'user_email' => 'nullable|email',
                'user_phone_number' => 'nullable|regex:/[+](62)[0-9]/'
            ]);

            if ($validator->fails()) {
                return [
                    'status' => 422,
                    'data' => ['message' => $validator->errors()->first()]
                ];
            }

            $client = new GuzzleHttp\Client(['base_uri' => env('API_MITRARUMA', 'https://qa.mitraruma.com/')]);

            $headers = [
                'Content-Type'          => 'application/json'
            ];

            $json =  [
                "lang" => "id",
                "userType" => "BUYER",
                "orgIdfier" => "scg",
                "useremail" => isset($params['user_email']) ? $params['user_email'] : null,
                "phoneNo" => isset($params['user_phone_number']) ? $params['user_phone_number'] : null,
            ];

            $response = $client->post('buyer-service/auth/send-reset-link', [
                'headers' => $headers,
                'json' => $json
            ]);

            $data =  json_decode($response->getBody(), true);
            if ($data["errorCode"]) {
                return [
                    'status' => 404,
                    'data' => ['message' => $data["error"]]
                ];
            } else {
                $result['status'] = $response->getStatusCode();
                $result['data'] = $data;
                return  $result;
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $result['status'] = $response->getStatusCode();
            $result['data'] = $data;
            return  $message;
        }
    }

    public function postSignInAPI($params, $isEmail)
    {
        try {

            $headers = [
                'Content-Type'          => 'application/json'
            ];

            $json =  [
                "lang" => "id",
                "orgIdfier" => "scg",
                "userType" => "BUYER",
                "useremail" =>  $params['user_login'],
                "password" =>  $params['password'],
                "phoneNo" => $isEmail ? null : $params['user_login']
            ];

            $response = Http::withHeaders($headers)->post(env('API_MITRARUMA', 'http://www.mitraruma.com').'/buyer-service/auth/login', $json);

            $data =  json_decode($response->getBody(), true);
            $userProfile = $this->getProfileAPI($data);
            $data['buyerType'] = isset($userProfile['data']['buyerType']) ? $userProfile['data']['buyerType'] : 'CUSTOMER';
            return $data;
        } catch (\Exception $e) {
            $message = $e->getMessage() . ". Line " . $e->getLine();
            return $message;
        }
    }

    public function getProfileAPI($resp)
    {
        try {

            $response = Http::get(env('CHAT_MITRARUMA', 'http://chat.mitraruma.com:3000') . '/api/profile?id=' . $resp['userId']);

            $data =  json_decode($response->getBody(), true);
            return $data;
        } catch (\Exception $e) {
            $message = $e->getMessage() . ". Line " . $e->getLine();
            return $message;
        }
    }

    public function getVendor()
    {
        try {

            $response = Http::get(env('CHAT_MITRARUMA', 'http://chat.mitraruma.com:3000') . '/api/applicator');

            $data =  json_decode($response->getBody(), true);
            $result['status'] = $response->getStatusCode();

            $params['user_type'] = 'vendor';
            $vendor = $this->user->find($params);

            $new = array();
            foreach ($data["name"] as $key => $var) {
                $exist = $vendor->where('user_phone_number', $var['user_phone'])->first();
                if ($exist) {
                    $var["externalId"] = $var["id"];
                    $var["id"] = $exist->ID;
                    $var["name"] = $var["id"] . ' | ' . $var["display_name"];
                    $var["finished_project"] = WpProject::where('status', 'Project Ended')->where('vendor_user_id', $exist->ID)->count();
                    $var["unfinished_project"] =  WpProject::where('status', 'Project Ended')->where('vendor_user_id', $exist->ID)->count();
                    $new[] = $var;
                }
                // } else {
                //     $var["externalId"] = $var["id"];
                //     $var["id"] = null;
                //     $var["name"] = $var["display_name"] . " (NOT-SYNCH)";
                //     $var["finished_project"] = 0;
                //     $var["unfinished_project"] = 0;
                //     $new[] = $var;
                // }
            }
            $result['data'] = $new;
            return $result;
        } catch (\Exception $e) {
            $result['status'] = $e->getCode();
            $result['data'] = $e->getMessage();
            return $result;
        }
    }
}
