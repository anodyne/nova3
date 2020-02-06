<?php

namespace Nova\Users\Http\Requests;

use Nova\Foundation\Rules\MaxFileSize;
use Nova\Foundation\Http\Requests\ValidatesRequest;

class ValidateUpdateUser extends ValidatesRequest
{
    // public function validationData()
    // {
    //     dd($this->all());
    // }

    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'avatar' => ['nullable', 'mimes:jpeg,png,gif', new MaxFileSize],
        ];
    }
}
