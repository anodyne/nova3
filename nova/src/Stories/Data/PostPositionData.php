<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Bag\Bag;
use Nova\Stories\Enums\PositionDirection;
use Nova\Stories\Models\Post;

/**
 * @method static static from(PositionDirection $direction, ?Post $neighbor, bool $hasPositionChange)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class PostPositionData extends Bag
{
    public function __construct(
        public PositionDirection $direction,
        public ?Post $neighbor,
        public bool $hasPositionChange,
    ) {}

    public function moveMethodName(): string
    {
        return match ($this->direction) {
            PositionDirection::After => 'moveAfter',
            PositionDirection::Before => 'moveBefore',
            PositionDirection::End => 'moveToEnd',
            PositionDirection::Start => 'moveToStart',
        };
    }
}
