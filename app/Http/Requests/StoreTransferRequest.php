<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Factory as ValidationFactory;
use App\UserBalance;
use Auth;

class StoreTransferRequest extends FormRequest
{
    public function __construct(ValidationFactory $validationFactory)
    {

        $validationFactory->extend(
            'balance',
            function ($attribute, $value, $parameters)
            {            
                $currentBalance = UserBalance::where('user_id', Auth::user()->id)->first();
                if(!$currentBalance){
                    return false;
                }                
                return $value <= $currentBalance->sum;
            },
            'Sum of transfer more than your balance rest!'
        );

    }
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
            'sum' => [
                'required',
                'numeric',
                'balance'
            ],            
        ];
    }
}
