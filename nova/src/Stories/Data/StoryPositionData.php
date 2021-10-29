<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Illuminate\Http\Request;
use Nova\Stories\Models\Story;
use Spatie\LaravelData\Data;

class StoryPositionData extends Data
{
    public function __construct(
        public ?string $direction,
        public ?Story $neighbor,
        public bool $hasPositionChange
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            direction: $request->input('display_direction'),
            neighbor: Story::find($request->input('display_neighbor')),
            hasPositionChange: (bool) $request->input('has_position_change')
        );
    }
}
