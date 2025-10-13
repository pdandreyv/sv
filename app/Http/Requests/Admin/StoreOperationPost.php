<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\FinanceOperations\Operation;
use Illuminate\Validation\Factory as ValidationFactory;
use App\UserBalance;

class StoreOperationPost extends FormRequest
{
    public function __construct(ValidationFactory $validationFactory)
    {        
        $validationFactory->extend(
            'balance',
            function ($attribute, $value, $parameters, $validator)
            {                 
                $currentBalance = UserBalance::where('user_id', $validator->getData()['user_id'])->first();                
                if(!$currentBalance){
                    return false;
                }                
                return $value <= $currentBalance->sum;
            }
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
        $rules = [
            'user_id' => 'required',
            'sum' => ['required'],                    
            'operation_type_id' => 'required',             
        ];

        $operation_type_id = $this->request->get('operation_type_id');

        $operationType = Operation::find($operation_type_id);

        if ($operationType->code == 'user_money_transfer') {
            $rules['user_to_id'] = 'required';
            $rules['sum'][] = 'balance';
        }

        return $rules;
    }
}