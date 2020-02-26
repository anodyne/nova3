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
            'gender' => ['required', 'in:male,female,neutral'],
        ];
    }

    public function messages()
    {
        return [
            'gender.required' => 'Please select from one of the available pronouns',
            'gender.in' => 'Preferred pronoun must be one of the provided options',
        ];
    }
}
