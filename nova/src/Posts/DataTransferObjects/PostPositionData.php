<?php

declare(strict_types=1);

namespace Nova\Posts\DataTransferObjects;

use Nova\Posts\Models\Post;
use Spatie\DataTransferObject\DataTransferObject;

class PostPositionData extends DataTransferObject
{
    public ?string $direction;

    public bool $hasPositionChange;

    public ?Post $neighbor;

    public static function fromArray(array $array): self
    {
        return new self(
            direction: data_get($array, 'displayDirection'),
            neighbor: Post::find(data_get($array, 'displayNeighbor')),
            hasPositionChange: (bool) data_get($array, 'hasPositionChange', false),
        );
    }
}
