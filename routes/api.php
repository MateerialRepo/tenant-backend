<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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
    Route::get('/login', [AuthController::class, 'login']);
    Route::post('/password/forgot', [ForgotPasswordController::class, 'forgot']);
    Route::post('/password/reset', [ForgotPasswordController::class, 'reset']);
});


Route::middleware('auth:api')->prefix('v1')->group(function () {
    Route::get('/user', [AuthController::class, 'user'] );
    Route::post('/logout', [AuthController::class, 'logout'] );
});



// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });




