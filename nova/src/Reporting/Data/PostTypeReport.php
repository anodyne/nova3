<?php

declare(strict_types=1);

namespace Nova\Reporting\Data;

use Bag\Bag;
use Illuminate\Database\Eloquent\Collection;
use Nova\Stories\Models\PostType;

/**
 * @method static static from(?Collection<int, PostType> $results)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class PostTypeReport extends Bag
{
    public function __construct(
        /** @var Collection<int, PostType>|null */
        public ?Collection $results
    ) {}
}
