<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        $rules = [ 
            'user_id' => 'required',                    
            'title' => 'required', 
            'description' => 'required',            
            'price' => 'numeric|required|min:'.(int)request('cooperative_price'),
            'cooperative_price' => 'numeric|required',
            'weight' => 'nullable|numeric'
        ];

        $is_service = $this->request->get('is_service');
        if(!$is_service){
            $rules['production_place'] = 'required';
        }

        return $rules;
    }     

}