<?php

namespace Nova\Users\Http\Requests;

use Nova\Foundation\Rules\MaxFileSize;
use Nova\Foundation\Http\Requests\ValidatesRequest;

class ValidateUpdateUser extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'gender' => ['required', 'in:male,female,neutral'],
            'avatar' => ['nullable', 'mimes:jpeg,png,gif', new MaxFileSize],
        ];
    }

    public function messages()
    {
        return [
            'gender.required' => 'Please select from one of the available pronouns',
            'gender.required' => 'Preferred pronoun must be one of the provided options',
        ];
    }
}
