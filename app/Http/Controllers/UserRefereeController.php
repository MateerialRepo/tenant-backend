<?php

namespace App\Http\Controllers;

use App\Models\UserReferee;
use Illuminate\Http\Request;
use App\Http\Requests\UserRefereeRequest;

class UserRefereeController extends Controller
{
    //
    public function index($user_id){
        try{
            $userReferee = UserReferee::where('user_id', $user_id)->get();
            $data['status'] = 'Success';
            $data['data'] = $userReferee;
            return response()->json($data, 200);

        }catch(\Exception $exception){
            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);
        }
        
    }

    public function store(UserRefereeRequest $request, $user_id){
        try{

            $userReferee = UserReferee::create([
                'user_id' => $user_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'address' => $request->address
            ]);

            $data['status'] = 'Success';
            $data['message'] = 'Registration Successful';
            return response()->json($data, 201);

       } catch (\Exception $exception) {

            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);

       }
    }

    public function update(UserRefereeRequest $request, $user_id){
        try{

            $userReferee = UserReferee::where('user_id', $user_id)->first();
            $userReferee->first_name = $request->first_name;
            $userReferee->last_name = $request->last_name;
            $userReferee->phone_number = $request->phone_number;
            $userReferee->email = $request->email;
            $userReferee->address = $request->address;
            $userReferee->save();

            $data['status'] = 'Success';
            $data['message'] = 'Next of Kin Update Successful';
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
