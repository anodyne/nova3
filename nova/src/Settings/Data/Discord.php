<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Bag\Bag;

/**
 * @method static static from(?string $color, ?string $webhook)
 */
readonly class Discord extends Bag
{
    public function __construct(
        public ?string $color,
        public ?string $webhook,
    ) {}
}
