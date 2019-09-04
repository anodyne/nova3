<?php

namespace Nova\Users\Http\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class Store extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
        ];
    }
}
