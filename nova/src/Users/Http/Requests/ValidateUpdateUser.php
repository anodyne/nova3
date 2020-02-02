<?php

namespace Nova\Users\Http\Requests;

use Nova\Foundation\Rules\MaxFileSize;
use Nova\Foundation\Http\Requests\ValidatesRequest;

class ValidateUpdateUser extends ValidatesRequest
{
    public function rules()
    {
        return [
            'nickname' => ['required'],
            'email' => ['required', 'email'],
            'image' => ['nullable', 'mimes:jpeg,png,gif', new MaxFileSize],
        ];
    }
}
