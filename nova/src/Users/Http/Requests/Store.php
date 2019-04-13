<?php

namespace Nova\Users\Http\Requests;

use Nova\Foundation\Http\Requests\BaseFormRequest;

class Store extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
        ];
    }
}
