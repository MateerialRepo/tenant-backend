<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequest;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    //fetches all properties
    public function index()
    {
        $user = Auth::user();
        $properties = Property::where('user_id', $user->id)->get();
        $data['status'] = 'Success';
        $data['message'] = 'Fetched all properties Successfully';
        $data['properties'] = $properties;
        return response()->json($data, 200);
    }

    //fetches a single property
    public function getProperty($id)
    {
        $property = Property::find($id);
        $data['status'] = 'Success';
        $data['message'] = 'Fetched property Successfully';
        $data['property'] = $property;
        return response()->json($data, 200);
    }

    //save property
    public function createAndUpdateProperty(StorePropertyRequest $request)
    {
        try{
            $images=[];

            if($request->has('property_images')){

                foreach($request->file('property_images') as $image){
                    
                    // save each image to the server
                    $imageName = "property".time().'.'.$image->getClientOriginalExtension();
                    $image->move(public_path('/properties/propertyImages'), $imageName);
                    $images[] = '/properties/propertyImages'.$imageName;
                };

            };

            $user = Auth::user();
            $property_data = $request->all();
            $property_data['user_id'] = $user->id;
            $property_data['verified'] = 'unverified';
            $property_data['property_images'] = $images;

            $property = Property::updateOrCreate($property_data);
            $data['status'] = 'Success';
            $data['message'] = 'Property Successfully Created';
            $data['data'] = $property;
            return response()->json($data, 200);

        } catch (\Exception $exception) {

            $data['status'] = 'Failed';
            $data['message'] = $exception->getMessage();
            return response()->json($data, 400);
        }
    }

    

} 