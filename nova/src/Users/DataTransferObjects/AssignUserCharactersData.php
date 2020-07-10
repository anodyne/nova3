<?php

namespace Nova\Users\DataTransferObjects;

use Illuminate\Http\Request;
use Nova\Characters\Models\Character;
use Spatie\DataTransferObject\DataTransferObject;

class AssignUserCharactersData extends DataTransferObject
{
    /**
     * @var  array
     */
    public $characters;

    /**
     * @var  Character
     */
    public $primaryCharacter;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'characters' => ($request->characters) ? explode(',', $request->characters) : [],
            'primaryCharacter' => Character::find($request->primary_character),
        ]);
    }
}
