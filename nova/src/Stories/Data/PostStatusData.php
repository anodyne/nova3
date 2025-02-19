<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Bag\Bag;

/**
 * @method static static from(string $status)
 */
readonly class PostStatusData extends Bag
{
    public function __construct(
        public string $status
    ) {}
}
