<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicatorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ChatroomController;
use App\Http\Controllers\CmsController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserChatController;
use App\Http\Controllers\UserChatroomController;
use App\Http\Controllers\UserConsultationController;
use App\Http\Controllers\UserExtensionAttributeController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserTokenController;
use App\Http\Controllers\VendorChatroomController;

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

Route::POST('/notification/send', [\App\Http\Controllers\NotificationController::class, 'send']);

Route::POST('/login', [AuthController::class, 'login']);
Route::POST('/login/admin', [AuthController::class, 'loginAdmin']);
Route::POST('/login/otp', [AuthController::class, 'loginOtp']);
//Route::POST('/login/email', [AuthController::class, 'loginByEmail']); //This route is only for testing
Route::GET('/login/google', [AuthController::class, 'loginGoogleRedirect'])->middleware(['web']);
Route::GET('/login/google/callback', [AuthController::class, 'handleGoogleCallback'])->middleware(['web']);
Route::POST('/login/google/token', [AuthController::class, 'loginGoogleToken']);


Route::POST('/applicator/register', [ApplicatorController::class, 'store']);
Route::POST('/user/register', [UserController::class, 'store']);

Route::POST('/user/token', [UserTokenController::class, 'store'])->middleware('jwt.user');
Route::DELETE('/user/token', [UserTokenController::class, 'destroy'])->middleware('jwt.user');

Route::GET('/user/profile', [UserProfileController::class, 'get'])->middleware('jwt.user');
Route::PUT('/user/profile', [UserProfileController::class, 'update'])->middleware('jwt.user');
Route::GET('/user/profile/address', [UserAddressController::class, 'index'])->middleware('jwt.user');
Route::POST('/user/profile/address', [UserAddressController::class, 'store'])->middleware('jwt.user');
Route::PUT('/user/profile/address/{id}', [UserAddressController::class, 'update'])->middleware('jwt.user');
Route::DELETE('/user/profile/address/{id}', [UserAddressController::class, 'destroy'])->middleware('jwt.user');

Route::GET('/user/profile/extension-attribute', [UserExtensionAttributeController::class, 'index'])->middleware('jwt.user');
Route::POST('/user/profile/extension-attribute', [UserExtensionAttributeController::class, 'store'])->middleware('jwt.user');
Route::PUT('/user/profile/extension-attribute/{id}', [UserExtensionAttributeController::class, 'update'])->middleware('jwt.user');
Route::DELETE('/user/profile/extension-attribute/{id}', [UserExtensionAttributeController::class, 'destroy'])->middleware('jwt.user');

Route::GET('/user/consultation', [UserConsultationController::class, 'index'])->middleware('jwt.user');
Route::POST('/user/consultation', [UserConsultationController::class, 'store'])->middleware('jwt.user');
Route::PUT('/user/consultation/{id}', [UserConsultationController::class, 'update'])->middleware('jwt.user');
Route::DELETE('/user/consultation/{id}', [UserConsultationController::class, 'destroy'])->middleware('jwt.user');
Route::GET('/user/consultation/{id}', [UserConsultationController::class, 'show'])->middleware('jwt.user');

Route::GET('/user/chatroom', [UserChatroomController::class, 'index'])->middleware('jwt.user');
Route::POST('/user/chatroom', [UserChatroomController::class, 'store'])->middleware('jwt.user');
Route::PUT('/user/chatroom/{id}', [UserChatroomController::class, 'update'])->middleware('jwt.user');
Route::DELETE('/user/chatroom/{id}', [UserChatroomController::class, 'destroy'])->middleware('jwt.user');
Route::GET('/user/chatroom/{id}', [UserChatroomController::class, 'show'])->middleware('jwt.user');
Route::GET('/user/chatroom/{id}/users', [UserChatroomController::class, 'showUsers'])->middleware('jwt.user');
//Route::GET('/user/chatroom/{id}/chat-files', [UserChatroomController::class, 'showChatFiles'])->middleware('jwt.user');

Route::GET('/user/chat/{roomId}', [UserChatController::class, 'show'])->middleware('jwt.user');
Route::POST('/user/chat/{roomId}', [UserChatController::class, 'store'])->middleware('jwt.user');
Route::DELETE('/user/chat/{roomId}/read', [UserChatController::class, 'readChat'])->middleware('jwt.user');

//VENDOR
Route::GET('/vendor/chatroom', [VendorChatroomController::class, 'index'])->middleware('jwt.user');

