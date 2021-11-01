<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CMS\ProjectController;
use App\Http\Controllers\CMS\UserController;
use App\Http\Controllers\CMS\VendorController;
use App\Http\Controllers\CMS\CmsManagmentController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::prefix('admin')->group(function () {
    Route::resource('proyek', ProjectController::class);
    Route::get('/proyek/edit-rate', [ProjectController::class, 'editRate'])->name('proyek.edit-rate');

    Route::resource('users', UserController::class);
    Route::resource('seting', CmsManagmentController::class);

    Route::get('/aplikator-dashboard', [VendorController::class, 'aplikatorDash'])->name('aplikator-dashboard');
    Route::get('/aplikator-dashboard-index', [VendorController::class, 'aplikatorDashIndex'])->name('aplikator-dashboard-index');
    Route::resource('aplikators', VendorController::class);
});
