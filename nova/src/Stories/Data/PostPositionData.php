<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Bag\Bag;
use Nova\Stories\Enums\PositionDirection;
use Nova\Stories\Models\Post;

/**
 * @method static static from(PositionDirection $direction, ?Post $neighbor, bool $hasPositionChange)
 */
readonly class PostPositionData extends Bag
{
    public function __construct(
        public PositionDirection $direction,
        public ?Post $neighbor,
        public bool $hasPositionChange,
    ) {}

    public static function fromArray(array $array): static
    {
        return new self(
            direction: data_get($array, 'direction'),
            neighbor: Post::find(data_get($array, 'neighbor')),
            hasPositionChange: (bool) data_get($array, 'hasPositionChange', false),
        );
    }
}
