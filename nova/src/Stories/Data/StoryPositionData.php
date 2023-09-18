<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Illuminate\Http\Request;
use Nova\Stories\Enums\StoryPosition;
use Nova\Stories\Models\Story;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class StoryPositionData extends Data
{
    public function __construct(
        #[MapInputName('display_direction')]
        public ?StoryPosition $direction,

        #[MapInputName('display_neighbor')]
        public ?Story $neighbor,

        #[MapInputName('has_position_change')]
        public bool $hasPositionChange = false
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            direction: StoryPosition::tryFrom($request->input('display_direction', 'before')),
            neighbor: Story::find($request->input('display_neighbor')),
            hasPositionChange: $request->boolean('has_position_change', false)
        );
    }
}
