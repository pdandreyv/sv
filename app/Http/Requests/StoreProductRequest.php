<?php

namespace App\Http\Requests;

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
            'title' => 'required', 
            'description' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric|min:'.(int)request('cooperative_price'),
            'cooperative_price' => 'required|numeric',
            'quantity' => 'nullable|numeric',
            'weight' => 'nullable|numeric'
        ];
        $is_service = $this->request->get('is_service');
        if(!$is_service){
            $rules['production_place'] = 'required';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'title.required' => 'Поле "Название" обязательно для заполнения.',
            'description.required' => 'Поле "Описание" обязательно для заполнения.',
            'category_id.required' => 'Выберите категорию.',
            'price.required' => 'Поле "Цена" обязательно для заполнения.',
            'price.numeric' => 'Значение поля "Цена"" должно быть числом.',
            'price.min:'.(int)request('cooperative_price') => 'Цена должна быть не меньше значения поля "Цена для кооператива".',
            'cooperative_price.required' => 'Поле "Цена для кооператива" обязательно для заполнения.',
            'cooperative_price.numeric' => 'Значение поля "Цена для кооператива" должно быть числом.',
            'quantity.numeric' => 'Значение поля "Количество" должно быть числом.',
            'weight.numeric' => 'Значение поля "Вес" должно быть числом.',
            'production_place.required' => 'Поле "Место производства" обязательно для заполнения.'
        ];
    }

}