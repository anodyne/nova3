<?php

declare(strict_types=1);

namespace Nova\Characters\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class AssignCharacterPositionsData extends DataTransferObject
{
    public array $positions;

    public ?int $primaryPosition;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'positions' => explode(',', $request->positions),
            'primaryPosition' => (int) $request->primary_position,
        ]);
    }
}
