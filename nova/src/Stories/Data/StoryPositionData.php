<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Bag\Attributes\MapInputName;
use Bag\Attributes\Transforms;
use Bag\Bag;
use Bag\Mappers\Alias;
use Illuminate\Http\Request;
use Nova\Stories\Enums\PositionDirection;
use Nova\Stories\Models\Story;

/**
 * @method static static from(PositionDirection $direction, ?Story $neighbor, bool $hasPositionChange)
 */
readonly class StoryPositionData extends Bag
{
    public function __construct(
        #[MapInputName(Alias::class, 'display_direction')]
        public PositionDirection $direction,

        #[MapInputName(Alias::class, 'display_neighbor')]
        public ?Story $neighbor,

        #[MapInputName(Alias::class, 'has_position_change')]
        public bool $hasPositionChange = false
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'direction' => PositionDirection::tryFrom($request->input('display_direction')) ?? PositionDirection::After,
            'neighbor' => Story::find($request->input('display_neighbor')),
            'hasPositionChange' => $request->boolean('has_position_change', false),
        ];
    }
}
