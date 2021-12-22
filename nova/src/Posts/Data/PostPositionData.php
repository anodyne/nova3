<?php

declare(strict_types=1);

namespace Nova\Posts\Data;

use Nova\Posts\Models\Post;
use Spatie\LaravelData\Data;

class PostPositionData extends Data
{
    public function __construct(
        public ?string $direction,
        public bool $hasPositionChange,
        public ?Post $neighbor,
    ) {
    }

    public static function fromArray(array $array): static
    {
        return new self(
            direction: data_get($array, 'displayDirection'),
            neighbor: Post::find(data_get($array, 'displayNeighbor')),
            hasPositionChange: (bool) data_get($array, 'hasPositionChange', false),
        );
    }
}
