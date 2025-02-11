<?php

declare(strict_types=1);

namespace Nova\Reporting\Data;

use Bag\Bag;
use Illuminate\Database\Eloquent\Collection;

/**
 * @method static static from(?Collection $results)
 */
readonly class PostTypeReport extends Bag
{
    public function __construct(
        public ?Collection $results
    ) {}
}
