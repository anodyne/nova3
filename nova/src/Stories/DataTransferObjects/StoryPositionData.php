<?php

declare(strict_types=1);

namespace Nova\Stories\DataTransferObjects;

use Illuminate\Http\Request;
use Nova\Stories\Models\Story;
use Spatie\DataTransferObject\DataTransferObject;

class StoryPositionData extends DataTransferObject
{
    public ?string $direction;

    public ?Story $neighbor;

    public bool $hasPositionChange;

    public ?int $parent_id;

    public static function fromRequest(Request $request): self
    {
        return new self(
            direction: $request->display_direction,
            neighbor: Story::find($request->display_neighbor),
            hasPositionChange: (bool) $request->has_position_change,
            parent_id: (int) $request->parent_id,
        );
    }
}
