<?php

declare(strict_types=1);

namespace Nova\Reporting\Data;

use Bag\Bag;

/**
 * @method static static from(string $label, ?string $hint, array $stats)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class GameStatCategory extends Bag
{
    public function __construct(
        public string $label,
        public ?string $hint,
        public array $stats
    ) {}
}
