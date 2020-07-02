<?php

namespace Nova\Users\Requests;

use Illuminate\Validation\Rule;
use Nova\Foundation\Rules\MaxFileSize;
use Nova\Foundation\Requests\ValidatesRequest;

class UpdateUserRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->user),
            ],
            'pronouns' => ['required', 'in:male,female,neutral'],
            'avatar' => ['nullable', 'mimes:jpeg,png,gif', new MaxFileSize],
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
