<?php

namespace Nova\Characters\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class AssignCharacterOwnersData extends DataTransferObject
{
    public array $users;

    public ?array $primaryCharacters;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'primaryCharacters' => $request->input('primary_character', []),
            'users' => ($request->users) ? explode(',', $request->users) : [],
        ]);
    }
}
