<?php

declare(strict_types=1);

namespace Nova\Users\Requests;

use Illuminate\Validation\Rule;
use Nova\Foundation\Requests\ValidatesRequest;
use Nova\Foundation\Rules\MaxFileSize;

class UpdateUserRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'avatar' => ['nullable', 'mimes:jpeg,png,gif', new MaxFileSize()],
            'characters' => ['nullable'],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->user),
            ],
            'name' => ['required'],
            'primary_character' => ['nullable'],
            'pronouns' => ['required', 'in:male,female,neutral'],
        ];
    }

    public function messages()
    {
        return [
            'pronouns.required' => 'Please select from one of the available pronouns',
            'pronouns.required' => 'Preferred pronoun must be one of the provided options',
        ];
    }
}
