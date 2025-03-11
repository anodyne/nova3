<?php

declare(strict_types=1);

namespace Nova\Pages\Data;

use Bag\Bag;

/**
 * @method static static from(array $blocks)
 */
readonly class PageBlocksData extends Bag
{
    public function __construct(
        public array $blocks
    ) {}
}
