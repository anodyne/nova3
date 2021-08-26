<?php

declare(strict_types=1);

namespace Nova\Users\Requests;

use Nova\Foundation\Requests\ValidatesRequest;

class CreateUserRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'characters' => ['nullable'],
            'email' => ['required', 'email', 'unique:users,email'],
            'name' => ['required'],
            'primary_character' => ['nullable'],
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
