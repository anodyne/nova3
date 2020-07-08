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

    /**
     * @var  int
     */
    public $rank_id;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'name' => $request->name,
            'rank_id' => $request->rank_id,
        ]);
    }
}
