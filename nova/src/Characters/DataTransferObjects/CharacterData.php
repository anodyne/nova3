<?php

namespace Nova\Characters\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class CharacterData extends DataTransferObject
{
    /**
     * @var  string
     */
    public $name;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'name' => $request->name,
        ]);
    }
}
