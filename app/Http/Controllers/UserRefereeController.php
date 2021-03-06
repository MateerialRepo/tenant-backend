<?php

namespace App\Http\Controllers;

use App\Models\UserReferee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRefereeRequest;
use App\Models\User;

class UserRefereeController extends Controller
{
    //
    public function index(){
       
        
    }

    public function createAndUpdate(UserRefereeRequest $request){
        try{

            $user = Auth::user();
            $user->userReferee()->updateOrCreate(
                ['user_id' => $user->id], 
                [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'address' => $request->address
                ]
            );
            $user = Auth::user()->load('userNextOfKin', 'userReferee');
            
            $data['status'] = 'Success';
            $data['message'] = 'Registration Successful';
            $data['data'] = $user;
            return response()->json($data, 200);

       } catch (\Exception $exception) {

            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);

       }
    }


    public function destroy(Request $request){

    }
}
