<?php

declare(strict_types=1);

namespace Nova\Characters\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Characters\Data\AssignCharacterOwnersData;
use Nova\Characters\Data\AssignCharacterPositionsData;
use Nova\Characters\Data\CharacterData;
use Nova\Forms\Models\Form;

class UpdateCharacterRequest extends FormRequest
{
    public function rules(): array
    {
        return array_merge(
            [
                'name' => ['required'],
                'rank_id' => ['nullable'],
            ],
            Form::key('characterBio')->first()->validation_rules,
        );
    }

    public function messages(): array
    {
        return array_merge(
            [
                'name.required' => ':attribute is required',
            ],
            Form::key('characterBio')->first()->validation_messages,
        );
    }

    public function getCharacterData(): CharacterData
    {
        return CharacterData::from($this);
    }

    public function getCharacterOwnersData(): AssignCharacterOwnersData
    {
        return AssignCharacterOwnersData::from($this);
    }

    public function getCharacterPositionsData(): AssignCharacterPositionsData
    {
        return AssignCharacterPositionsData::from($this);
    }
}
