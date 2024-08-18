<?php

declare(strict_types=1);

namespace Nova\PublicSite\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Characters\Data\AssignCharacterPositionsData;
use Nova\Characters\Data\CharacterData;
use Nova\Forms\Models\Form;

class StoreApplicationRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'userInfo.name' => ['required'],
            'userInfo.email' => ['required', 'email'],
            'userInfo.password' => ['required'],

            'characterInfo.name' => ['required'],
            'characterInfo.position' => ['nullable'],
        ];

        $userBioForm = Form::key('userBio')->first();
        $characterBioForm = Form::key('characterBio')->first();
        $applicationInfoForm = Form::key('applicationInfo')->first();

        if (filled($userBioForm->published_fields)) {
            $rules = array_merge($rules, $userBioForm->validation_rules);
        }

        if (filled($characterBioForm->published_fields)) {
            $rules = array_merge($rules, $characterBioForm->validation_rules);
        }

        if (filled($applicationInfoForm->published_fields)) {
            $rules = array_merge($rules, $applicationInfoForm->validation_rules);
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'userInfo.name' => [
                'required' => 'User name is required',
            ],
            'userInfo.email' => [
                'required' => 'Email address is required',
                'email' => 'Must be a valid email address',
            ],
            'userInfo.password' => [
                'required' => 'Password is required',
            ],

            'characterInfo.name' => [
                'required' => 'Character name is required',
            ],
        ];

        $userBioForm = Form::key('userBio')->first();
        $characterBioForm = Form::key('characterBio')->first();
        $applicationInfoForm = Form::key('applicationInfo')->first();

        if (filled($userBioForm->published_fields)) {
            $messages = array_merge($messages, $userBioForm->validation_messages);
        }

        if (filled($characterBioForm->published_fields)) {
            $messages = array_merge($messages, $characterBioForm->validation_messages);
        }

        if (filled($applicationInfoForm->published_fields)) {
            $messages = array_merge($messages, $applicationInfoForm->validation_messages);
        }

        return $messages;
    }

    public function getCharacterData(): CharacterData
    {
        return CharacterData::from($this->input('characterInfo'));
    }

    public function getCharacterPositionData(): AssignCharacterPositionsData
    {
        return AssignCharacterPositionsData::from($this->input('characterInfo'));
    }
}
