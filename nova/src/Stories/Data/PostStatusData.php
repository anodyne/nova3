<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Spatie\LaravelData\Data;

class PostStatusData extends Data
{
    public function __construct(
        public string $status
    ) {
    }
}
