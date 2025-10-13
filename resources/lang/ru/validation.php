<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'Длина значения поля ":attribute" не должна превышать :max.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'Значение поля ":attribute" должно быть не ниже :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'Длина значения поля ":attribute" должна быть минимум :min.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => '":attribute" должен иметь числовое значение.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'Значение поля ":attribute" заданно в некорректом формате.',
    'required'             => 'Поле ":attribute" обязательно к заполнению.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'Значение поля ":attribute" является обязательным когда заполнено поле ":values".',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'Поле ":attribute" обязательно к заполнению, когда поле ":values" пустое.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'Значения полей ":attribute" и ":other" должны совпадать.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'Значение поля ":attribute" уже установленно для другой записи.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',
    /*custom*/
    'balance'              => 'Сумма перевода превышает размер остатка балансе отправителя',
    'auth_user_password'   => 'Введенный вами пароль не валидный', 

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'template_id' => 'Шаблон',
        'alias' => 'Алиас',
        'subject' => 'Тема',
        'body' => 'Контент',
        'user_id' => 'Пользователь',
        'sum' => 'Сумма',                    
        'operation_type_id' => 'Тип операции',
        'user_to_id' => 'Кому',
        'title' => 'Наименование',                                   
        'description' => 'Описание',            
        'price' => 'Цена',
        'cooperative_price' => 'Цена для кооператива',
        'weight' => 'Вес',
        'production_place' => 'Место производства',
        'name' => 'Имя',
        'email' => 'E-mail',
        'code' => 'Код',
        'post_title' => 'Заголовок записи',
        'post_content' => 'Содержимое записи',
        'last_name' => 'Фамилия',
        'first_name' => 'Имя',
        'middle_name' => 'Отчество',
        'birth_day' => 'День рождения',
        'birth_mounth' => 'Месяц рождения',
        'birth_year' => 'Год рождения',
        'gender' => 'Пол',
        'passport_series' => 'Серия паспорта',
        'passport_number' => 'Номер паспорта',
        'passport_give' => 'Кем выдан',
        'passport_give_date' => 'Дата выдачи паспорта',
        'registration_address' => 'Адрес прописки',
        'identification_code' => 'Идентификационный код',
        'page1_file' => 'Скан первой страницы',
        'page2_file' => 'Скан второй странцы',
        'page3_file' => 'Скан третьей страницы',
        'ic_file' => 'Скан идентификационного кода',
        'text' => 'Текст',
        'message' => 'Сообщение',
        'phone' => 'Телефон',
        'to_user_id' => 'Получатель',
        'address_id' => 'Адрес доставки',
        'shipping_adress' => 'Новый адрес доставки',
        'ups1_id' => 'УПС1'
    ],

];
