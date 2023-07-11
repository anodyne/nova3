<?php

declare(strict_types=1);

namespace Nova\Characters\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Characters\Data\AssignCharacterOwnersData;
use Nova\Characters\Data\AssignCharacterPositionsData;
use Nova\Characters\Data\CharacterData;

class CreateCharacterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'rank_id' => ['nullable'],
        ];
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
