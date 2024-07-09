<?php

declare(strict_types=1);

namespace Nova\Pages\Data;

use Spatie\LaravelData\Data;

class PageBlocksData extends Data
{
    public function __construct(
        public array $blocks
    ) {}
}
