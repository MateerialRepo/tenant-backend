<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'property_type' => 'required',
            'property_amount' => 'required',
            'property_images' => 'required',
            'property_images.*' => 'mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
            'bedrooms' => 'required',
            'bathrooms' => 'required',
            'serviced' => 'required',
            'parking' => 'required',
            'availability' => 'required',
            'year_built' => 'required',
            'street' => 'required',
            'lga' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zipcode' => 'required',
        ];
    }

   
    // public function messages()
    // {
    //     return [
    //         'title.required' => 'Property Title is required',
    //         'property_type.required' => 'Property Type is required',
    //         'property_amount.required' => 'Property Amount is required',
    //         'property_images.*.mimes' => 'Property Image must be a file of type: jpeg,png,jpg,gif,svg,pdf',
    //         'property_images.*.max' => 'Property Image must be less than 2MB',
    //         'bedrooms.required' => 'Bedrooms is required',
    //         'bathrooms.required' => 'Bathrooms is required',
    //         'serviced.required' => 'Serviced is required',
    //         'parking.required' => 'Parking is required',
    //         'availability.required' => 'Availability is required',
    //         'year_built.required' => 'Year Built is required',
    //         'street.required' => 'Street is required',
    //         'lga.required' => 'LGA is required',
    //         'state.required' => 'State is required',
    //         'country.required' => 'Country is required',
    //         'zipcode.required' => 'Zipcode is required',
    //     ];
    // }
    
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
        'errors' => $validator->errors(),
        'status' => true
        ], 422));
    }
}
