<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicatorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserExtensionAttributeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::POST('/login', [AuthController::class, 'login']);
Route::POST('/login/otp', [AuthController::class, 'loginOtp']);;
Route::POST('/applicator/register', [ApplicatorController::class, 'store']);
Route::POST('/user/register', [UserController::class, 'store']);
Route::GET('/user/{id}', [UserController::class, 'show']);

Route::GET('/user/address', [UserAddressController::class, 'index']);
Route::POST('/user/address', [UserAddressController::class, 'store']);
Route::PUT('/user/address/{id}', [UserAddressController::class, 'update']);
Route::DELETE('/user/address/{id}', [UserAddressController::class, 'destroy']);
Route::GET('/user/address/{id}', [UserAddressController::class, 'show']);

Route::GET('/user/extension-attribute', [UserExtensionAttributeController::class, 'index']);
Route::POST('/user/extension-attribute', [UserExtensionAttributeController::class, 'store']);
Route::PUT('/user/extension-attribute/{id}', [UserExtensionAttributeController::class, 'update']);
Route::DELETE('/user/extension-attribute/{id}', [UserExtensionAttributeController::class, 'destroy']);
Route::GET('/user/extension-attribute/{id}', [UserExtensionAttributeController::class, 'show']);
