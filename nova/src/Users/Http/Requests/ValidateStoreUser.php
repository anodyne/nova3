<?php

namespace Nova\Users\Http\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class ValidateStoreUser extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
        ];
    }
}
