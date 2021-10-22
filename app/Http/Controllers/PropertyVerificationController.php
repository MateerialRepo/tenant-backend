<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyVerification;
use Illuminate\Http\Request;

class PropertyVerificationController extends Controller
{
    //verify property
    public function verifyProperty(Request $request, $id)
    {
        $documentPath=[];
        if($request->has('property_document')){

            foreach($request->file('property_document') as $key => $document){
                $fileName = $document->getClientOriginalName();
                $document->move(public_path('/properties/propertyDocuments'), $fileName);
                $filepath = '/properties/propertyDocuments/'.$fileName;
                $documentPath[$key] = $filepath;
            }
        }

        $propertyVerification = PropertyVerification::create([
            'property_id' => $id,
            'verification_type' => $request->verification_type,
            'property_document' => $documentPath,
            'description' => $request->description,
        ]);


        $property = Property::find($id);
        $property->verified = "verified";
        $property->save();

        $data['status'] = 'Success';
        $data['message'] = 'Property Successfully Verified';
        return response()->json($data, 201);
    }
    
}
