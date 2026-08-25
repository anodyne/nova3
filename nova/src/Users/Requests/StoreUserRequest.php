<?php

declare(strict_types=1);

namespace Nova\Users\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Nova\Forms\Models\Form;
use Nova\Media\Rules\MaxFileSize;
use Nova\Users\Data\AssignUserCharactersData;
use Nova\Users\Data\AssignUserRolesData;
use Nova\Users\Data\UserData;

class StoreUserRequest extends FormRequest
{
    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return array_merge(
            [
                'avatar' => ['nullable', 'mimes:jpeg,png,gif', new MaxFileSize],
                'email' => ['required', 'email', 'unique:users,email'],
                'name' => ['required'],
                'pronouns.value' => ['required', 'in:none,male,female,neutral,neo,other'],
                'pronouns.subject' => ['required_if:pronouns.value,other'],
                'pronouns.object' => ['required_if:pronouns.value,other'],
            ],
            Form::key('userBio')->first()->validation_rules,
        );
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return array_merge(
            [
                'pronouns.value.required' => 'Please select from one of the available pronouns',
                'pronouns.value.in' => 'Pronouns must be one of the provided options',
                'pronouns.subject.required_if' => 'Please enter the subject pronoun the user uses',
                'pronouns.object.required_if' => 'Please enter the object pronoun the user uses',
            ],
            Form::key('userBio')->first()->validation_messages,
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
