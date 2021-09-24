<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserNextOfKin;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserNextOfKinRequest;

class UserNextOfKinController extends Controller
{
    //
    public function index(){
        
    }

    public function createAndUpdate(UserNextOfKinRequest $request){
        try{

            $user = Auth::user();
            $user->userNextOfKin()->updateOrCreate(
                ['user_id' => $user->id], 
                [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'relationship' => $request->relationship
                ]
            );
            $user = Auth::user()->load('userNextOfKin', 'userReferee');


            $data['status'] = 'Success';
            $data['message'] = 'Registration or Update Successful';
            $data['data'] = $user;
            return response()->json($data, 200);

       } catch (\Exception $exception) {

            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);

       }
    }

    public function update(UserNextOfKinRequest $request, $user_id){
      
    }

    public function destroy(Request $request){

    }
}
