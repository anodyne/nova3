<?php

namespace Nova\Characters\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class AssignCharacterPositionsData extends DataTransferObject
{
    /**
     * @var  array
     */
    public $positions;

    /**
     * @var  string
     */
    public $primaryPosition;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'positions' => explode(',', $request->positions),
            'primaryPosition' => $request->primary_position,
        ]);
    }
}
