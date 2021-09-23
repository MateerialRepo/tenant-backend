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
        return Auth::user();
    }


    public function updatepassword(Request $request, $id){
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

            $user = User::find($id);
            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json(['success'=>'Password updated successfully!'], 200);

        }catch(\Exception $exception){
            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);
        }
    }


    public function updateProfile(UpdateUserProfileRequest $request, $id)
    {
        //
        try{
            $user = User::findorfail($id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->phone_number = $request->phone_number;
            $user->email = $request->email;
            $user->dob = $request->dob;
            $user->occupation = $request->occupation;
            $user->gender = $request->gender;
            $user->address = $request->address;
            $user->landmark = $request->landmark;
            $user->state = $request->state;
            $user->country = $request->country;
            $user->save();

            $data['status'] = 'Success';
            $data['message'] = 'User Profile Update Successful';
            return response()->json($data, 200);

       } catch (\Exception $exception) {

            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);

       }
    }

   
    public function updateUserKYC(Request $request, $id){

        try{

            $validator = Validator::make($request->all(), [
                'kyc_img' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);
            }
            
            $idVerification = time().'.'.$request->kyc_img->extension();
            $request->kyc_img->move(public_path('/tenants/tenantkyc'), $idVerification);

            $user = User::findorfail($id);
            $user->KYC_status = "completed";
            $user->KYC_type = "NIN";
            $user->KYC_id = "/tenants/tenantkyc/".$idVerification;
            $user->save();

            
            return response()->json([
                'status' => 'Success',
                'message' => 'KYC Image Successfully Uploaded'
            ], 200);

        } catch (\Exception $exception) {
            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);
        }

    }

    public function uploadprofilepic(Request $request, $id){

        try{

            $validator = Validator::make($request->all(), [
                'profile_pic' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(['error'=>$validator->errors()], 401);
            }
            
            $profilepic = time().'.'.$request->profile_pic->extension();
            $request->profile_pic->move(public_path('/tenants/tenantprofilepic'), $profilepic);

            $user = User::findorfail($id);
            $user->profile_pic = "/tenants/tenantprofilepic/".$profilepic;
            $user->save();

            $data['status'] = 'Success';
            $data['message'] = 'Profile Pic Uploaded Successfully';
            $data['profile_pic'] = "/tenants/tenantprofilepic/".$profilepic;
            
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
