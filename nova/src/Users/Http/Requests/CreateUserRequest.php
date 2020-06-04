<?php

namespace Nova\Users\Http\Requests;

use Nova\Foundation\Http\Requests\ValidatesRequest;

class CreateUserRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'pronouns' => ['required', 'in:male,female,neutral'],
        ];
    }

    public function messages()
    {
        return [
            'pronouns.required' => 'Please select from one of the available pronouns',
            'pronouns.in' => 'Preferred pronoun must be one of the provided options',
        ];
    }
}
