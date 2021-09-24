<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateUserKYCRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Requests\UpdateUserProfilePicRequest;

class UserController extends Controller
{

    public function user(){
        return Auth::user()->load('userNextOfKin', 'userReferee');;
    }


    public function updatepassword(Request $request){
        try{

            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'new_password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);
            }


            $user = Auth::user();

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json(['error'=>'Current password does not match!'], 401);
            }

            $user->update(
                ['password' => Hash::make($request->new_password)]
            );


            $data['status'] = 'Success';
            $data['message'] = 'Password Updated Successfully';
            return response()->json($data, 204);

        }catch(\Exception $exception){
            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);
        }
    }


    public function updateProfile(UpdateUserProfileRequest $request)
    {
        //
        try{
            
            $user = Auth::user();
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'dob' => $request->dob,
                'occupation' => $request->occupation,
                'gender' => $request->gender,
                'address' => $request->address,
                'landmark' => $request->landmark,
                'state'=> $request->state,
                'country' => $request->country
                ]);

            $user = Auth::user()->load('userNextOfKin', 'userReferee');

            $data['status'] = 'Success';
            $data['message'] = 'User Profile Update Successful';
            $data['data'] = $user;
            return response()->json($data, 200);

       } catch (\Exception $exception) {

            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);

       }
    }

   
    public function updateUserKYC(Request $request){

        try{

            $validator = Validator::make($request->all(), [
                'kyc_img' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);
            }
            
            $idVerification = time().'.'.$request->kyc_img->extension();

            $user = Auth::user();
            $user->update([
                'KYC_status' => "completed",
                'KYC_type' => "NIN",
                'KYC_id' => "/tenants/tenantkyc/".$idVerification
                ]);
            
            $request->kyc_img->move(public_path('/tenants/tenantkyc'), $idVerification);

            $user = Auth::user()->load('userNextOfKin', 'userReferee');            
            $data['status'] = 'Success';
            $data['message'] = 'KYC Image Successfully Uploaded';
            $data['data'] = $user;
            return response()->json($data, 200);

        } catch (\Exception $exception) {
            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);
        }

    }

    public function uploadprofilepic(Request $request){

        try{

            $validator = Validator::make($request->all(), [
                'profile_pic' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);
            }
            
            $profilepic = time().'.'.$request->profile_pic->extension();

            $user = Auth::user();
            $user->update([
                'profile_pic' => "/tenants/tenantprofilepic/".$profilepic
                ]);

            $request->profile_pic->move(public_path('/tenants/tenantprofilepic'), $profilepic);

            $user = Auth::user()->load('userNextOfKin', 'userReferee');            
            $data['status'] = 'Success';
            $data['message'] = 'Profile Pic Uploaded Successfully';
            $data['data'] = $user;
            
            return response()->json($data, 200);

        } catch (\Exception $exception) {

            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);
        }

    }


    public function destroy($id)
    {
        //
    }
   
}
