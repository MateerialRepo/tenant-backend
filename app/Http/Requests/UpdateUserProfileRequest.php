<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
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
            'first_name' => 'required|string' ,
            'last_name' => 'required|string' ,
            'phone_number' => 'required|numeric' ,
            'email' => 'required|email',
            'dob' => 'required|date|nullable',
            'occupation' => 'required|string|nullable',
            'gender' => 'required|string',
            'address' => 'required|string|nullable',
            'landmark' => 'required|string|nullable',
            'state' => 'required|string|nullable',
            'country' => 'required|string|nullable'
        ];
    }
}
