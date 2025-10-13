<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserPost extends FormRequest
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
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->id, 'id')
            ],
            'alias' => [
                'nullable',
                'regex:/^[a-z0-9\-_]*$/',
                Rule::unique('users')->ignore($this->id, 'id')
            ],
        ];
    }
}