//ADMIN SITE
Route::GET('/user/vendor', [UserController::class, 'showVendor'])->middleware('jwt.admin');

Route::GET('/user/address', [UserAddressController::class, 'index'])->middleware('jwt.admin');
Route::POST('/user/address', [UserAddressController::class, 'store'])->middleware('jwt.admin');
Route::PUT('/user/address/{id}', [UserAddressController::class, 'update'])->middleware('jwt.admin');
Route::DELETE('/user/address/{id}', [UserAddressController::class, 'destroy'])->middleware('jwt.admin');
Route::GET('/user/address/{id}', [UserAddressController::class, 'show'])->middleware('jwt.admin');

Route::GET('/user/extension-attribute', [UserExtensionAttributeController::class, 'index'])->middleware('jwt.admin');
Route::POST('/user/extension-attribute', [UserExtensionAttributeController::class, 'store'])->middleware('jwt.admin');
Route::PUT('/user/extension-attribute/{id}', [UserExtensionAttributeController::class, 'update'])->middleware('jwt.admin');
Route::DELETE('/user/extension-attribute/{id}', [UserExtensionAttributeController::class, 'destroy'])->middleware('jwt.admin');
Route::GET('/user/extension-attribute/{id}', [UserExtensionAttributeController::class, 'show'])->middleware('jwt.admin');

Route::GET('/user/{id}', [UserController::class, 'show'])->middleware('jwt.admin');
Route::DELETE('/user/{id}', [UserController::class, 'destroy'])->middleware('jwt.admin');

Route::GET('/cms', [CmsController::class, 'index'])->middleware('jwt.admin');
Route::POST('/cms', [CmsController::class, 'store'])->middleware('jwt.admin');
Route::PUT('/cms/{id}', [CmsController::class, 'update'])->middleware('jwt.admin');
Route::DELETE('/cms/{id}', [CmsController::class, 'destroy'])->middleware('jwt.admin');
Route::GET('/cms/{id}', [CmsController::class, 'show']);
Route::GET('/cms/name/{name}', [CmsController::class, 'showByName']);

Route::GET('/consultation', [ConsultationController::class, 'index'])->middleware('jwt.admin');
Route::GET('/consultation/export', [ConsultationController::class, 'export'])->middleware('jwt.admin');
Route::POST('/consultation', [ConsultationController::class, 'store'])->middleware('jwt.admin');
Route::PUT('/consultation/{id}', [ConsultationController::class, 'update'])->middleware('jwt.admin');
Route::DELETE('/consultation/{id}', [ConsultationController::class, 'destroy'])->middleware('jwt.admin');
Route::GET('/consultation/{id}', [ConsultationController::class, 'show'])->middleware('jwt.admin');
Route::GET('/consultation/{id}/status', [ConsultationController::class, 'showStatus'])->middleware('jwt.admin');
Route::GET('/consultation/{id}/chat-files', [ConsultationController::class, 'showChatFiles'])->middleware('jwt.admin');

Route::GET('/chatroom', [ChatroomController::class, 'index'])->middleware('jwt.admin');
Route::POST('/chatroom', [ChatroomController::class, 'store'])->middleware('jwt.admin');
Route::POST('/chatroom/vendor', [ChatroomController::class, 'storeVendorRoom'])->middleware('jwt.admin');
Route::PUT('/chatroom/{id}', [ChatroomController::class, 'update'])->middleware('jwt.admin');
Route::DELETE('/chatroom/{id}', [ChatroomController::class, 'destroy'])->middleware('jwt.admin');
Route::GET('/chatroom/{id}', [ChatroomController::class, 'show'])->middleware('jwt.admin');


Route::GET('/chart/client-count', [ChartController::class, 'clientCount'])->middleware('jwt.admin');
Route::GET('/chart/applicator-count', [ChartController::class, 'applicatorCount'])->middleware('jwt.admin');
Route::GET('/chart/consultation-count', [ChartController::class, 'consultationCount'])->middleware('jwt.admin');
Route::GET('/chart/order-status', [ChartController::class, 'consultationCount'])->middleware('jwt.admin');
Route::GET('/chart/income-month', [ChartController::class, 'consultationCount'])->middleware('jwt.admin');
Route::GET('/chart/consultation-month', [ChartController::class, 'consultationCount'])->middleware('jwt.admin');
Route::GET('/chart/consultation-by-area', [ChartController::class, 'consultationCount'])->middleware('jwt.admin');

