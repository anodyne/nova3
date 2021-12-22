<?php

declare(strict_types=1);

namespace Nova\Posts\Data;

use Spatie\LaravelData\Data;

class PostStatusData extends Data
{
    public function __construct(
        public string $status
    ) {
    }
}
