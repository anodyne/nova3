<?php

namespace Nova\Stories\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class StoryPositionData extends DataTransferObject
{
    public ?string $displayDirection;

    public ?int $displayNeighbor;

    public bool $hasPositionChange;

    public ?int $parent_id;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'displayDirection' => $request->display_direction,
            'displayNeighbor' => (int) $request->display_neighbor,
            'hasPositionChange' => (bool) $request->has_position_change,
            'parent_id' => (int) $request->parent_id,
        ]);
    }
}
