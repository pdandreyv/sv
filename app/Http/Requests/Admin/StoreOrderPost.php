<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderPost extends FormRequest
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
            'to_user_id' => [
                'required',
            ],  
            'shipping_adress' => 'required_without:address_id',
            'address_id' => 'required_without:shipping_adress',      
        ];    
    }
}