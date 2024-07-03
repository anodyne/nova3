<?php

declare(strict_types=1);

namespace Nova\Users\Requests;

use Nova\Forms\Models\Form;
use Nova\Foundation\Http\Requests\ValidatesRequest;
use Nova\Users\Data\AssignUserCharactersData;
use Nova\Users\Data\AssignUserRolesData;
use Nova\Users\Data\UserData;

class StoreUserRequest extends ValidatesRequest
{
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'unique:users,email'],
            'name' => ['required'],
            'pronouns.value' => ['required', 'in:none,male,female,neutral,neo,other'],
            'pronouns.subject' => ['required_if:pronouns.value,other'],
            'pronouns.object' => ['required_if:pronouns.value,other'],
            'pronouns.possessive' => ['required_if:pronouns.value,other'],
        ];
    }

    public function messages()
    {
        return array_merge(
            [
                'pronouns.value.required' => 'Please select from one of the available pronouns',
                'pronouns.value.in' => 'Pronouns must be one of the provided options',
                'pronouns.subject.required_if' => 'Please enter the subject pronoun the user uses',
                'pronouns.object.required_if' => 'Please enter the object pronoun the user uses',
                'pronouns.possessive.required_if' => 'Please enter the possessive pronoun the user uses',
            ],
            Form::key('user')->first()->validation_messages,
        );
    }

    public function getUserData(): UserData
    {
        return UserData::from($this);
    }

    public function getUserCharactersData(): AssignUserCharactersData
    {
        return AssignUserCharactersData::from($this);
    }

    public function getUserRolesData(): AssignUserRolesData
    {
        return AssignUserRolesData::from($this);
    }
}
