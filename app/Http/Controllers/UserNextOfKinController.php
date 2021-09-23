<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserNextOfKinRequest;
use App\Models\UserNextOfKin;

class UserNextOfKinController extends Controller
{
    //
    public function index($user_id){
        try{
            $userNextOfKin = UserNextOfKin::where('user_id', $user_id)->get();
            $data['status'] = 'Success';
            $data['data'] = $userNextOfKin;
            return response()->json($data, 200);

        }catch(\Exception $exception){
            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);
        }
        
    }

    public function store(UserNextOfKinRequest $request, $user_id){
        try{

            $userNextOfKin = UserNextOfKin::create([
                'user_id' => $user_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'relationship' => $request->relationship,

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

    public function update(UserNextOfKinRequest $request, $user_id){
        try{
            $userNextOfKin = UserNextOfKin::where('user_id', $user_id)->first();
            $userNextOfKin->first_name = $request->first_name;
            $userNextOfKin->last_name = $request->last_name;
            $userNextOfKin->phone_number = $request->phone_number;
            $userNextOfKin->email = $request->email;
            $userNextOfKin->relationship = $request->relationship;
            $userNextOfKin->save();

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
