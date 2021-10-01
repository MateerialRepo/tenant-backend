<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AutoSearchController;
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

    // AutoComplete Search for UserName
    Route::get('/search/user', [AutoSearchController::class, 'searchUser'] );

    //tickets or facilities
    Route::get('/ticket', [TicketController::class, 'fetchAll'] );
    Route::get('/ticket/{id}', [TicketController::class, 'fetchSingle'] );
    Route::post('/ticket/create', [TicketController::class, 'createAndUpdate'] );
    Route::post('/ticket/comment/{id}', [TicketController::class, 'ticketComment'] );
    Route::post('/ticket/resolve/{id}', [TicketController::class, 'resolveTicket'] );
    Route::post('/ticket/reopen/{id}', [TicketController::class, 'reopenTicket'] );

    // Documents
    Route::get('/document', [DocumentController::class, 'fetchAllDocument'] );
    Route::get('/document/{id}', [DocumentController::class, 'fetchSingleDocument'] );
    Route::post('/document/create', [DocumentController::class, 'createAndUpdate'] );
    Route::post('/document/delete/{id}', [DocumentController::class, 'deleteDocument'] );


});





