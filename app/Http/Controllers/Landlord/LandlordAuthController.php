<?php

namespace App\Http\Controllers\Landlord;


use App\Models\Landlord;
use Illuminate\Support\Str;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class LandlordAuthController extends Controller
{
    //
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $credentials = $request->only('email', 'password');
        // if (Auth::guard('landlord')->attempt($credentials)) {
        //     $user = Auth::guard('landlord')->user();
        //     $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        //     return response()->json(['token' => $token], 200);
        // } else {
        //     return response()->json(['error' => 'Unauthorised'], 401);
        // }

        if( Auth::guard('landlord')->attempt($credentials) ){
            $landlord = Auth::guard('landlord')->user();
            $token = $landlord->createToken('api-application')->accessToken;
            $landlord['password'] = '';
            $data['status'] = 'Success';
            $data['message'] = 'Login Successful';
            $data['token'] = $token;
            $data['landlord'] = $landlord;
            return response()->json($data, 200);
        }else{
            $data['status'] = 'Failed';
            $data['message'] = 'Invalid Email or Password';
            return response()->json($data, 401);
        }
    }

    

    public function logout(){
        $landlord = Auth::guard('landlord-api')->token();
        $landlord->revoke();
        $data['status'] = 'Success';
        $data['message']= 'Successfully logged out';
        return response()->json($data, 200);
    }



    public function registration(Request $request){

       try{

            $landlordid = "LND-".Str::random(10)."-BRC";

            $landlord = new landlord;
            $landlord->first_name = $request->first_name;
            $landlord->last_name = $request->last_name;
            $landlord->phone_number = $request->phone_number;
            $landlord->email = $request->email;
            $landlord->password = bcrypt($request->password);
            $landlord->role_id = 2;
            $landlord->landlordid = $landlordid;
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
