<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\WpUser;
use Twilio\Rest\Client;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @param  \App\Http\Controllers\OtpController  $otp
     * @return void
     */
    public function __construct(
        OtpController $otp
    )
    {
        $this->otp = $otp;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_phone_number' => 'required|regex:/[+](62)[0-9]/',
        ]);

        $params = $request->all();
        $params['user_type'] =  'customer';

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first('user_phone_number')
            ], 422);
        }

        $isUserExist = WpUser::where('user_phone_number', $params['user_phone_number'])->first();
        if($isUserExist) {
            return response(['message' => 'User already exist'], 409)->header('Content-Type', 'application/json');
        }

        $user = WpUser::create($params);

        $otp = $this->otp->store($request);
        $otp = json_decode($otp->getContent())->otp;

        self::sendMessage(' this is your Mitraruma OTP '.$otp, $user['user_phone_number']);
        return response(['message' => 'Please check your message'], 200)->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    private function sendMessage($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        try {
            $client->messages->create($recipients, ['from' => $twilio_number, 'body' => $message]);
        }
        catch (Throwable $e) {
            report($e);
        }
    }
}
