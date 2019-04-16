<?php

namespace Nova\Users\Http\Requests;

use Nova\Foundation\Http\Requests\BaseFormRequest;

class Update extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => ['nullable'],
            'email' => ['nullable', 'email', 'unique:users,email'],
        ];
    }
}
