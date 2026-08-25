<?php

declare(strict_types=1);

namespace Nova\Pages\Data;

use Bag\Bag;

/**
 * @method static static from(list<array{type: string, data: array<string, mixed>}> $blocks)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class PageBlocksData extends Bag
{
    /**
     * @param  list<array{type: string, data: array<string, mixed>}>  $blocks
     */
    public function __construct(
        public array $blocks
    ) {}
}
