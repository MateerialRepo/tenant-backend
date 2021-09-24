<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRefereeController;
use App\Http\Controllers\UserNextOfKinController;
use App\Http\Controllers\ForgotPasswordController;

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




Route::get('/test', function(){
    return 'Api link is up';
});


Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'registration']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/password/forgot', [ForgotPasswordController::class, 'forgot']);
    Route::post('/password/reset', [ForgotPasswordController::class, 'reset']);
});


Route::middleware('auth:api')->prefix('v1')->group(function () {
    Route::get('/user', [UserController::class, 'user'] ); //works
    Route::post('/next-of-kin', [UserNextOfKinController::class, 'createAndUpdate'] ); //
    Route::post('/referee', [UserRefereeController::class, 'createAndUpdate'] ); 
    Route::post('/user', [UserController::class, 'updateProfile'] );
    Route::post('/user-kyc-update', [UserController::class, 'updateUserKYC'] );
    Route::post('/user-profile-pic', [UserController::class, 'uploadprofilepic'] );
    Route::post('/user-password-update', [UserController::class, 'updatepassword'] );
    Route::post('/logout', [AuthController::class, 'logout'] );
});





