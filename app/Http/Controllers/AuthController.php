<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Token;


class AuthController extends Controller
{
    //
    public function login(Request $request){

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $responseArray = [];
            $responseArray['token'] = $user->createToken('api-application')->accessToken;
            $responseArray['user_id'] = $user->id;
            $responseArray['email'] = $user->email;
            return response()->json($responseArray, 200);
        }else{
            $responseArray['status'] = 'Failed';
            $responseArray['message'] = 'Invalid Email or Password';
            return response()->json($responseArray, 401);
        }
    }



    public function logout(Request $request){
        $user = Auth::user()->token();
        $user->revoke();
        $responseArray['status'] = 'Success';
        $responseArray['message']= 'Successfully logged out';
        return response()->json($responseArray, 200);
    }



    public function registration(Request $request){
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string' ,
            'lastname' => 'required|string' ,
            'phone_number' => 'required|numeric' ,
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string|same:password'
        ]);
      
        if ($validator->fails()) {
            return response()->json($validator->errors(), 404);
        }

        $user = new User;
        $user->name = $request->input('firstname')." ".$request->input('lastname');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        $user_id = User::max('id');
        $user_detail = new UserDetail;
        $user_detail->user_id = $user_id;
        $user_detail->phone_number = $request->input('phone_number');
        $user_detail->save();

        $responseArray['status'] = 'success';
        $responseArray['message'] = 'Registration Successful';
        return response()->json($responseArray, 201);
        
    }
}
