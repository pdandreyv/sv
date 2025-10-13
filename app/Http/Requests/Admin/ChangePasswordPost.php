<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;
use Illuminate\Validation\Factory as ValidationFactory;
use Hash;
use App\Http\Requests\Admin\ChangePasswordPost;

class ChangePasswordPost extends FormRequest
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
            'my_password' => 'required|auth_user_password',
            'password' => 'required|min:6',
            'password_confirm' => 'required_with:password|same:password|min:6'
        ];
    }

    public function __construct(ValidationFactory $validationFactory)
    {

        $validationFactory->extend(
            'auth_user_password',
            function ($attribute, $value, $parameters) {
                return Hash::check($value, Auth::user()->password);                
            },
            'Your password incorrect!'
        );

    }
}
