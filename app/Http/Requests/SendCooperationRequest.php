<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SendCooperationRequest extends FormRequest
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
            'last_name' => [
                'required',
            ],
            'first_name' => [
                'required',
            ],
            'middle_name' => [
                'required',
            ],
            'birth_day' => [
                'required',
            ],
            'birth_mounth' => [
                'required',
            ],
            'birth_year' => [
                'required',
            ],
            'gender' => [
                'required',
            ],
            'city' => [
                'required',
            ],
            'phone_number' => [
                'required',
            ],
            'passport_series' => [
                'required',
            ],
            'passport_number' => [
                'required',
            ],
            'passport_give' => [
                'required',
            ],
            'passport_give_date' => [
                'required',
            ],
            'registration_address' => [
                'required',
            ],
            'identification_code' => [
                'required',
            ],
            'page1_file' => [
                'required',
            ],
            'page2_file' => [
                'required',
            ],
            'page3_file' => [
                'required',
            ],
            'ic_file' => [
                'required',
            ],
            
        ];
    }
}
