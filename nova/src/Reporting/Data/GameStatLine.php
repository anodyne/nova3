<?php

declare(strict_types=1);

namespace Nova\Reporting\Data;

use Bag\Bag;

/**
 * @method static static from(string $label, ?string $currentTimeframe, ?string $lastMonth, ?string $thisMonth, ?string $lifetime)
 */
readonly class GameStatLine extends Bag
{
    public function __construct(
        public string $label,
        public ?string $currentTimeframe,
        public ?string $lastMonth,
        public ?string $thisMonth,
        public ?string $lifetime,
    ) {}
}
