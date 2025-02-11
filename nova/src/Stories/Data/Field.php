<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Bag\Bag;

/**
 * @method static static from(bool $enabled, bool $required)
 */
readonly class Field extends Bag
{
    public function __construct(
        public bool $enabled,
        public bool $required,
    ) {}
}
