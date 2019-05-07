<?php

namespace Nova\Users\Http\Validators;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class Update extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['nullable'],
            'email' => ['nullable', 'email', 'unique:users,email'],
        ];
    }
}
