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
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->user),
            ],
            'name' => ['required'],
            'pronouns.value' => ['required', 'in:none,male,female,neutral,neo,other'],
            'pronouns.subject' => ['required_if:pronouns.value,other'],
            'pronouns.object' => ['required_if:pronouns.value,other'],
            'pronouns.possessive' => ['required_if:pronouns.value,other'],
        ];
    }

    public function messages()
    {
        return [
            'pronouns.value.required' => 'Please select from one of the available pronouns',
            'pronouns.value.in' => 'Pronouns must be one of the provided options',
            'pronouns.subject.required_if' => 'Please enter the subject pronoun the user uses',
            'pronouns.object.required_if' => 'Please enter the object pronoun the user uses',
            'pronouns.possessive.required_if' => 'Please enter the possessive pronoun the user uses',
        ];
    }
}
