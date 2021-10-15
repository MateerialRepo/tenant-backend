<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;


class AuthController extends Controller
{
    //
    public function login(Request $request){

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user()->load('userNextOfKin', 'userReferee');
            $token = $user->createToken('api-application')->accessToken;
            $user['password'] = '';
            $data['status'] = 'Success';
            $data['message'] = 'Login Successful';
            $data['token'] = $token;
            $data['user'] = $user;
            return response()->json($data, 200);
        }else{
            $data['status'] = 'Failed';
            $data['message'] = 'Invalid Email or Password';
            return response()->json($data, 401);
        }
    }

    

    public function logout(Request $request){
        $user = Auth::user()->token();
        $user->revoke();
        $data['status'] = 'Success';
        $data['message']= 'Successfully logged out';
        return response()->json($data, 200);
    }



    public function registration(RegisterRequest $request){

       try{

            $tenantid = "TNT-".Str::random(10)."-BRC";

            $user = new User;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->phone_number = $request->phone_number;
            $user->email = $request->email;
            $user->password = bcrypt($request->password); //Hash::make($request->password);
            $user->role_id = 4;
            $user->breicsid = $tenantid;
            $user->save();

            $data['status'] = 'Success';
            $data['message'] = 'Registration Successful';
            return response()->json($data, 201);

       } catch (\Exception $exception) {

            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);

       }
        
        
    }

    public function landlordRegistration(RegisterRequest $request){

        try{
 
             $landlordid = "LND-".Str::random(10)."-BRC";
 
             $landlord = new User;
             $landlord->first_name = $request->first_name;
             $landlord->last_name = $request->last_name;
             $landlord->phone_number = $request->phone_number;
             $landlord->email = $request->email;
             $landlord->password = bcrypt($request->password);
             $landlord->role_id = 2;
             $landlord->breicsid = $landlordid;
             $landlord->save();
 
             $data['status'] = 'Success';
             $data['message'] = 'Registration Successful';
             return response()->json($data, 201);
 
        } catch (\Exception $exception) {
 
             $data['status'] = 'Failed';
             $data['message'] = $exception->getMessage();
             return response()->json($data, 400);
 
        }   
         
     }


     
}
