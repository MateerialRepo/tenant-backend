<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;


class AuthController extends Controller
{
    //
    public function login(Request $request){

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
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
            User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'role_id'=>4,
                'password' => bcrypt($request->password),
            ]);        

            $data['status'] = 'success';
            $data['message'] = 'Registration Successful';
            return response()->json($data, 201);

       } catch (\Exception $exception) {

            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);

       }
        
        
    }
}
