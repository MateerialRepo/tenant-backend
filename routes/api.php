<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LandlordController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AutoSearchController;
use App\Http\Controllers\UserRefereeController;
use App\Http\Controllers\UserNextOfKinController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PropertyVerificationController;

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
    Route::post('/login', [AuthController::class, 'login']); //works for both landlord and tenant
    Route::post('/password/forgot', [ForgotPasswordController::class, 'forgot']);//works for both landlord and tenant
    Route::post('/password/reset', [ForgotPasswordController::class, 'reset']);//works for both landlord and tenant

    Route::post('/landlord/register', [AuthController::class, 'Landlordregistration']); //works for landlord
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
    Route::get('/ticket/{unique_id}', [TicketController::class, 'fetchSingle'] );
    Route::post('/ticket/create', [TicketController::class, 'createAndUpdate'] ); //not working
    Route::post('/ticket/comment/{unique_id}', [TicketController::class, 'ticketComment'] );
    Route::get('/ticket/resolve/{unique_id}', [TicketController::class, 'resolveTicket'] );
    Route::get('/ticket/reopen/{unique_id}', [TicketController::class, 'reopenTicket'] );
    Route::delete('/ticket/{unique_id}', [TicketController::class, 'deleteTicket'] );

    // Documents
    Route::get('/document', [DocumentController::class, 'fetchAllDocument'] );
    Route::get('/document/{unique_id}', [DocumentController::class, 'fetchSingleDocument'] );
    Route::post('/document/create', [DocumentController::class, 'createAndUpdate'] ); //not working
    Route::delete('/document/{unique_id}', [DocumentController::class, 'deleteDocument'] );


});


Route::middleware(['auth:api', 'is_landlord'])->prefix('v1')->group(function () {
    Route::get('/landlord', [LandlordController::class, 'landlord'] ); //works
    Route::post('/landlord', [LandlordController::class, 'updateLandlord'] ); //Done
    Route::post('/landlord/password/update', [LandlordController::class, 'updatepassword'] ); //Done
    Route::post('/landlord/profile-pic', [LandlordController::class, 'uploadprofilepic'] );//Done
    Route::post('/landlord/kyc', [LandlordController::class, 'updateLandlordKYC'] ); //Done
    Route::post('/landlord/kyc/update', [LandlordController::class, 'updateLandlordKYC'] );
    
    // Property routes
    Route::get('/property', [PropertyController::class, 'index'] );
    Route::get('/property/{id}', [PropertyController::class, 'getProperty'] );
    Route::post('/property', [PropertyController::class, 'createAndUpdateProperty'] );
    Route::post('/property/verify/{id}', [PropertyVerificationController::class, 'verifyProperty'] );

});






