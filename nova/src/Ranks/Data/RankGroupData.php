<?php

declare(strict_types=1);

namespace Nova\Ranks\Data;

use Spatie\LaravelData\Data;

class RankGroupData extends Data
{
    public function __construct(
        public string $name
    ) {
    }
}
