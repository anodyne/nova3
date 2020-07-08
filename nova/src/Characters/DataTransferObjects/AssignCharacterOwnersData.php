<?php

namespace Nova\Characters\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class AssignCharacterOwnersData extends DataTransferObject
{
    /**
     * @var  array
     */
    public $users;

    /**
     * @var  array
     */
    public $primaryCharacters;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'users' => ($request->users) ? explode(',', $request->users) : [],
            'primaryCharacters' => $request->input('primary_character', []),
        ]);
    }
}
